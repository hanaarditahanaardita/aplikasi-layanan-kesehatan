<?php
include 'koneksi.php';

// Ambil input pencarian
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$dari = isset($_GET['dari']) ? $_GET['dari'] : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

// Query dasar
$query_sql = "
    SELECT resep.*, pasien.nama_pasien, obat.nama_obat 
    FROM resep
    JOIN pasien ON resep.id_pasien = pasien.id_pasien
    JOIN obat ON resep.id_obat = obat.id_obat
    WHERE 1=1
";

// Filter pencarian nama pasien / obat
if ($cari != '') {
    $query_sql .= " AND (pasien.nama_pasien LIKE '%$cari%' 
                    OR obat.nama_obat LIKE '%$cari%')";
}

// Filter rentang tanggal
if ($dari != '' && $sampai != '') {
    $query_sql .= " AND tanggal_resep BETWEEN '$dari' AND '$sampai'";
}

// Urutkan terbaru
$query_sql .= " ORDER BY id_resep ASC";

$query = mysqli_query($koneksi, $query_sql);

// Tanggal Indonesia
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Resep | HealthApps</title>
  <link rel="stylesheet" href="resep.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
      <div class="sidebar-logo"><div class="logo-text">HealthApps</div></div>

      <ul class="menu">
          <li class="menu-item"><a href="dashboard.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-house"></i></span><span class="menu-text">Dashboard</span></a></li>
          <li class="menu-item"><a href="pasien.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-user"></i></span><span class="menu-text">Data Pasien</span></a></li>
          <li class="menu-item"><a href="obat.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-pills"></i></span><span class="menu-text">Data Obat</span></a></li>
          <li class="menu-item"><a href="resep.php" class="menu-link active"><span class="menu-icon"><i class="fa-solid fa-file-prescription"></i></span><span class="menu-text">Resep Obat</span></a></li>
          <li class="menu-item"><a href="pembayaran.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-credit-card"></i></span><span class="menu-text">Pembayaran</span></a></li>
      </ul>

      <div class="logout-section">
          <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
      </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
      <div class="header"><h1>Data Resep</h1></div>

      <a href="tambah_resep.php" class="add-link">+ Tambah Resep</a>

      <div class="filter-container">

      <div class="tools-row">
      <!-- SEARCH KIRI -->
      <form method="GET" action="" class="search-box">
          <input type="text" name="cari" 
                 placeholder="Cari nama pasien / obat..."
                 value="<?= $cari; ?>">
          <button type="submit">
              <i class="fa-solid fa-magnifying-glass"></i> Search
          </button>
      </form>

      <!-- FILTER TANGGAL KANAN -->
      <form method="GET" action="" class="date-filter">
          <input type="date" name="dari" value="<?= $dari; ?>">
          <input type="date" name="sampai" value="<?= $sampai; ?>">
          <button type="submit">
              <i class="fa-solid fa-calendar"></i> Filter
          </button>
      </form>
    </div>

      <div class="table-container">
          <table>
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Pasien</th>
                      <th>Nama Obat</th>
                      <th>Keluhan</th>
                      <th>Tanggal Resep</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>

                  <?php 
                  $no = 1; // nomor urut dimulai dari 1

                  while ($data = mysqli_fetch_assoc($query)) { 
                      $tanggal_resep = strftime('%d %B %Y', strtotime($data['tanggal_resep']));
                  ?>

                  <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $data['nama_pasien']; ?></td>
                      <td><?= $data['nama_obat']; ?></td>
                      <td><?= $data['keluhan']; ?></td>
                      <td><?= $tanggal_resep; ?></td>
                      <td>
                          <a href="edit_resep.php?id=<?= $data['id_resep']; ?>" class="edit-btn">Edit</a> |
                          <a href="hapus_resep.php?id=<?= $data['id_resep']; ?>" class="delete-btn"
                             onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                      </td>
                  </tr>

                  <?php } ?>

              </tbody>
          </table>
      </div>
  </div>

</body>
</html>
