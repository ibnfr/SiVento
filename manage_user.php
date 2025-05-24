<?php
require 'auth.php';
requireRole('admin'); // Pastikan fungsi ini valid dan memeriksa role admin
include 'config/connect.php';

$result = $koneksi->query("SELECT * FROM tb_users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container py-4">
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['flash_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
    <h2 class="mb-4">Kelola Pengguna</h2>

    <table id="usersTable" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td>
                        <span class="badge <?= $row['role'] === 'admin' ? 'bg-success' : 'bg-secondary' ?>">
                            <?= htmlspecialchars(ucfirst($row['role'])) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['role'] !== 'admin'): ?>
                            <a href="change_role.php?id=<?= $row['user_id'] ?>&to=admin" class="btn btn-sm btn-outline-primary" title="Jadikan Admin">
                                <i class="bi bi-shield-lock"></i> Admin
                            </a>
                        <?php endif; ?>
                        <?php if ($row['role'] !== 'user'): ?>
                            <a href="change_role.php?id=<?= $row['user_id'] ?>&to=user" class="btn btn-sm btn-outline-secondary" title="Jadikan User">
                                <i class="bi bi-person"></i> User
                            </a>
                        <?php endif; ?>
                        <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="delete_user.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pengguna ini?')" title="Hapus">
                            <i class="bi bi-trash"></i> 
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50],
            "order": [[ 0, "asc" ]]
        });
    });
</script>

</body>
</html>
