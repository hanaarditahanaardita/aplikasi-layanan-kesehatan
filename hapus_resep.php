<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM resep WHERE id_resep = '$id'");

    if ($hapus) {
        echo "<script>alert('✅ Data resep berhasil dihapus'); window.location='resep.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menghapus data resep'); window.location='resep.php';</script>";
    }
} else {
    echo "<script>alert('ID resep tidak ditemukan!'); window.location='resep.php';</script>";
}
?>
