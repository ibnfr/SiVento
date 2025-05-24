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

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_tambah = (int)$_POST['jumlah_tambah'];
    $stok_sekarang = (int)$barang['jumlah_barang'];

    if ($jumlah_tambah <= 0) {
        $error = "Jumlah yang ditambahkan harus lebih dari 0.";
    } else {
        $stok_baru = $stok_sekarang + $jumlah_tambah;
        $status_baru = $stok_baru > 0 ? 1 : 0;

        $koneksi->query("UPDATE tb_inventory SET jumlah_barang = $stok_baru, status_barang = $status_baru WHERE id_barang = $id");
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Stok Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>Tambah Stok Barang</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nama Barang:</label>
            <input type="text" class="form-control" value="<?= $barang['nama_barang'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label>Stok Sekarang:</label>
            <input type="number" class="form-control" value="<?= $barang['jumlah_barang'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label>Jumlah yang Ditambahkan:</label>
            <input type="number" name="jumlah_tambah" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Stok</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
