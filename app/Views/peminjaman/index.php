<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Data Peminjaman</h1>


<p>

    <a
        href="<?= site_url(
            'peminjaman/tambah'
        ) ?>"
        class="btn"
    >
        + Tambah Peminjaman
    </a>

</p>


<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success">

        <?= esc(
            session()->getFlashdata('success')
        ) ?>

    </div>

<?php endif; ?>


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-error">

        <?= esc(
            session()->getFlashdata('error')
        ) ?>

    </div>

<?php endif; ?>


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

        <?php if ($loans !== []): ?>


            <?php foreach ($loans as $index => $loan): ?>

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

                        <?php if (
                            $loan['status']
                            === 'borrowed'
                        ): ?>

                            Dipinjam

                        <?php elseif (
                            $loan['status']
                            === 'returned'
                        ): ?>

                            Dikembalikan

                        <?php else: ?>

                            <?= esc(
                                $loan['status']
                            ) ?>

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


<?= $this->endSection() ?>