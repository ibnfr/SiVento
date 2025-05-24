<?php
require 'auth.php';
include 'config/connect.php';

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
    $jumlah_pakai = (int)$_POST['jumlah_pakai'];
    $stok_sekarang = (int)$barang['jumlah_barang'];

    if ($jumlah_pakai <= 0) {
        $error = "Jumlah pemakaian harus lebih dari 0.";
    } elseif ($jumlah_pakai > $stok_sekarang) {
        $error = "Jumlah pemakaian melebihi stok!";
    } else {
        $sisa = $stok_sekarang - $jumlah_pakai;
        $status = $sisa == 0 ? 0 : 1;

        $koneksi->query("UPDATE tb_inventory SET jumlah_barang = $sisa, status_barang = $status WHERE id_barang = $id");
        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemakaian Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>Pemakaian Barang</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($barang['status_barang'] == 0): ?>
    <div class="alert alert-warning">
        Barang ini sedang <strong>Not-Available</strong>, tidak dapat digunakan.
    </div>
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
            <label>Jumlah yang Dipakai:</label>
            <input type="number" name="jumlah_pakai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Gunakan Barang</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
