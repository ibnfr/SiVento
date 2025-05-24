<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

function requireLogin() {
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit();
    }
}

function requireRole($role) {
    if (!isLoggedIn() || $_SESSION['role'] !== $role) {
        header("Location: unauthorized.php"); // Halaman error
        exit();
    }
}
