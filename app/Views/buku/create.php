<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Tambah Buku</h1>

<p>
    Silakan isi data buku baru pada form berikut.
</p>


<?php $errors = session()->getFlashdata('errors') ?? []; ?>


<?php if ($errors !== []): ?>

    <div class="alert alert-error">

        <strong>
            Data belum dapat disimpan.
        </strong>

        <ul>

            <?php foreach ($errors as $error): ?>

                <li>
                    <?= esc($error) ?>
                </li>

            <?php endforeach; ?>

        </ul>

    </div>

<?php endif; ?>


<form
    action="<?= site_url('buku') ?>"
    method="post"
>

    <?= csrf_field() ?>


    <!-- KODE BUKU -->
    <div class="form-group">

        <label for="book_code">
            Kode Buku
        </label>

        <input
            type="text"
            id="book_code"
            name="book_code"
            value="<?= esc(old('book_code')) ?>"
            placeholder="Contoh: BK006"
        >

    </div>


    <!-- ISBN -->
    <div class="form-group">

        <label for="isbn">
            ISBN
        </label>

        <input
            type="text"
            id="isbn"
            name="isbn"
            value="<?= esc(old('isbn')) ?>"
            placeholder="Contoh: 9786020000006"
        >

    </div>


    <!-- JUDUL -->
    <div class="form-group">

        <label for="title">
            Judul Buku
        </label>

        <input
            type="text"
            id="title"
            name="title"
            value="<?= esc(old('title')) ?>"
            placeholder="Masukkan judul buku"
        >

    </div>


    <!-- PENULIS -->
    <div class="form-group">

        <label for="author">
            Penulis
        </label>

        <input
            type="text"
            id="author"
            name="author"
            value="<?= esc(old('author')) ?>"
            placeholder="Masukkan nama penulis"
        >

    </div>


    <!-- PENERBIT -->
    <div class="form-group">

        <label for="publisher">
            Penerbit
        </label>

        <input
            type="text"
            id="publisher"
            name="publisher"
            value="<?= esc(old('publisher')) ?>"
            placeholder="Masukkan nama penerbit"
        >

    </div>


    <!-- TAHUN TERBIT -->
    <div class="form-group">

        <label for="publication_year">
            Tahun Terbit
        </label>

        <input
            type="number"
            id="publication_year"
            name="publication_year"
            value="<?= esc(old('publication_year')) ?>"
            placeholder="Contoh: 2026"
        >

    </div>


    <!-- KATEGORI -->
    <div class="form-group">

        <label for="category">
            Kategori
        </label>

        <input
            type="text"
            id="category"
            name="category"
            value="<?= esc(old('category')) ?>"
            placeholder="Contoh: Pemrograman"
        >

    </div>


    <!-- STOK -->
    <div class="form-group">

        <label for="stock_total">
            Jumlah Stok
        </label>

        <input
            type="number"
            id="stock_total"
            name="stock_total"
            min="0"
            value="<?= esc(old('stock_total')) ?>"
            placeholder="Contoh: 10"
        >

    </div>


    <!-- TOMBOL -->
    <div class="form-actions">

        <button
            type="submit"
            class="btn"
        >
            Simpan Buku
        </button>

        <a
            href="<?= site_url('buku') ?>"
            class="btn"
        >
            Kembali
        </a>

    </div>


</form>


<?= $this->endSection() ?>
