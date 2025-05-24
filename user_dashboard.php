<?php
require 'auth.php';
requireRole('user');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Halo, <?= $_SESSION['full_name'] ?>!</h2>
        <p>Selamat datang di Sistem Inventory.</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-body">
                        <h5 class="card-title">Lihat Data Barang</h5>
                        <p class="card-text">Cek stok dan status barang yang tersedia.</p>
                        <a href="index.php" class="btn btn-success">Lihat Barang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
