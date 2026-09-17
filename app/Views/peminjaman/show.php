<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Detail Peminjaman</h1>


<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success">

        <?= esc(
            session()->getFlashdata('success')
        ) ?>

    </div>

<?php endif; ?>


<h2>Informasi Transaksi</h2>


<table class="detail-table">

    <tr>

        <th>Kode Peminjaman</th>

        <td>
            <?= esc(
                $loan['loan_code']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Anggota</th>

        <td>

            <?= esc(
                $loan['member_code']
            ) ?>

            -

            <?= esc(
                $loan['member_name']
            ) ?>

        </td>

    </tr>


    <tr>

        <th>Email</th>

        <td>
            <?= esc(
                $loan['member_email']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Tanggal Peminjaman</th>

        <td>
            <?= esc(
                $loan['loan_date']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Jatuh Tempo</th>

        <td>
            <?= esc(
                $loan['due_date']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Status</th>

        <td>

            <?= $loan['status']
                === 'borrowed'
                ? 'Dipinjam'
                : 'Dikembalikan' ?>

        </td>

    </tr>

</table>


<h2>Buku yang Dipinjam</h2>


<table class="data-table">

    <thead>

        <tr>
            <th>No.</th>
            <th>Kode Buku</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Jumlah</th>
        </tr>

    </thead>


    <tbody>

        <?php foreach ($details as $index => $detail): ?>

            <tr>

                <td>
                    <?= $index + 1 ?>
                </td>


                <td>
                    <?= esc(
                        $detail['book_code']
                    ) ?>
                </td>


                <td>
                    <?= esc(
                        $detail['title']
                    ) ?>
                </td>


                <td>
                    <?= esc(
                        $detail['author']
                    ) ?>
                </td>


                <td>
                    <?= esc(
                        (string)
                        $detail['quantity']
                    ) ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>


<div class="form-actions">

    <a
        href="<?= site_url('peminjaman') ?>"
        class="btn"
    >
        Kembali
    </a>

</div>


<?= $this->endSection() ?>