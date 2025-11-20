<?php
session_start();
include "koneksi.php";

$error = "";

// Jika user sudah login → langsung ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST["username"]);
    $password = mysqli_real_escape_string($koneksi, $_POST["password"]);

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Jika password di database BELUM di-hash
        if ($password === $row['password']) {

            // Simpan data login ke SESSION
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'] ?? "user";

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "⚠️ Password salah.";
        }
    } else {
        $error = "⚠️ Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Aplikasi Layanan Kesehatan</title>
<link rel="stylesheet" href="loginn.css">
</head>

<body>

<!-- Background Animasi -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>

<div class="login-box">
    <div class="logo-area">
        <img src="https://cdn-icons-png.flaticon.com/512/2966/2966327.png" alt="Logo">
        <h2>Aplikasi Layanan Kesehatan</h2>
    </div>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="Masukkan Username" required>
        <input type="password" name="password" placeholder="Masukkan Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="footer">
      © 2025 Layanan Kesehatan<br>
      <a href="#">Pusat Bantuan</a> • <a href="#">Tentang Kami</a>
    </div>
</div>

</body>
</html>
