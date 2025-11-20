<?php
include 'koneksi.php';

// Ambil nilai filter
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Query dasar
$query_sql = "
    SELECT payment.*, pasien.nama_pasien, resep.id_resep 
    FROM payment
    JOIN resep ON payment.id_resep = resep.id_resep
    JOIN pasien ON resep.id_pasien = pasien.id_pasien
    WHERE 1=1
";

// Filter search nama pasien
if ($cari != '') {
    $query_sql .= " AND pasien.nama_pasien LIKE '%$cari%'";
}

// Filter status
if ($status != '') {
    $query_sql .= " AND payment.status = '$status'";
}

// Urutkan terbaru
$query_sql .= " ORDER BY id_payment ASC";

$query = mysqli_query($koneksi, $query_sql);

// Locale Indonesia
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'Indonesian');
putenv('LC_ALL=id_ID.utf8');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran | HealthApps</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="pembayaran.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">HealthApps</div>
        </div>

        <ul class="menu">
            <li class="menu-item"><a href="dashboard.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-house"></i></span><span class="menu-text">Dashboard</span></a></li>
            <li class="menu-item"><a href="pasien.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-user"></i></span><span class="menu-text">Data Pasien</span></a></li>
            <li class="menu-item"><a href="obat.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-pills"></i></span><span class="menu-text">Data Obat</span></a></li>
            <li class="menu-item"><a href="resep.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-file-prescription"></i></span><span class="menu-text">Resep Obat</span></a></li>
            <li class="menu-item"><a href="pembayaran.php" class="menu-link active"><span class="menu-icon"><i class="fa-solid fa-credit-card"></i></span><span class="menu-text">Pembayaran</span></a></li>
        </ul>

        <div class="logout-section">
            <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Data Pembayaran</h1>
        </div>

        <a href="tambah_pembayaran.php" class="add-link">+ Tambah Pembayaran</a>

        <div class="tools-container">

            <!-- SEARCH KIRI -->
            <div class="tools-left">
                <form method="GET" action="">
                    <input type="text" name="cari" value="<?= $cari; ?>" placeholder="Cari nama pasien...">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                </form>
            </div>

            <!-- FILTER + EXPORT KANAN -->
            <div class="tools-right">
                <form method="GET" action="">
                    <select name="status">
                        <option value="">-- Status --</option>
                        <option value="sudah bayar" <?= ($status == 'sudah bayar') ? 'selected' : '' ?>>Sudah Bayar</option>
                        <option value="belum bayar" <?= ($status == 'belum bayar') ? 'selected' : '' ?>>Belum Bayar</option>
                    </select>

                    <button type="submit" class="btn-filter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </form>

                <a href="export_pembayaran.php" class="btn-export">
                    <i class="fa-solid fa-file-excel"></i> Export
                </a>
            </div>
        </div>


       <!-- TABEL -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No Resep</th>
                <th>Total Harga</th>
                <th>Tanggal Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;         // nomor pembayaran
            $no_resep = 1;   // nomor resep baru

            while ($data = mysqli_fetch_assoc($query)) {
                $tanggal_pembayaran = strftime('%d %B %Y', strtotime($data['tanggal_pembayaran']));

                if ($data['status'] == 'sudah bayar') {
                    $badge = '<span class="badge text-bg-success">Sudah Bayar</span>';
                } else {
                    $badge = '<span class="badge text-bg-danger">Belum Bayar</span>';
                }
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nama_pasien']; ?></td>
                <td><?= $no_resep++; ?></td>
                <td>Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></td>
                <td><?= $tanggal_pembayaran; ?></td>
                <td><?= $data['metode_pembayaran']; ?></td>
                <td><?= $badge; ?></td>
                <td>
                    <a href="edit_pembayaran.php?id=<?= $data['id_payment']; ?>" class="edit-btn">Edit</a> |
                    <a href="hapus_pembayaran.php?id=<?= $data['id_payment']; ?>"
                       class="delete-btn"
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
