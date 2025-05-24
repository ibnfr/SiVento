<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

include 'config/connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container py-4">
        <h2>Data Barang</h2>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="add.php" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </a>
        <?php endif; ?>
        <table id="barangTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = $koneksi->query("SELECT * FROM tb_inventory");
            while ($row = $result->fetch_assoc()) {
                $status = $row['status_barang'] ? "Available" : "Not-Available";
                $disabled = $row['status_barang'] == 0 ? 'disabled' : '';
                $tooltip = $row['status_barang'] == 0 ? 'Barang tidak tersedia' : 'Gunakan barang';

                $adminButtons = '';
                if ($_SESSION['role'] === 'admin') {
                    $adminButtons = "
                        <a href='add_stock.php?id={$row['id_barang']}' class='btn btn-success btn-sm'>Stok</a>
                        <a href='edit.php?id={$row['id_barang']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete.php?id={$row['id_barang']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus barang ini?')\">Hapus</a>
                    ";
                }

                echo "<tr>
                    <td>{$row['kode_barang']}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>{$row['jumlah_barang']}</td>
                    <td>{$row['satuan_barang']}</td>
                    <td>Rp " . number_format($row['harga_beli'], 2, ',', '.') . "</td>
                    <td>
                        <span class='badge " . ($row['status_barang'] ? 'bg-success' : 'bg-danger') . "'>
                            " . ($row['status_barang'] ? 'Available' : 'Not-Available') . "
                        </span>
                    </td>
                    <td>
                        <a href='usage.php?id={$row['id_barang']}' class='btn btn-primary btn-sm {$disabled}' title='{$tooltip}'>Pakai</a>
                        {$adminButtons}
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#barangTable').DataTable();
            });
        </script>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
