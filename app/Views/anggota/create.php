<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Tambah Anggota</h1>

<p>
    Silakan isi data anggota perpustakaan.
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
    action="<?= site_url('anggota') ?>"
    method="post"
>

    <?= csrf_field() ?>


    <div class="form-group">

        <label for="member_code">
            Kode Anggota
        </label>

        <input
            type="text"
            id="member_code"
            name="member_code"
            value="<?= esc(old('member_code')) ?>"
            placeholder="Contoh: AG006"
        >

    </div>


    <div class="form-group">

        <label for="name">
            Nama Anggota
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="<?= esc(old('name')) ?>"
            placeholder="Masukkan nama anggota"
        >

    </div>


    <div class="form-group">

        <label for="email">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= esc(old('email')) ?>"
            placeholder="nama@email.com"
        >

    </div>


    <div class="form-group">

        <label for="phone">
            Nomor Telepon
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            value="<?= esc(old('phone')) ?>"
            placeholder="Contoh: 081234567890"
        >

    </div>


    <div class="form-group">

        <label for="address">
            Alamat
        </label>

        <textarea
            id="address"
            name="address"
            rows="4"
            placeholder="Masukkan alamat anggota"
        ><?= esc(old('address')) ?></textarea>

    </div>


    <div class="form-group">

        <label for="status">
            Status
        </label>

        <?php
        $oldStatus =
            old('status')
            ?: 'active';
        ?>

        <select
            id="status"
            name="status"
        >

            <option
                value="active"
                <?= $oldStatus === 'active'
                    ? 'selected'
                    : '' ?>
            >
                Aktif
            </option>

            <option
                value="inactive"
                <?= $oldStatus === 'inactive'
                    ? 'selected'
                    : '' ?>
            >
                Tidak Aktif
            </option>

        </select>

    </div>


    <div class="form-actions">

        <button
            type="submit"
            class="btn"
        >
            Simpan Anggota
        </button>


        <a
            href="<?= site_url('anggota') ?>"
            class="btn"
        >
            Kembali
        </a>

    </div>

</form>


<?= $this->endSection() ?>
