<?php
require 'auth.php';
requireRole('admin');
include 'config/connect.php';

if (!isset($_GET['id'], $_GET['to'])) {
    header('Location: manage_user.php');
    exit();
}

$id = intval($_GET['id']);
$to = filter_var($_GET['to'], FILTER_SANITIZE_STRING);

if (!in_array($to, ['admin', 'user'])) {
    header('Location: manage_user.php');
    exit();
}

// Cegah perubahan role admin utama
if ($id === 1) {
    $_SESSION['flash_message'] = "❌ Tidak diperbolehkan mengubah role admin utama.";
    header('Location: manage_user.php');
    exit();
}

// Cek apakah user ada
$cek = $koneksi->prepare("SELECT user_id FROM tb_users WHERE user_id = ?");
$cek->bind_param("i", $id);
$cek->execute();
$cek->store_result();

if ($cek->num_rows === 0) {
    $_SESSION['flash_message'] = "Pengguna tidak ditemukan.";
    header('Location: manage_user.php');
    exit();
}
$cek->close();

// Update role
$stmt = $koneksi->prepare("UPDATE tb_users SET role = ? WHERE user_id = ?");
$stmt->bind_param("si", $to, $id);

$_SESSION['flash_message'] = $stmt->execute()
    ? "✅ Role berhasil diubah."
    : "❌ Gagal mengubah role.";

$stmt->close();
header('Location: manage_user.php');
exit();
?>
