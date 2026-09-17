<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Manajemen Buku</h1>


<!-- ========================================
     TOMBOL TAMBAH
========================================= -->

<p>

    <a
        href="<?= site_url('buku/tambah') ?>"
        class="btn"
    >
        + Tambah Buku
    </a>

</p>


<!-- ========================================
     SUCCESS MESSAGE
========================================= -->

<?php if (session()->getFlashdata('success')): ?>

    <div class="alert alert-success">

        <?= esc(
            session()->getFlashdata('success')
        ) ?>

    </div>

<?php endif; ?>


<!-- ========================================
     ERROR MESSAGE
========================================= -->

<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-error">

        <?= esc(
            session()->getFlashdata('error')
        ) ?>

    </div>

<?php endif; ?>


<!-- ========================================
     SEARCH
========================================= -->

<form
    action="<?= site_url('buku') ?>"
    method="get"
    class="search-form"
>

    <input
        type="text"
        name="keyword"
        value="<?= esc($keyword) ?>"
        placeholder="Cari buku..."
    >


    <button
        type="submit"
        class="btn"
    >
        Cari
    </button>


    <?php if ($keyword !== ''): ?>

        <a
            href="<?= site_url('buku') ?>"
            class="btn"
        >
            Reset
        </a>

    <?php endif; ?>

</form>


<!-- ========================================
     INFORMASI SEARCH
========================================= -->

<?php if ($keyword !== ''): ?>

    <p>
        Hasil pencarian untuk:

        <strong>
            <?= esc($keyword) ?>
        </strong>
    </p>

<?php endif; ?>


<!-- ========================================
     TABEL BUKU
========================================= -->

<table class="data-table">

    <thead>

        <tr>

            <th>No.</th>

            <th>Kode</th>

            <th>Judul</th>

            <th>Penulis</th>

            <th>Penerbit</th>

            <th>Kategori</th>

            <th>Tahun</th>

            <th>Stok</th>

            <th>Aksi</th>

        </tr>

    </thead>


    <tbody>


        <?php if ($books !== []): ?>


            <?php foreach ($books as $index => $book): ?>


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
                            $book['book_code']
                        ) ?>

                    </td>


                    <!-- JUDUL -->
                    <td>

                        <?= esc(
                            $book['title']
                        ) ?>

                    </td>


                    <!-- PENULIS -->
                    <td>

                        <?= esc(
                            $book['author']
                        ) ?>

                    </td>


                    <!-- PENERBIT -->
                    <td>

                        <?= esc(
                            $book['publisher']
                            ?? '-'
                        ) ?>

                    </td>


                    <!-- KATEGORI -->
                    <td>

                        <?= esc(
                            $book['category']
                        ) ?>

                    </td>


                    <!-- TAHUN -->
                    <td>

                        <?= esc(
                            (string) (
                                $book[
                                    'publication_year'
                                ]
                                ?? '-'
                            )
                        ) ?>

                    </td>


                    <!-- STOK -->
                    <td>

                        <?= esc(
                            (string)
                            $book['stock_available']
                        ) ?>

                        /

                        <?= esc(
                            (string)
                            $book['stock_total']
                        ) ?>

                    </td>


                    <!-- AKSI -->
                    <td class="action-buttons">


                        <!-- DETAIL -->
                        <a
                            href="<?= site_url(
                                'buku/'
                                . $book['id']
                            ) ?>"
                            class="btn"
                        >
                            Detail
                        </a>


                        <!-- EDIT -->
                        <a
                            href="<?= site_url(
                                'buku/'
                                . $book['id']
                                . '/edit'
                            ) ?>"
                            class="btn"
                        >
                            Edit
                        </a>


                        <!-- HAPUS -->
                        <form
                            action="<?= site_url(
                                'buku/'
                                . $book['id']
                                . '/hapus'
                            ) ?>"
                            method="post"
                            class="delete-form"
                        >

                            <?= csrf_field() ?>


                            <button
                                type="submit"
                                class="btn btn-delete"
                                onclick="
                                    return confirm(
                                        'Apakah Anda yakin ingin menghapus buku ini?'
                                    )
                                "
                            >
                                Hapus
                            </button>

                        </form>


                    </td>


                </tr>


            <?php endforeach; ?>


        <?php else: ?>


            <tr>

                <td colspan="9">

                    <?php if ($keyword !== ''): ?>

                        Buku dengan kata kunci
                        "<?= esc($keyword) ?>"
                        tidak ditemukan.

                    <?php else: ?>

                        Belum ada data buku.

                    <?php endif; ?>

                </td>

            </tr>


        <?php endif; ?>


    </tbody>

</table>


<!-- ========================================
     PAGINATION
========================================= -->

<div class="pagination-container">

    <?= $pager->links() ?>

</div>


<?= $this->endSection() ?>
