<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    /**
     * =========================================================
     * DASHBOARD UTAMA SIPERPUS-CI
     * =========================================================
     */
    public function index()
    {
        $db = db_connect();


        // ==========================================
        // 1. TOTAL JUDUL BUKU
        // ==========================================

        $totalBookTitles = $db
            ->table('books')
            ->countAllResults();


        // ==========================================
        // 2. TOTAL SELURUH EKSEMPLAR BUKU
        // ==========================================

        $stockData = $db
            ->table('books')
            ->selectSum('stock_total')
            ->selectSum('stock_available')
            ->get()
            ->getRowArray();


        $totalStock =
            (int) (
                $stockData['stock_total']
                ?? 0
            );


        $availableStock =
            (int) (
                $stockData['stock_available']
                ?? 0
            );


        // ==========================================
        // 3. TOTAL ANGGOTA
        // ==========================================

        $totalMembers = $db
            ->table('members')
            ->countAllResults();


        // ==========================================
        // 4. TOTAL ANGGOTA AKTIF
        // ==========================================

        $activeMembers = $db
            ->table('members')
            ->where(
                'status',
                'active'
            )
            ->countAllResults();


        // ==========================================
        // 5. PEMINJAMAN AKTIF
        // ==========================================

        $activeLoans = $db
            ->table('loans')
            ->where(
                'status',
                'borrowed'
            )
            ->countAllResults();


        // ==========================================
        // 6. TRANSAKSI TERLAMBAT
        // ==========================================

        $overdueLoans = $db
            ->table('loans')
            ->where(
                'status',
                'borrowed'
            )
            ->where(
                'due_date <',
                date('Y-m-d')
            )
            ->countAllResults();


        // ==========================================
        // 7. TRANSAKSI SUDAH DIKEMBALIKAN
        // ==========================================

        $returnedLoans = $db
            ->table('loans')
            ->where(
                'status',
                'returned'
            )
            ->countAllResults();


        // ==========================================
        // 8. TOTAL DENDA
        // ==========================================

        $fineData = $db
            ->table('loans')
            ->selectSum('fine_amount')
            ->get()
            ->getRowArray();


        $totalFine =
            (float) (
                $fineData['fine_amount']
                ?? 0
            );


        // ==========================================
        // 9. TRANSAKSI TERBARU
        // ==========================================

        $recentLoans = $db
            ->table('loans')

            ->select(
                '
                loans.id,
                loans.loan_code,
                loans.loan_date,
                loans.due_date,
                loans.status,
                loans.late_days,
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

            ->limit(5)

            ->get()

            ->getResultArray();


        // ==========================================
        // 10. KIRIM SEMUA DATA KE VIEW
        // ==========================================

        $data = [
            'title'           => 'Dashboard',
            'totalBookTitles' => $totalBookTitles,
            'totalStock'      => $totalStock,
            'availableStock'  => $availableStock,
            'totalMembers'    => $totalMembers,
            'activeMembers'   => $activeMembers,
            'activeLoans'     => $activeLoans,
            'overdueLoans'    => $overdueLoans,
            'returnedLoans'   => $returnedLoans,
            'totalFine'       => $totalFine,
            'recentLoans'     => $recentLoans,
        ];


        return view(
            'dashboard/index',
            $data
        );
    }
}
