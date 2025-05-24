<?php
require 'auth.php';
requireRole('admin'); // Pastikan hanya admin yang bisa akses
include 'config/connect.php';

if (!isset($_GET['id'])) {
    header('Location: manage_user.php');
    exit();
}

$id = intval($_GET['id']);

// Ambil data user berdasarkan id
$stmt = $koneksi->prepare("SELECT * FROM tb_users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User tidak ditemukan.";
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // Validasi sederhana (bisa dikembangkan)
    if (!$username || !$full_name || !$email || !$role) {
        $error = "Semua field wajib diisi.";
    } else {
        $update_stmt = $koneksi->prepare("UPDATE tb_users SET username=?, full_name=?, email=?, no_hp=?, role=? WHERE user_id=?");
        $update_stmt->bind_param("sssssi", $username, $full_name, $email, $no_hp, $role, $id);
        if ($update_stmt->execute()) {
            $_SESSION['flash_message'] = "Data pengguna berhasil diperbarui.";
            header('Location: manage_user.php');
            exit();
        } else {
            $error = "Gagal memperbarui data pengguna.";
        }
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container py-4" style="max-width: 600px;">
    <h2 class="mb-4">Edit Pengguna</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username *</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="full_name" class="form-label">Nama Lengkap *</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($user['no_hp']) ?>">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role *</label>
            <select id="role" name="role" class="form-select" required>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="manage_user.php" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
