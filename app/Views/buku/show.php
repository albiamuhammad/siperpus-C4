<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Detail Buku</h1>


<table class="detail-table">

    <tr>
        <th>Kode Buku</th>

        <td>
            <?= esc($book['book_code']) ?>
        </td>
    </tr>


    <tr>
        <th>ISBN</th>

        <td>
            <?= esc($book['isbn'] ?? '-') ?>
        </td>
    </tr>


    <tr>
        <th>Judul Buku</th>

        <td>
            <?= esc($book['title']) ?>
        </td>
    </tr>


    <tr>
        <th>Penulis</th>

        <td>
            <?= esc($book['author']) ?>
        </td>
    </tr>


    <tr>
        <th>Penerbit</th>

        <td>
            <?= esc($book['publisher'] ?? '-') ?>
        </td>
    </tr>


    <tr>
        <th>Tahun Terbit</th>

        <td>
            <?= esc(
                (string) ($book['publication_year'] ?? '-')
            ) ?>
        </td>
    </tr>


    <tr>
        <th>Kategori</th>

        <td>
            <?= esc($book['category']) ?>
        </td>
    </tr>


    <tr>
        <th>Stok Total</th>

        <td>
            <?= esc((string) $book['stock_total']) ?>
        </td>
    </tr>


    <tr>
        <th>Stok Tersedia</th>

        <td>
            <?= esc((string) $book['stock_available']) ?>
        </td>
    </tr>


    <tr>
        <th>Dibuat</th>

        <td>
            <?= esc((string) $book['created_at']) ?>
        </td>
    </tr>


    <tr>
        <th>Diperbarui</th>

        <td>
            <?= esc((string) $book['updated_at']) ?>
        </td>
    </tr>

</table>


<div class="form-actions">

    <a
        href="<?= site_url(
            'buku/' . $book['id'] . '/edit'
        ) ?>"
        class="btn"
    >
        Edit Buku
    </a>


    <a
        href="<?= site_url('buku') ?>"
        class="btn"
    >
        Kembali
    </a>

</div>


<?= $this->endSection() ?>
