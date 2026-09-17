<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Edit Buku</h1>

<p>
    Silakan ubah data buku pada form berikut.
</p>


<?php $errors = session()->getFlashdata('errors') ?? []; ?>


<?php if ($errors !== []): ?>

    <div class="alert alert-error">

        <strong>
            Data belum dapat diperbarui.
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
    action="<?= site_url(
        'buku/' . $book['id']
    ) ?>"
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
            value="<?= esc(
                old(
                    'book_code',
                    $book['book_code']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'isbn',
                    $book['isbn'] ?? ''
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'title',
                    $book['title']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'author',
                    $book['author']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'publisher',
                    $book['publisher'] ?? ''
                )
            ) ?>"
        >

    </div>


    <!-- TAHUN -->
    <div class="form-group">

        <label for="publication_year">
            Tahun Terbit
        </label>

        <input
            type="number"
            id="publication_year"
            name="publication_year"
            value="<?= esc(
                old(
                    'publication_year',
                    $book['publication_year'] ?? ''
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'category',
                    $book['category']
                )
            ) ?>"
        >

    </div>


    <!-- STOK TOTAL -->
    <div class="form-group">

        <label for="stock_total">
            Jumlah Stok Total
        </label>

        <input
            type="number"
            id="stock_total"
            name="stock_total"
            min="0"
            value="<?= esc(
                old(
                    'stock_total',
                    $book['stock_total']
                )
            ) ?>"
        >

    </div>


    <div class="form-actions">

        <button
            type="submit"
            class="btn"
        >
            Simpan Perubahan
        </button>


        <a
            href="<?= site_url(
                'buku/' . $book['id']
            ) ?>"
            class="btn"
        >
            Batal
        </a>

    </div>


</form>


<?= $this->endSection() ?>
