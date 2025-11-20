<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM payment WHERE id_payment='$id'");

    if ($hapus) {
        echo "<script>alert('✅ Data pembayaran berhasil dihapus!'); window.location='pembayaran.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menghapus data!'); window.location='pembayaran.php';</script>";
    }
}
?>
