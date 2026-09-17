<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Manajemen Anggota</h1>


<p>

    <a
        href="<?= site_url('anggota/tambah') ?>"
        class="btn"
    >
        + Tambah Anggota
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


<form
    action="<?= site_url('anggota') ?>"
    method="get"
    class="search-form"
>

    <input
        type="text"
        name="keyword"
        value="<?= esc($keyword) ?>"
        placeholder="Cari kode, nama, email, telepon..."
    >


    <button
        type="submit"
        class="btn"
    >
        Cari
    </button>


    <?php if ($keyword !== ''): ?>

        <a
            href="<?= site_url('anggota') ?>"
            class="btn"
        >
            Reset
        </a>

    <?php endif; ?>

</form>


<?php if ($keyword !== ''): ?>

    <p>

        Hasil pencarian untuk:

        <strong>
            <?= esc($keyword) ?>
        </strong>

    </p>

<?php endif; ?>


<table class="data-table">

    <thead>

        <tr>

            <th>No.</th>

            <th>Kode</th>

            <th>Nama</th>

            <th>Email</th>

            <th>Telepon</th>

            <th>Status</th>

            <th>Aksi</th>

        </tr>

    </thead>


    <tbody>

        <?php if ($members !== []): ?>


            <?php foreach ($members as $index => $member): ?>

                <tr>


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


                    <td>

                        <?= esc(
                            $member['member_code']
                        ) ?>

                    </td>


                    <td>

                        <?= esc(
                            $member['name']
                        ) ?>

                    </td>


                    <td>

                        <?= esc(
                            $member['email']
                        ) ?>

                    </td>


                    <td>

                        <?= esc(
                            $member['phone']
                            ?? '-'
                        ) ?>

                    </td>


                    <td>

                        <?php if ($member['status'] === 'active'): ?>

                            <span class="status-active">
                                Aktif
                            </span>

                        <?php else: ?>

                            <span class="status-inactive">
                                Tidak Aktif
                            </span>

                        <?php endif; ?>

                    </td>


                    <td class="action-buttons">


                        <a
                            href="<?= site_url(
                                'anggota/'
                                . $member['id']
                            ) ?>"
                            class="btn"
                        >
                            Detail
                        </a>


                        <a
                            href="<?= site_url(
                                'anggota/'
                                . $member['id']
                                . '/edit'
                            ) ?>"
                            class="btn"
                        >
                            Edit
                        </a>


                        <form
                            action="<?= site_url(
                                'anggota/'
                                . $member['id']
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
                                        'Apakah Anda yakin ingin menghapus anggota ini?'
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

                <td colspan="7">

                    <?php if ($keyword !== ''): ?>

                        Anggota dengan kata kunci
                        "<?= esc($keyword) ?>"
                        tidak ditemukan.

                    <?php else: ?>

                        Belum ada data anggota.

                    <?php endif; ?>

                </td>

            </tr>

        <?php endif; ?>

    </tbody>

</table>


<div class="pagination-container">

    <?= $pager->only(['keyword'])->links() ?>

</div>


<?= $this->endSection() ?>
