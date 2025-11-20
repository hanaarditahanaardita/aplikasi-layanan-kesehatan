<?php
include 'koneksi.php';

// Pastikan parameter id ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Jalankan query hapus
    $hapus = mysqli_query($koneksi, "DELETE FROM pasien WHERE id_pasien='$id'");

    if ($hapus) {
        echo "<script>
            alert('✅ Data pasien berhasil dihapus');
            window.location='pasien.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menghapus data pasien');
            window.location='pasien.php';
        </script>";
    }
} else {
    // Jika parameter id tidak ada
    echo "<script>
        alert('⚠️ ID pasien tidak ditemukan');
        window.location='pasien.php';
    </script>";
}
?>
