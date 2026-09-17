<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Dashboard SIPERPUS-CI</h1>

<p>
    Ringkasan kondisi perpustakaan
    berdasarkan data terbaru.
</p>


<!-- ========================================
     STATISTIK UTAMA
========================================= -->

<div class="dashboard-grid">


    <div class="dashboard-card">

        <h3>
            Total Judul Buku
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $totalBookTitles
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Total Eksemplar
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $totalStock
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Stok Tersedia
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $availableStock
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Total Anggota
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $totalMembers
            ) ?>
        </div>

        <small>

            Aktif:

            <?= esc(
                (string)
                $activeMembers
            ) ?>

        </small>

    </div>


    <div class="dashboard-card">

        <h3>
            Peminjaman Aktif
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $activeLoans
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Terlambat
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $overdueLoans
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Sudah Dikembalikan
        </h3>

        <div class="dashboard-number">
            <?= esc(
                (string)
                $returnedLoans
            ) ?>
        </div>

    </div>


    <div class="dashboard-card">

        <h3>
            Total Denda
        </h3>

        <div class="dashboard-number dashboard-money">

            Rp
            <?= esc(
                number_format(
                    $totalFine,
                    0,
                    ',',
                    '.'
                )
            ) ?>

        </div>

    </div>


</div>


<!-- ========================================
     TRANSAKSI TERBARU
========================================= -->

<h2>
    Transaksi Terbaru
</h2>


<table class="data-table">

    <thead>

        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Anggota</th>
            <th>Tanggal Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

    </thead>


    <tbody>


        <?php if ($recentLoans !== []): ?>


            <?php foreach ($recentLoans as $index => $loan): ?>

                <?php

                $isOverdue =
                    $loan['status'] === 'borrowed'
                    &&
                    $loan['due_date'] < date('Y-m-d');

                ?>


                <tr>


                    <td>
                        <?= $index + 1 ?>
                    </td>


                    <td>
                        <?= esc(
                            $loan['loan_code']
                        ) ?>
                    </td>


                    <td>

                        <?= esc(
                            $loan['member_code']
                        ) ?>

                        -

                        <?= esc(
                            $loan['member_name']
                        ) ?>

                    </td>


                    <td>
                        <?= esc(
                            $loan['loan_date']
                        ) ?>
                    </td>


                    <td>
                        <?= esc(
                            $loan['due_date']
                        ) ?>
                    </td>


                    <td>


                        <?php if ($isOverdue): ?>

                            <span class="status-overdue">
                                Terlambat
                            </span>


                        <?php elseif (
                            $loan['status']
                            === 'borrowed'
                        ): ?>

                            <span class="status-borrowed">
                                Dipinjam
                            </span>


                        <?php else: ?>

                            <span class="status-returned">
                                Dikembalikan
                            </span>

                        <?php endif; ?>


                    </td>


                    <td>

                        <a
                            href="<?= site_url(
                                'peminjaman/'
                                . $loan['id']
                            ) ?>"
                            class="btn"
                        >
                            Detail
                        </a>

                    </td>


                </tr>


            <?php endforeach; ?>


        <?php else: ?>


            <tr>

                <td colspan="7">

                    Belum ada transaksi peminjaman.

                </td>

            </tr>


        <?php endif; ?>


    </tbody>

</table>


<p>

    <a
        href="<?= site_url('riwayat') ?>"
        class="btn"
    >
        Lihat Semua Riwayat
    </a>

</p>


<?= $this->endSection() ?>
