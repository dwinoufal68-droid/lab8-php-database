<?php
require_once "koneksi.php";

$error = "";
$nama = $kategori = "";
$harga_beli = $harga_jual = $stok = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $kategori = trim($_POST["kategori"] ?? "");
    $harga_beli = $_POST["harga_beli"] ?? "";
    $harga_jual = $_POST["harga_jual"] ?? "";
    $stok = $_POST["stok"] ?? "";
    $gambar = "";

    if ($nama === "" || $kategori === "" || $harga_beli === "" || $harga_jual === "" || $stok === "") {
        $error = "Semua data wajib diisi kecuali gambar.";
    } elseif (!is_numeric($harga_beli) || !is_numeric($harga_jual) || !ctype_digit((string)$stok)) {
        $error = "Harga harus berupa angka dan stok harus bilangan bulat.";
    } else {
        if (isset($_FILES["file_gambar"]) && $_FILES["file_gambar"]["error"] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES["file_gambar"]["error"] !== UPLOAD_ERR_OK) {
                $error = "Upload gambar gagal.";
            } else {
                $allowed = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "webp" => "image/webp"];
                $ext = strtolower(pathinfo($_FILES["file_gambar"]["name"], PATHINFO_EXTENSION));
                $mime = mime_content_type($_FILES["file_gambar"]["tmp_name"]);
                if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
                    $error = "Format gambar harus JPG, JPEG, PNG, atau WEBP.";
                } else {
                    $newName = uniqid("barang_", true) . "." . $ext;
                    if (!move_uploaded_file($_FILES["file_gambar"]["tmp_name"], __DIR__ . "/gambar/" . $newName)) {
                        $error = "Gambar tidak dapat disimpan. Periksa folder gambar.";
                    } else {
                        $gambar = "gambar/" . $newName;
                    }
                }
            }
        }

        if ($error === "") {
            $stmt = mysqli_prepare($conn, "INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssddi", $kategori, $nama, $gambar, $harga_beli, $harga_jual, $stok);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?status=tambah");
                exit;
            }
            $error = "Data gagal disimpan: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container narrow">
    <a class="back-link" href="index.php">← Kembali ke daftar barang</a>
    <section class="panel form-panel">
        <p class="eyebrow">FORMULIR BARANG</p>
        <h1>Tambah Barang</h1>
        <p class="muted">Masukkan informasi barang yang akan disimpan.</p>
        <?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label>Nama Barang</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
            <label>Kategori</label>
            <select name="kategori" required>
                <?php foreach (["Komputer", "Elektronik", "Hand Phone"] as $k): ?>
                    <option value="<?= $k ?>" <?= $kategori === $k ? "selected" : "" ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
            <div class="form-grid">
                <div><label>Harga Beli (Rp)</label><input type="number" name="harga_beli" min="0" value="<?= htmlspecialchars((string)$harga_beli) ?>" required></div>
                <div><label>Harga Jual (Rp)</label><input type="number" name="harga_jual" min="0" value="<?= htmlspecialchars((string)$harga_jual) ?>" required></div>
            </div>
            <label>Stok</label>
            <input type="number" name="stok" min="0" value="<?= htmlspecialchars((string)$stok) ?>" required>
            <label>Gambar Barang (opsional)</label>
            <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.webp">
            <div class="form-actions">
                <button class="btn" type="submit">Simpan Barang</button>
                <a class="btn secondary" href="index.php">Batal</a>
            </div>
        </form>
    </section>
</div>
</body>
</html>
