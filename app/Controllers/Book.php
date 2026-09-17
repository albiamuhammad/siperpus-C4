<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Book extends BaseController
{
    /**
     * =========================================================
     * MENAMPILKAN DAFTAR BUKU
     * + SEARCH
     * + PAGINATION
     * =========================================================
     */
    public function index()
    {
        $bookModel = new BookModel();


        // ==========================================
        // 1. AMBIL KEYWORD DARI URL
        // ==========================================

        $keyword = trim(
            (string) $this->request->getGet('keyword')
        );


        // ==========================================
        // 2. JIKA ADA KEYWORD, LAKUKAN PENCARIAN
        // ==========================================

        if ($keyword !== '') {

            $bookModel
                ->groupStart()

                ->like(
                    'book_code',
                    $keyword
                )

                ->orLike(
                    'title',
                    $keyword
                )

                ->orLike(
                    'author',
                    $keyword
                )

                ->orLike(
                    'publisher',
                    $keyword
                )

                ->orLike(
                    'category',
                    $keyword
                )

                ->groupEnd();
        }


        // ==========================================
        // 3. AMBIL NOMOR HALAMAN
        // ==========================================

        $currentPage =
            (int) (
                $this->request->getGet('page')
                ?? 1
            );


        // Jangan izinkan halaman kurang dari 1
        if ($currentPage < 1) {
            $currentPage = 1;
        }


        // ==========================================
        // 4. AMBIL DATA + PAGINATION
        // ==========================================

        $perPage = 5;

        $books = $bookModel
            ->orderBy('title', 'ASC')
            ->paginate($perPage);


        // ==========================================
        // 5. KIRIM DATA KE VIEW
        // ==========================================

        $data = [
            'title'       => 'Data Buku',
            'books'       => $books,
            'pager'       => $bookModel->pager,
            'keyword'     => $keyword,
            'currentPage' => $currentPage,
            'perPage'     => $perPage,
        ];


        return view(
            'buku/index',
            $data
        );
    }



    /**
     * =========================================================
     * MENAMPILKAN FORM TAMBAH BUKU
     * =========================================================
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Buku',
        ];

        return view('buku/create', $data);
    }


    /**
     * =========================================================
     * MENYIMPAN BUKU BARU
     * =========================================================
     */
    public function store()
    {
        $rules = [
            'book_code' => [
                'rules' => 'required|max_length[20]|is_unique[books.book_code]',
                'errors' => [
                    'required'   => 'Kode buku wajib diisi.',
                    'max_length' => 'Kode buku maksimal 20 karakter.',
                    'is_unique'  => 'Kode buku sudah digunakan.',
                ],
            ],

            'isbn' => [
                'rules' => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'ISBN maksimal 20 karakter.',
                ],
            ],

            'title' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required'   => 'Judul buku wajib diisi.',
                    'max_length' => 'Judul buku maksimal 200 karakter.',
                ],
            ],

            'author' => [
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required'   => 'Nama penulis wajib diisi.',
                    'max_length' => 'Nama penulis maksimal 150 karakter.',
                ],
            ],

            'publisher' => [
                'rules' => 'permit_empty|max_length[150]',
                'errors' => [
                    'max_length' => 'Nama penerbit maksimal 150 karakter.',
                ],
            ],

            'publication_year' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Tahun terbit harus berupa angka.',
                ],
            ],

            'category' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'Kategori wajib diisi.',
                    'max_length' => 'Kategori maksimal 100 karakter.',
                ],
            ],

            'stock_total' => [
                'rules' => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => 'Jumlah stok wajib diisi.',
                    'integer'               => 'Jumlah stok harus berupa angka.',
                    'greater_than_equal_to' => 'Jumlah stok tidak boleh negatif.',
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


        $stockTotal = (int) $this->request->getPost('stock_total');


        $data = [
            'book_code' => trim(
                (string) $this->request->getPost('book_code')
            ),

            'isbn' => trim(
                (string) $this->request->getPost('isbn')
            ) ?: null,

            'title' => trim(
                (string) $this->request->getPost('title')
            ),

            'author' => trim(
                (string) $this->request->getPost('author')
            ),

            'publisher' => trim(
                (string) $this->request->getPost('publisher')
            ) ?: null,

            'publication_year' =>
                $this->request->getPost('publication_year') ?: null,

            'category' => trim(
                (string) $this->request->getPost('category')
            ),

            'stock_total' => $stockTotal,

            'stock_available' => $stockTotal,
        ];


        $bookModel = new BookModel();

        $bookModel->insert($data);


        return redirect()
            ->to(site_url('buku'))
            ->with(
                'success',
                'Data buku berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * MENAMPILKAN DETAIL SATU BUKU
     * =========================================================
     */
    public function show($id)
    {
        $bookModel = new BookModel();

        $book = $bookModel->find($id);


        if ($book === null) {
            throw PageNotFoundException::forPageNotFound(
                'Data buku tidak ditemukan.'
            );
        }


        $data = [
            'title' => 'Detail Buku',
            'book'  => $book,
        ];


        return view('buku/show', $data);
    }


    /**
     * =========================================================
     * MENAMPILKAN FORM EDIT BUKU
     * =========================================================
     */
    public function edit($id)
    {
        $bookModel = new BookModel();

        $book = $bookModel->find($id);


        if ($book === null) {
            throw PageNotFoundException::forPageNotFound(
                'Data buku tidak ditemukan.'
            );
        }


        $data = [
            'title' => 'Edit Buku',
            'book'  => $book,
        ];


        return view('buku/edit', $data);
    }


    /**
     * =========================================================
     * MEMPROSES UPDATE BUKU
     * =========================================================
     */
    public function update($id)
    {
        $bookModel = new BookModel();

        $book = $bookModel->find($id);


        if ($book === null) {
            throw PageNotFoundException::forPageNotFound(
                'Data buku tidak ditemukan.'
            );
        }


        $rules = [
            'book_code' => [
                'rules' =>
                    'required|max_length[20]|is_unique[books.book_code,id,' . $id . ']',

                'errors' => [
                    'required'   => 'Kode buku wajib diisi.',
                    'max_length' => 'Kode buku maksimal 20 karakter.',
                    'is_unique'  => 'Kode buku sudah digunakan.',
                ],
            ],

            'isbn' => [
                'rules' => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'ISBN maksimal 20 karakter.',
                ],
            ],

            'title' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required'   => 'Judul buku wajib diisi.',
                    'max_length' => 'Judul buku maksimal 200 karakter.',
                ],
            ],

            'author' => [
                'rules' => 'required|max_length[150]',
                'errors' => [
                    'required'   => 'Nama penulis wajib diisi.',
                    'max_length' => 'Nama penulis maksimal 150 karakter.',
                ],
            ],

            'publisher' => [
                'rules' => 'permit_empty|max_length[150]',
                'errors' => [
                    'max_length' => 'Nama penerbit maksimal 150 karakter.',
                ],
            ],

            'publication_year' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Tahun terbit harus berupa angka.',
                ],
            ],

            'category' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required'   => 'Kategori wajib diisi.',
                    'max_length' => 'Kategori maksimal 100 karakter.',
                ],
            ],

            'stock_total' => [
                'rules' => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => 'Jumlah stok wajib diisi.',
                    'integer'               => 'Jumlah stok harus berupa angka.',
                    'greater_than_equal_to' => 'Jumlah stok tidak boleh negatif.',
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


        /**
         * Hitung berapa buku yang sedang dipinjam.
         *
         * Contoh:
         * stock_total lama     = 10
         * stock_available lama = 7
         *
         * berarti:
         *
         * sedang dipinjam = 3
         */
        $borrowed =
            (int) $book['stock_total']
            -
            (int) $book['stock_available'];


        $newStockTotal =
            (int) $this->request->getPost('stock_total');


        /**
         * Total stok baru tidak boleh lebih kecil
         * daripada jumlah buku yang sedang dipinjam.
         */
        if ($newStockTotal < $borrowed) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    [
                        'stock_total' =>
                            'Jumlah stok total tidak boleh lebih kecil dari jumlah buku yang sedang dipinjam.',
                    ]
                );
        }


        /**
         * Stok tersedia baru:
         *
         * stok total baru - buku sedang dipinjam
         */
        $newStockAvailable =
            $newStockTotal - $borrowed;


        $data = [
            'book_code' => trim(
                (string) $this->request->getPost('book_code')
            ),

            'isbn' => trim(
                (string) $this->request->getPost('isbn')
            ) ?: null,

            'title' => trim(
                (string) $this->request->getPost('title')
            ),

            'author' => trim(
                (string) $this->request->getPost('author')
            ),

            'publisher' => trim(
                (string) $this->request->getPost('publisher')
            ) ?: null,

            'publication_year' =>
                $this->request->getPost('publication_year') ?: null,

            'category' => trim(
                (string) $this->request->getPost('category')
            ),

            'stock_total' => $newStockTotal,

            'stock_available' => $newStockAvailable,
        ];


        $bookModel->update($id, $data);


        return redirect()
            ->to(site_url('buku'))
            ->with(
                'success',
                'Data buku berhasil diperbarui.'
            );
    }

    /**
     * =========================================================
     * MENGHAPUS DATA BUKU
     * =========================================================
     */
    public function delete($id)
    {
        $bookModel = new BookModel();

        // Cari buku berdasarkan ID
        $book = $bookModel->find($id);


        // Jika buku tidak ditemukan
        if ($book === null) {
            throw PageNotFoundException::forPageNotFound(
                'Data buku tidak ditemukan.'
            );
        }


        // Hitung jumlah buku yang sedang dipinjam
        $borrowed =
            (int) $book['stock_total']
            -
            (int) $book['stock_available'];


        // Buku tidak boleh dihapus jika masih dipinjam
        if ($borrowed > 0) {
            return redirect()
                ->to(site_url('buku'))
                ->with(
                    'error',
                    'Buku tidak dapat dihapus karena masih ada buku yang sedang dipinjam.'
                );
        }


        // Hapus buku
        $bookModel->delete($id);


        return redirect()
            ->to(site_url('buku'))
            ->with(
                'success',
                'Data buku berhasil dihapus.'
            );
    }

}
