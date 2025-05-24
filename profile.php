<?php
require 'auth.php';
requireLogin(); // Pastikan user sudah login
include 'config/connect.php';

$user_id = $_SESSION['user_id'];

$stmt = $koneksi->prepare("SELECT * FROM tb_users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$dashboard = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['image']['name'])) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $tmpFile = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowedExts)) {
            $newImageName = uniqid('img_') . '.' . $ext;
            move_uploaded_file($tmpFile, "uploads/" . $newImageName);

            $updateImg = $koneksi->prepare("UPDATE tb_users SET image=? WHERE user_id=?");
            $updateImg->bind_param("si", $newImageName, $user_id);
            $updateImg->execute();

            // Perbarui variabel lokal agar langsung terlihat
            $user['image'] = $newImageName;
            $success = "Foto profil berhasil diupdate.";
        } else {
            $error = "Format gambar tidak valid (hanya JPG, PNG, GIF).";
        }
    }

    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';

    $update = $koneksi->prepare("UPDATE tb_users SET full_name=?, email=?, no_hp=? WHERE user_id=?");
    $update->bind_param("sssi", $full_name, $email, $no_hp, $user_id);

    if ($update->execute()) {
        $success = "Profil berhasil diperbarui.";
        $user['full_name'] = $full_name;
        $user['email'] = $email;
        $user['no_hp'] = $no_hp;
    } else {
        $error = "Gagal memperbarui profil.";
    }

    $update->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Saya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4">Profil Saya</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($user['no_hp']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Profil</label><br>
            <img src="uploads/<?= htmlspecialchars($user['image'] ?? 'default.png') ?>" width="100" class="mb-2 rounded-circle shadow-sm">
            <input type="file" name="image" class="form-control">
        </div>


        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a class="btn btn-danger" href="<?= $dashboard ?>">Kembali</a>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
