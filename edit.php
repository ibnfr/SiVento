<?php
include 'config/connect.php';
require 'auth.php';
requireRole('admin');

if (!isset($_GET['id'])) {
    die("ID barang tidak ditemukan.");
}

$id = $_GET['id'];
$query = $koneksi->query("SELECT * FROM tb_inventory WHERE id_barang = $id");
$barang = $query->fetch_assoc();

if (!$barang) {
    die("Barang tidak ditemukan.");
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode     = $_POST['kode_barang'];
    $nama     = $_POST['nama_barang'];
    $jumlah   = (int)$_POST['jumlah_barang'];
    $satuan   = $_POST['satuan_barang'];
    $harga    = (float)$_POST['harga_beli'];
    $status   = (int)$_POST['status_barang'];

    $update = $koneksi->query("UPDATE tb_inventory SET 
        kode_barang = '$kode',
        nama_barang = '$nama',
        jumlah_barang = $jumlah,
        satuan_barang = '$satuan',
        harga_beli = $harga,
        status_barang = $status
        WHERE id_barang = $id");

    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>Edit Barang</h2>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" value="<?= $barang['kode_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= $barang['nama_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Barang</label>
            <input type="number" name="jumlah_barang" class="form-control" value="<?= $barang['jumlah_barang'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Satuan Barang</label>
            <select name="satuan_barang" class="form-control" required>
                <?php
                $satuan = ["pcs", "kg", "liter", "meter", "unit"];
                foreach ($satuan as $s) {
                    $selected = $barang['satuan_barang'] == $s ? 'selected' : '';
                    echo "<option value='$s' $selected>$s</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli" class="form-control" value="<?= $barang['harga_beli'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Status Barang</label><br>
            <div class="form-check form-check-inline">
                <input type="radio" name="status_barang" value="1" class="form-check-input" <?= $barang['status_barang'] ? 'checked' : '' ?>>
                <label class="form-check-label">Available</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status_barang" value="0" class="form-check-input" <?= !$barang['status_barang'] ? 'checked' : '' ?>>
                <label class="form-check-label">Not-Available</label>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Update Barang</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
