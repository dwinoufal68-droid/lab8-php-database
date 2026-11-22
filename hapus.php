<?php
require_once "koneksi.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    die("ID barang tidak valid.");
}

$stmt = mysqli_prepare($conn, "DELETE FROM data_barang WHERE id_barang = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (!mysqli_stmt_execute($stmt)) {
    die("Data gagal dihapus: " . mysqli_error($conn));
}

header("Location: index.php?status=hapus");
exit;
?>
