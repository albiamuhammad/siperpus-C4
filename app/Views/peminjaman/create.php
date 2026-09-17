<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Tambah Peminjaman</h1>

<p>
    Silakan pilih anggota dan buku
    yang akan dipinjam.
</p>


<?php
$errors =
    session()->getFlashdata('errors')
    ?? [];
?>


<?php if ($errors !== []): ?>

    <div class="alert alert-error">

        <strong>
            Transaksi belum dapat disimpan.
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


<?php if (session()->getFlashdata('error')): ?>

    <div class="alert alert-error">

        <?= esc(
            session()->getFlashdata('error')
        ) ?>

    </div>

<?php endif; ?>


<form
    action="<?= site_url('peminjaman') ?>"
    method="post"
>

    <?= csrf_field() ?>


    <!-- ========================================
         ANGGOTA
    ========================================= -->

    <div class="form-group">

        <label for="member_id">
            Anggota
        </label>


        <select
            id="member_id"
            name="member_id"
        >

            <option value="">
                -- Pilih Anggota --
            </option>


            <?php foreach ($members as $member): ?>

                <option
                    value="<?= esc(
                        (string) $member['id']
                    ) ?>"
                    <?= (string) old('member_id')
                        === (string) $member['id']
                        ? 'selected'
                        : '' ?>
                >

                    <?= esc(
                        $member['member_code']
                    ) ?>

                    -

                    <?= esc(
                        $member['name']
                    ) ?>

                </option>

            <?php endforeach; ?>

        </select>

    </div>


    <!-- ========================================
         BUKU
    ========================================= -->

    <div class="form-group">

        <label for="book_id">
            Buku
        </label>


        <select
            id="book_id"
            name="book_id"
        >

            <option value="">
                -- Pilih Buku --
            </option>


            <?php foreach ($books as $book): ?>

                <option
                    value="<?= esc(
                        (string) $book['id']
                    ) ?>"
                    <?= (string) old('book_id')
                        === (string) $book['id']
                        ? 'selected'
                        : '' ?>
                >

                    <?= esc(
                        $book['book_code']
                    ) ?>

                    -

                    <?= esc(
                        $book['title']
                    ) ?>

                    (Stok:
                    <?= esc(
                        (string)
                        $book['stock_available']
                    ) ?>)

                </option>

            <?php endforeach; ?>

        </select>

    </div>


    <!-- ========================================
         TANGGAL PINJAM
    ========================================= -->

    <div class="form-group">

        <label for="loan_date">
            Tanggal Peminjaman
        </label>

        <input
            type="date"
            id="loan_date"
            name="loan_date"
            value="<?= esc(
                old(
                    'loan_date',
                    date('Y-m-d')
                )
            ) ?>"
        >

    </div>


    <!-- ========================================
         JATUH TEMPO
    ========================================= -->

    <div class="form-group">

        <label for="due_date">
            Tanggal Jatuh Tempo
        </label>

        <input
            type="date"
            id="due_date"
            name="due_date"
            value="<?= esc(
                old(
                    'due_date',
                    date(
                        'Y-m-d',
                        strtotime('+7 days')
                    )
                )
            ) ?>"
        >

    </div>


    <div class="form-actions">

        <button
            type="submit"
            class="btn"
        >
            Simpan Peminjaman
        </button>


        <a
            href="<?= site_url('peminjaman') ?>"
            class="btn"
        >
            Kembali
        </a>

    </div>

</form>


<?= $this->endSection() ?>