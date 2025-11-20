<?php
include 'koneksi.php';

// Cek apakah ada input pencarian
if (isset($_GET['cari']) && $_GET['cari'] != '') {
    $cari = $_GET['cari'];
    $query = mysqli_query($koneksi, "SELECT * FROM obat WHERE nama_obat LIKE '%$cari%' ");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM obat");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Obat | HealthApps</title>
  <link rel="stylesheet" href="obat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
      <div class="sidebar-logo">
          <div class="logo-text">HealthApps</div>
      </div>

        <ul class="menu">
            <li class="menu-item">
                <a href="dashboard.php" class="menu-link">
                    <span class="menu-icon"><i class="fa-solid fa-house"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="pasien.php" class="menu-link">
                    <span class="menu-icon"><i class="fa-solid fa-user"></i></span>
                    <span class="menu-text">Data Pasien</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="obat.php" class="menu-link active">
                    <span class="menu-icon"><i class="fa-solid fa-pills"></i></span>
                    <span class="menu-text">Data Obat</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="resep.php" class="menu-link">
                    <span class="menu-icon"><i class="fa-solid fa-file-prescription"></i></span>
                    <span class="menu-text">Resep Obat</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="pembayaran.php" class="menu-link">
                    <span class="menu-icon"><i class="fa-solid fa-credit-card"></i></span>
                    <span class="menu-text">Pembayaran</span>
                </a>
            </li>
        </ul>

        <div class="logout-section">
            <a href="logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
      <div class="header">
          <h1>Data Obat</h1>
      </div>

      <a href="tambah_obat.php" class="add-link">+ Tambah Obat</a>

    <!-- 🔍 FORM PENCARIAN OBAT -->
<form method="GET" action="" class="search-form">
    <input type="text" name="cari"
        placeholder="Cari nama obat..."
        value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">

    <button type="submit" class="btn-search">
        <i class="fa-solid fa-magnifying-glass"></i> Search
    </button>
</form>

      <div class="table-container">
          <table>
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Obat</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                  </tr>
              </thead>

              <tbody>
                  <?php
                  $no = 1; // nomor otomatis dimulai dari 1

                  if (mysqli_num_rows($query) > 0) {
                      while ($data = mysqli_fetch_assoc($query)) {
                          echo "
                          <tr>
                              <td>".$no++."</td>
                              <td>".$data['nama_obat']."</td>
                              <td>".$data['deskripsi']."</td>
                              <td>Rp ".number_format($data['harga'], 0, ',', '.')."</td>
                              <td>
                                  <a href='edit_obat.php?id=".$data['id_obat']."' style='color:#059669; font-weight:600;'>Edit</a> |
                                  <a href='hapus_obat.php?id=".$data['id_obat']."' style='color:#dc2626; font-weight:600;' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                              </td>
                          </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='5' style='text-align:center;'>Data tidak ditemukan</td></tr>";
                  }
                  ?>
              </tbody>

          </table>
      </div>
  </div>

</body>
</html>
