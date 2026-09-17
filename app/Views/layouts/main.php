<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= esc($title ?? 'SIPERPUS-CI') ?></title>

    <link
        rel="stylesheet"
        href="/assets/css/style.css"
    >
</head>

<body>

    <header class="navbar">
        <div class="brand">
            SIPERPUS-CI
        </div>

        <div>
            Sistem Informasi Perpustakaan
        </div>
    </header>


    <div class="app-container">

        <aside class="sidebar">

            <h3>Menu</h3>

            <nav>
                <ul>
                    <li>
                        <a href="/dashboard">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="/buku">
                            Data Buku
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('anggota') ?>">
                            Data Anggota
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('peminjaman') ?>">
                            Peminjaman
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            Pengembalian
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            Laporan
                        </a>
                    </li>
                    <li>
                    <a href="<?= site_url('riwayat') ?>">
                        Riwayat Transaksi
                      </a>
                 </li>
                </ul>
            </nav>

        </aside>


        <main class="content">

            <?= $this->renderSection('content') ?>

        </main>

    </div>


    <footer class="footer">

        <p>
            SIPERPUS-CI |
            Sistem Informasi Perpustakaan
        </p>

    </footer>

</body>

</html>
