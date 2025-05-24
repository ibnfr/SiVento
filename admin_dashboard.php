<?php
require 'auth.php';
requireRole('admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Selamat datang, Admin!</h2>
        <p>Gunakan menu di atas untuk mengelola sistem.</p>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Barang</h5>
                        <p class="card-text">Tambah, update, atau hapus data barang.</p>
                        <a href="index.php" class="btn btn-primary">Ke Data Barang</a>
                    </div>
                </div>
            </div>
        
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen User</h5>
                        <p class="card-text">Lihat dan ubah role pengguna.</p>
                        <a href="manage_user.php" class="btn btn-info">Kelola User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
