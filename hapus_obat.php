<?php
include 'koneksi.php';

// Pastikan ID dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Jalankan query hapus berdasarkan id_obat
    $hapus = mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat='$id'");

    if ($hapus) {
        echo "<script>
                alert('✅ Data obat berhasil dihapus');
                window.location='obat.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location='obat.php';
              </script>";
    }
} else {
    // Jika tidak ada ID di URL
    echo "<script>
            alert('❌ ID obat tidak ditemukan');
            window.location='obat.php';
          </script>";
}
?>
