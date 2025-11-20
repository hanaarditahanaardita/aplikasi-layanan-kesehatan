<?php
session_start();
include 'koneksi.php';

// --- Jika user logout ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit; 
}

// --- Cek apakah user sudah login ---
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $isLogin = true;
} else {
    $isLogin = false;
}

// --- Proses login ---
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $username_akun && $pass === $password_akun) {
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>