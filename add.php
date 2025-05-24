<?php include 'config/connect.php';

require 'auth.php';
requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode     = $_POST['kode_barang'];
    $nama     = $_POST['nama_barang'];
    $jumlah   = $_POST['jumlah_barang'];
    $satuan   = $_POST['satuan_barang'];
    $harga    = $_POST['harga_beli'];
    $status   = $_POST['status_barang'];

    $sql = "INSERT INTO tb_inventory (kode_barang, nama_barang, jumlah_barang, satuan_barang, harga_beli, status_barang)
            VALUES ('$kode', '$nama', $jumlah, '$satuan', $harga, $status)";
    if ($koneksi->query($sql)) {
        echo "<div class='alert alert-success'>Barang berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>
                Gagal menambahkan barang: " . $koneksi->error . "
            </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>Tambah Barang</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Barang</label>
            <input type="number" name="jumlah_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Satuan Barang</label>
            <select name="satuan_barang" class="form-control" required>
                <option value="pcs">pcs</option>
                <option value="kg">kg</option>
                <option value="liter">liter</option>
                <option value="meter">meter</option>
                <option value="unit">unit</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status Barang</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_barang" value="1" checked>
                <label class="form-check-label">Available</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status_barang" value="0">
                <label class="form-check-label">Not-Available</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
