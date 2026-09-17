<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<h1>Detail Anggota</h1>


<table class="detail-table">


    <tr>

        <th>Kode Anggota</th>

        <td>
            <?= esc(
                $member['member_code']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Nama</th>

        <td>
            <?= esc(
                $member['name']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Email</th>

        <td>
            <?= esc(
                $member['email']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Nomor Telepon</th>

        <td>
            <?= esc(
                $member['phone']
                ?? '-'
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Alamat</th>

        <td>
            <?= esc(
                $member['address']
                ?? '-'
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Status</th>

        <td>

            <?= $member['status'] === 'active'
                ? 'Aktif'
                : 'Tidak Aktif' ?>

        </td>

    </tr>


    <tr>

        <th>Tanggal Dibuat</th>

        <td>
            <?= esc(
                (string)
                $member['created_at']
            ) ?>
        </td>

    </tr>


    <tr>

        <th>Terakhir Diperbarui</th>

        <td>
            <?= esc(
                (string)
                $member['updated_at']
            ) ?>
        </td>

    </tr>


</table>


<div class="form-actions">

    <a
        href="<?= site_url(
            'anggota/'
            . $member['id']
            . '/edit'
        ) ?>"
        class="btn"
    >
        Edit Anggota
    </a>


    <a
        href="<?= site_url('anggota') ?>"
        class="btn"
    >
        Kembali
    </a>

</div>


<?= $this->endSection() ?>
