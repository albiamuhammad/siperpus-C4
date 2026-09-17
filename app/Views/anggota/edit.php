<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Edit Anggota</h1>

<p>
    Silakan ubah data anggota.
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
        'anggota/' . $member['id']
    ) ?>"
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
            value="<?= esc(
                old(
                    'member_code',
                    $member['member_code']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'name',
                    $member['name']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'email',
                    $member['email']
                )
            ) ?>"
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
            value="<?= esc(
                old(
                    'phone',
                    $member['phone']
                    ?? ''
                )
            ) ?>"
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
        ><?= esc(
            old(
                'address',
                $member['address']
                ?? ''
            )
        ) ?></textarea>

    </div>


    <div class="form-group">

        <label for="status">
            Status
        </label>


        <?php
        $selectedStatus =
            old(
                'status',
                $member['status']
            );
        ?>


        <select
            id="status"
            name="status"
        >

            <option
                value="active"
                <?= $selectedStatus === 'active'
                    ? 'selected'
                    : '' ?>
            >
                Aktif
            </option>


            <option
                value="inactive"
                <?= $selectedStatus === 'inactive'
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
            Simpan Perubahan
        </button>


        <a
            href="<?= site_url(
                'anggota/' . $member['id']
            ) ?>"
            class="btn"
        >
            Batal
        </a>

    </div>

</form>


<?= $this->endSection() ?>
