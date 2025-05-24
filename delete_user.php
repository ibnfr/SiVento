<?php
require 'auth.php';
requireRole('admin'); // Pastikan hanya admin yang bisa akses
include 'config/connect.php';

if (!isset($_GET['id'])) {
    header('Location: manage_user.php');
    exit();
}

$id = intval($_GET['id']);

// (Opsional) Cek agar admin tidak bisa hapus dirinya sendiri misalnya
if ($_SESSION['user_id'] == $id) {
    $_SESSION['flash_message'] = "Anda tidak dapat menghapus akun sendiri.";
    header('Location: manage_user.php');
    exit();
}

// Hapus user dari database
$stmt = $koneksi->prepare("DELETE FROM tb_users WHERE user_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['flash_message'] = "User berhasil dihapus.";
} else {
    $_SESSION['flash_message'] = "Gagal menghapus user.";
}

$stmt->close();

header('Location: manage_user.php');
exit();
