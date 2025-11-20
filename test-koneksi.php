<?php
// Panggil file koneksi
include 'koneksi.php';

// Jika koneksi berhasil
if ($koneksi) {
    echo "✅ Koneksi ke database berhasil!";
} else {
    echo "❌ Koneksi gagal: " . mysqli_connect_error();
}
?>