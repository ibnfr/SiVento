<?php
include 'config/connect.php';
require 'auth.php';
requireRole('admin');

if (!isset($_GET['id'])) {
    die("ID barang tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data barang
$query = $koneksi->query("SELECT * FROM tb_inventory WHERE id_barang = $id");
$barang = $query->fetch_assoc();

if (!$barang) {
    die("Barang tidak ditemukan.");
}

// Jika tombol hapus ditekan
if (isset($_POST['hapus'])) {
    $koneksi->query("DELETE FROM tb_inventory WHERE id_barang = $id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hapus Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
    <h2>Konfirmasi Hapus Barang</h2>

    <div class="alert alert-danger">
        <strong>Apakah Anda yakin ingin menghapus barang berikut?</strong><br>
        <ul>
            <li><strong>Nama:</strong> <?= $barang['nama_barang'] ?></li>
            <li><strong>Kode:</strong> <?= $barang['kode_barang'] ?></li>
            <li><strong>Jumlah:</strong> <?= $barang['jumlah_barang'] ?></li>
        </ul>
    </div>

    <form method="POST">
        <button type="submit" name="hapus" class="btn btn-danger">Ya, Hapus</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
