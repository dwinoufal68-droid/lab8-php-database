<?php
require_once "koneksi.php";

// Menghitung statistik inventaris
$totalBarang = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COUNT(*) AS total FROM data_barang"
))['total'];

$totalStok = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COALESCE(SUM(stok), 0) AS total FROM data_barang"
))['total'];

$totalKategori = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COUNT(DISTINCT kategori) AS total FROM data_barang"
))['total'];

// Pencarian barang
$cari = trim($_GET['cari'] ?? '');

if ($cari !== '') {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM data_barang
         WHERE nama LIKE ? OR kategori LIKE ?
         ORDER BY id_barang DESC"
    );

    $keyword = "%".$cari."%";
    mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query(
        $conn,
        "SELECT * FROM data_barang ORDER BY id_barang DESC"
    );
}

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

function rupiah($angka) {
    return "Rp " . number_format((float)$angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">I</div>
            <div>
                <h2>Inventory</h2>
                <span>Management System</span>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="menu">
            <a href="index.php" class="menu-item active">
                <span>▦</span> Dashboard
            </a>

            <a href="index.php" class="menu-item">
                <span>▤</span> Data Barang
            </a>

            <a href="tambah.php" class="menu-item">
                <span>＋</span> Tambah Barang
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="profile">
                <div class="avatar">A</div>
                <div>
                    <strong>Administrator</strong>
                    <small>Pengelola Inventaris</small>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <header class="topbar">
            <div>
                <p class="breadcrumb">Halaman / Dashboard</p>
                <h2>Dashboard Overview</h2>
            </div>

            <div class="topbar-right">
                <span class="status-dot"></span>
                Sistem Aktif
            </div>
        </header>

        <section class="welcome">
            <div>
                <h1>Selamat Datang, Administrator!</h1>
                <p>Berikut ringkasan data inventaris barang kamu.</p>
            </div>

            <a href="tambah.php" class="btn-primary">
                ＋ Tambah Barang
            </a>
        </section>

        <!-- STATISTIK -->
        <section class="stats-grid">

            <div class="stat-card blue">
                <div class="stat-top">
                    <span>Total Barang</span>
                    <div class="stat-icon">▦</div>
                </div>
                <h2><?= (int)$totalBarang ?></h2>
                <p>Jumlah seluruh data barang</p>
            </div>

            <div class="stat-card green">
                <div class="stat-top">
                    <span>Total Stok</span>
                    <div class="stat-icon">▣</div>
                </div>
                <h2><?= (int)$totalStok ?></h2>
                <p>Total persediaan barang</p>
            </div>

            <div class="stat-card orange">
                <div class="stat-top">
                    <span>Total Kategori</span>
                    <div class="stat-icon">▤</div>
                </div>
                <h2><?= (int)$totalKategori ?></h2>
                <p>Jenis kategori barang</p>
            </div>

        </section>

        <!-- TABEL INVENTARIS -->
        <section class="content-card">

            <div class="card-heading">
                <div>
                    <h2>Daftar Inventaris</h2>
                    <p>Kelola seluruh data barang inventaris.</p>
                </div>

                <span class="data-count">
                    <?= mysqli_num_rows($result) ?> Barang
                </span>
            </div>

            <!-- SEARCH -->
            <form method="GET" action="index.php" class="search-form">
                <input
                    type="text"
                    name="cari"
                    placeholder="Cari nama atau kategori barang..."
                    value="<?= htmlspecialchars($cari) ?>"
                >
                <button type="submit">Cari Barang</button>

                <?php if ($cari !== ''): ?>
                    <a href="index.php" class="reset-btn">Reset</a>
                <?php endif; ?>
            </form>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>GAMBAR</th>
                            <th>NAMA BARANG</th>
                            <th>KATEGORI</th>
                            <th>HARGA BELI</th>
                            <th>HARGA JUAL</th>
                            <th>STOK</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (mysqli_num_rows($result) > 0): ?>

                        <?php while ($row = mysqli_fetch_assoc($result)): ?>

                        <tr>
                            <td>
                                <?php if (
                                    !empty($row['gambar']) &&
                                    file_exists(__DIR__ . '/' . $row['gambar'])
                                ): ?>
                                    <img
                                        class="product-image"
                                        src="<?= htmlspecialchars($row['gambar']) ?>"
                                        alt="Gambar barang"
                                    >
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?= htmlspecialchars($row['nama']) ?></strong>
                            </td>

                            <td>
                                <span class="category-badge">
                                    <?= htmlspecialchars($row['kategori']) ?>
                                </span>
                            </td>

                            <td><?= rupiah($row['harga_beli']) ?></td>

                            <td class="selling-price">
                                <?= rupiah($row['harga_jual']) ?>
                            </td>

                            <td>
                                <span class="stock-badge">
                                    <?= (int)$row['stok'] ?> Unit
                                </span>
                            </td>

                            <td class="action-buttons">
                                <a
                                    href="ubah.php?id=<?= (int)$row['id_barang'] ?>"
                                    class="edit-btn"
                                >Ubah</a>

                                <a
                                    href="hapus.php?id=<?= (int)$row['id_barang'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Yakin ingin menghapus barang ini?')"
                                >Hapus</a>
                            </td>
                        </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="empty">
                                Data barang tidak ditemukan.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </section>

        <footer>
            © 2026 Inventory Management System
            <br>
            Praktikum 8 - Aplikasi CRUD PHP dan MySQL
        </footer>

    </main>
</div>

</body>
</html>