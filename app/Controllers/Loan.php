<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\LoanDetailModel;
use App\Models\LoanModel;
use App\Models\MemberModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Loan extends BaseController
{
    /**
     * =========================================================
     * DAFTAR PEMINJAMAN
     * =========================================================
     */
    public function index()
    {
        $loanModel = new LoanModel();

        $loans = $loanModel
            ->select(
                '
                loans.*,
                members.member_code,
                members.name AS member_name
                '
            )

            ->join(
                'members',
                'members.id = loans.member_id'
            )

            ->orderBy(
                'loans.id',
                'DESC'
            )

            ->findAll();


        $data = [
            'title' => 'Data Peminjaman',
            'loans' => $loans,
        ];


        return view(
            'peminjaman/index',
            $data
        );
    }


    /**
     * =========================================================
     * FORM PEMINJAMAN
     * =========================================================
     */
    public function create()
    {
        $memberModel = new MemberModel();

        $bookModel = new BookModel();


        // Hanya anggota aktif
        $members = $memberModel
            ->where(
                'status',
                'active'
            )
            ->orderBy(
                'name',
                'ASC'
            )
            ->findAll();


        // Untuk sementara semua buku ditampilkan.
        // Ketersediaannya akan tetap diperiksa server.
        $books = $bookModel
            ->orderBy(
                'title',
                'ASC'
            )
            ->findAll();


        $data = [
            'title'   => 'Tambah Peminjaman',
            'members' => $members,
            'books'   => $books,
        ];


        return view(
            'peminjaman/create',
            $data
        );
    }


    /**
     * =========================================================
     * SIMPAN TRANSAKSI PEMINJAMAN
     * =========================================================
     */
    public function store()
    {
        // ==========================================
        // 1. VALIDASI FORM
        // ==========================================

        $rules = [

            'member_id' => [
                'rules' =>
                    'required|integer',

                'errors' => [
                    'required' =>
                        'Anggota wajib dipilih.',

                    'integer' =>
                        'Data anggota tidak valid.',
                ],
            ],


            'book_id' => [
                'rules' =>
                    'required|integer',

                'errors' => [
                    'required' =>
                        'Buku wajib dipilih.',

                    'integer' =>
                        'Data buku tidak valid.',
                ],
            ],


            'loan_date' => [
                'rules' =>
                    'required|valid_date[Y-m-d]',

                'errors' => [
                    'required' =>
                        'Tanggal peminjaman wajib diisi.',

                    'valid_date' =>
                        'Tanggal peminjaman tidak valid.',
                ],
            ],


            'due_date' => [
                'rules' =>
                    'required|valid_date[Y-m-d]',

                'errors' => [
                    'required' =>
                        'Tanggal jatuh tempo wajib diisi.',

                    'valid_date' =>
                        'Tanggal jatuh tempo tidak valid.',
                ],
            ],
        ];


        if (! $this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }


        // ==========================================
        // 2. AMBIL INPUT
        // ==========================================

        $memberId = (int)
            $this->request->getPost(
                'member_id'
            );

        $bookId = (int)
            $this->request->getPost(
                'book_id'
            );

        $loanDate = (string)
            $this->request->getPost(
                'loan_date'
            );

        $dueDate = (string)
            $this->request->getPost(
                'due_date'
            );


        // ==========================================
        // 3. VALIDASI TANGGAL
        // ==========================================

        if ($dueDate < $loanDate) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    [
                        'due_date' =>
                            'Tanggal jatuh tempo tidak boleh lebih awal dari tanggal peminjaman.',
                    ]
                );
        }


        // ==========================================
        // 4. PERIKSA ANGGOTA
        // ==========================================

        $memberModel = new MemberModel();

        $member = $memberModel->find(
            $memberId
        );


        if ($member === null) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Data anggota tidak ditemukan.'
                );
        }


        if ($member['status'] !== 'active') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Anggota tidak aktif dan tidak diperbolehkan melakukan peminjaman.'
                );
        }


        // ==========================================
        // 5. MULAI DATABASE TRANSACTION
        // ==========================================

        $db = db_connect();

        $db->transBegin();


        try {

            // ======================================
            // 6. AMBIL & KUNCI DATA BUKU
            // ======================================

            $book = $db
                ->query(
                    '
                    SELECT
                        id,
                        book_code,
                        title,
                        stock_total,
                        stock_available
                    FROM books
                    WHERE id = ?
                    FOR UPDATE
                    ',
                    [
                        $bookId
                    ]
                )
                ->getRowArray();


            if ($book === null) {

                throw new \DomainException(
                    'Data buku tidak ditemukan.'
                );
            }


            // ======================================
            // 7. CEK STOK
            // ======================================

            if (
                (int) $book['stock_available']
                <= 0
            ) {

                throw new \DomainException(
                    'Stok buku sedang habis dan buku tidak dapat dipinjam.'
                );
            }


            // ======================================
            // 8. GENERATE KODE PEMINJAMAN
            // ======================================

            $loanCode =
                'PJ'
                . date('YmdHis')
                . random_int(100, 999);


            // ======================================
            // 9. SIMPAN HEADER TRANSAKSI
            // ======================================

            $loanModel = new LoanModel();


            $loanModel->insert([
                'loan_code' => $loanCode,

                'member_id' => $memberId,

                'loan_date' => $loanDate,

                'due_date' => $dueDate,

                'status' => 'borrowed',
            ]);


            $loanId =
                $loanModel->getInsertID();


            // ======================================
            // 10. SIMPAN DETAIL BUKU
            // ======================================

            $loanDetailModel =
                new LoanDetailModel();


            $loanDetailModel->insert([
                'loan_id' => $loanId,

                'book_id' => $bookId,

                'quantity' => 1,

                'returned_quantity' => 0,
            ]);


            // ======================================
            // 11. KURANGI STOK
            // ======================================

            $newStockAvailable =
                (int) $book['stock_available']
                - 1;


            $db
                ->table('books')

                ->where(
                    'id',
                    $bookId
                )

                ->update([
                    'stock_available' =>
                        $newStockAvailable,

                    'updated_at' =>
                        date('Y-m-d H:i:s'),
                ]);


            // ======================================
            // 12. PERIKSA TRANSACTION
            // ======================================

            if (
                $db->transStatus()
                === false
            ) {

                throw new \RuntimeException(
                    'Database transaction gagal.'
                );
            }


            // ======================================
            // 13. COMMIT
            // ======================================

            $db->transCommit();


            return redirect()
                ->to(
                    site_url(
                        'peminjaman/' . $loanId
                    )
                )
                ->with(
                    'success',
                    'Transaksi peminjaman berhasil disimpan.'
                );


        } catch (\DomainException $e) {

            // Business rule error
            $db->transRollback();


            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );


        } catch (\Throwable $e) {

            // Error sistem
            $db->transRollback();


            log_message(
                'error',
                'Gagal menyimpan peminjaman: {message}',
                [
                    'message' =>
                        $e->getMessage(),
                ]
            );


            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Transaksi gagal diproses. Silakan coba kembali.'
                );
        }
    }


    /**
     * =========================================================
     * DETAIL TRANSAKSI PEMINJAMAN
     * =========================================================
     */
    public function show($id)
    {
        $loanModel = new LoanModel();


        $loan = $loanModel

            ->select(
                '
                loans.*,
                members.member_code,
                members.name AS member_name,
                members.email AS member_email
                '
            )

            ->join(
                'members',
                'members.id = loans.member_id'
            )

            ->where(
                'loans.id',
                $id
            )

            ->first();


        if ($loan === null) {

            throw PageNotFoundException::forPageNotFound(
                'Transaksi peminjaman tidak ditemukan.'
            );
        }


        $db = db_connect();


        $details = $db
            ->table('loan_details')

            ->select(
                '
                loan_details.*,
                books.book_code,
                books.title,
                books.author
                '
            )

            ->join(
                'books',
                'books.id = loan_details.book_id'
            )

            ->where(
                'loan_details.loan_id',
                $id
            )

            ->get()

            ->getResultArray();


        $data = [
            'title'   => 'Detail Peminjaman',
            'loan'    => $loan,
            'details' => $details,
        ];


        return view(
            'peminjaman/show',
            $data
        );
    }
}