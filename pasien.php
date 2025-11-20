<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pasien | HealthApps</title>
  <link rel="stylesheet" href="pasienn.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">HealthApps</div>
    </div>

    <ul class="menu">
        <li class="menu-item"><a href="dashboard.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-house"></i></span><span class="menu-text">Dashboard</span></a></li>
        <li class="menu-item"><a href="pasien.php" class="menu-link active"><span class="menu-icon"><i class="fa-solid fa-user"></i></span><span class="menu-text">Data Pasien</span></a></li>
        <li class="menu-item"><a href="obat.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-pills"></i></span><span class="menu-text">Data Obat</span></a></li>
        <li class="menu-item"><a href="resep.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-file-prescription"></i></span><span class="menu-text">Resep Obat</span></a></li>
        <li class="menu-item"><a href="pembayaran.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-credit-card"></i></span><span class="menu-text">Pembayaran</span></a></li>
    </ul>

    <div class="logout-section">
        <a href="logout.php" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Main Content -->
<main class="main-content">
    <div class="header">
        <h1>Data Pasien</h1>
    </div>

    <a href="tambah_pasien.php" class="add-link">+ Tambah Pasien</a>

   <!-- 🔍 FORM PENCARIAN -->
<form method="GET" action="" class="search-form">
    <input type="text" name="cari"
           placeholder="Cari nama pasien..."
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
                    <th>Nama Pasien</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal Berobat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php
            setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian');

            $cari = isset($_GET['cari']) ? $_GET['cari'] : '';

            if ($cari != '') {
                $query = mysqli_query($koneksi, "SELECT * FROM pasien 
                                                 WHERE nama_pasien LIKE '%$cari%'
                                                 ORDER BY id_pasien ASC");
            } else {
                $query = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id_pasien ASC");
            }

            $no = 1; // NOMOR URUT DIMULAI DARI 1

            while ($data = mysqli_fetch_array($query)) {
                $tanggal_indo = strftime('%d %B %Y', strtotime($data['tanggal_berobat']));

                echo "
                <tr>
                    <td>$no</td>
                    <td>{$data['nama_pasien']}</td>
                    <td>{$data['umur']}</td>
                    <td>{$data['jenis_kelamin']}</td>
                    <td>{$data['alamat']}</td>
                    <td>$tanggal_indo</td>
                    <td>
                        <a href='edit_pasien.php?id={$data['id_pasien']}' style='color:#059669; font-weight:600;'>Edit</a> | 
                        <a href='hapus_pasien.php?id={$data['id_pasien']}' style='color:#dc2626; font-weight:600;' onclick=\"return confirm('Yakin ingin menghapus?');\">Hapus</a>
                    </td>
                </tr>
                ";

                $no++; // INCREMENT NOMOR URUT
            }
            ?>

            </tbody>
        </table>
    </div>
</main>

</body>
</html>
