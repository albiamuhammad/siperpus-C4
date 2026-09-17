<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Riwayat Transaksi</h1>

<p>
    Cari dan filter seluruh transaksi
    peminjaman dan pengembalian.
</p>


<!-- ========================================
     FILTER
========================================= -->

<form
    action="<?= site_url('riwayat') ?>"
    method="get"
    class="filter-form"
>


    <!-- SEARCH -->
    <div class="filter-item">

        <label for="keyword">
            Pencarian
        </label>

        <input
            type="text"
            id="keyword"
            name="keyword"
            value="<?= esc($keyword) ?>"
            placeholder="Kode transaksi / anggota..."
        >

    </div>


    <!-- STATUS -->
    <div class="filter-item">

        <label for="status">
            Status
        </label>

        <select
            id="status"
            name="status"
        >

            <option value="">
                Semua Status
            </option>


            <option
                value="borrowed"
                <?= $status === 'borrowed'
                    ? 'selected'
                    : '' ?>
            >
                Dipinjam
            </option>


            <option
                value="returned"
                <?= $status === 'returned'
                    ? 'selected'
                    : '' ?>
            >
                Dikembalikan
            </option>


            <option
                value="overdue"
                <?= $status === 'overdue'
                    ? 'selected'
                    : '' ?>
            >
                Terlambat
            </option>

        </select>

    </div>


    <!-- TANGGAL AWAL -->
    <div class="filter-item">

        <label for="start_date">
            Dari Tanggal
        </label>

        <input
            type="date"
            id="start_date"
            name="start_date"
            value="<?= esc($startDate) ?>"
        >

    </div>


    <!-- TANGGAL AKHIR -->
    <div class="filter-item">

        <label for="end_date">
            Sampai Tanggal
        </label>

        <input
            type="date"
            id="end_date"
            name="end_date"
            value="<?= esc($endDate) ?>"
        >

    </div>


    <div class="filter-actions">

        <button
            type="submit"
            class="btn"
        >
            Terapkan Filter
        </button>


        <a
            href="<?= site_url('riwayat') ?>"
            class="btn"
        >
            Reset
        </a>

    </div>


</form>


<!-- ========================================
     TABEL RIWAYAT
========================================= -->

<table class="data-table">

    <thead>

        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Anggota</th>
            <th>Tanggal Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Dikembalikan</th>
            <th>Status</th>
            <th>Terlambat</th>
            <th>Denda</th>
            <th>Aksi</th>
        </tr>

    </thead>


    <tbody>


        <?php if ($loans !== []): ?>


            <?php foreach ($loans as $index => $loan): ?>


                <?php

                $isOverdue =
                    $loan['status'] === 'borrowed'
                    &&
                    $loan['due_date'] < date('Y-m-d');

                ?>


                <tr>


                    <!-- NOMOR -->
                    <td>

                        <?= esc(
                            (string) (
                                $index
                                + 1
                                + (
                                    ($currentPage - 1)
                                    * $perPage
                                )
                            )
                        ) ?>

                    </td>


                    <!-- KODE -->
                    <td>

                        <?= esc(
                            $loan['loan_code']
                        ) ?>

                    </td>


                    <!-- ANGGOTA -->
                    <td>

                        <?= esc(
                            $loan['member_code']
                        ) ?>

                        -

                        <?= esc(
                            $loan['member_name']
                        ) ?>

                    </td>


                    <!-- TANGGAL PINJAM -->
                    <td>

                        <?= esc(
                            $loan['loan_date']
                        ) ?>

                    </td>


                    <!-- DUE DATE -->
                    <td>

                        <?= esc(
                            $loan['due_date']
                        ) ?>

                    </td>


                    <!-- RETURNED -->
                    <td>

                        <?= esc(
                            $loan['returned_at']
                            ?? '-'
                        ) ?>

                    </td>


                    <!-- STATUS -->
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


                    <!-- LATE DAYS -->
                    <td>

                        <?php if ($loan['status'] === 'returned'): ?>

                            <?= esc(
                                (string)
                                $loan['late_days']
                            ) ?>

                            hari

                        <?php elseif ($isOverdue): ?>

                            <?php

                            $dueDateObject =
                                new DateTimeImmutable(
                                    $loan['due_date']
                                );

                            $todayObject =
                                new DateTimeImmutable(
                                    date('Y-m-d')
                                );

                            $currentLateDays =
                                (int)
                                $dueDateObject
                                    ->diff($todayObject)
                                    ->format('%a');

                            ?>

                            <?= esc(
                                (string)
                                $currentLateDays
                            ) ?>

                            hari

                        <?php else: ?>

                            0 hari

                        <?php endif; ?>

                    </td>


                    <!-- DENDA -->
                    <td>

                        <?php if ($loan['status'] === 'returned'): ?>

                            Rp
                            <?= esc(
                                number_format(
                                    (float)
                                    $loan['fine_amount'],
                                    0,
                                    ',',
                                    '.'
                                )
                            ) ?>

                        <?php elseif ($isOverdue): ?>

                            <?php
                            $estimatedFine =
                                $currentLateDays
                                * 5000;
                            ?>

                            Rp
                            <?= esc(
                                number_format(
                                    $estimatedFine,
                                    0,
                                    ',',
                                    '.'
                                )
                            ) ?>

                            *

                        <?php else: ?>

                            Rp0

                        <?php endif; ?>

                    </td>


                    <!-- AKSI -->
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

                <td colspan="10">

                    Tidak ada transaksi
                    yang sesuai dengan filter.

                </td>

            </tr>


        <?php endif; ?>


    </tbody>

</table>


<p>
    <small>
        * Denda transaksi yang masih terlambat
        merupakan estimasi sampai hari ini.
    </small>
</p>


<!-- ========================================
     PAGINATION
========================================= -->

<div class="pagination-container">

    <?= $pager
        ->only([
            'keyword',
            'status',
            'start_date',
            'end_date',
        ])
        ->links()
    ?>

</div>


<?= $this->endSection() ?>