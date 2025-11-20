<?php
include 'koneksi.php';

$error_nama = "";
$error_umur = "";
$error_jk = "";
$error_alamat = "";
$error_tgl = "";

$nama = "";
$umur = "";
$jk = "";
$alamat = "";
$tgl = "";

if (isset($_POST['simpan'])) {

    $nama   = trim($_POST['nama_pasien']);
    $umur   = trim($_POST['umur']);
    $jk     = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $tgl    = trim($_POST['tanggal_berobat']);

    // Validasi
    if (empty($nama)) {
        $error_nama = "Nama pasien tidak boleh kosong.";
    }

    if (empty($umur)) {
        $error_umur = "Umur tidak boleh kosong.";
    } elseif ($umur <= 0) {
        $error_umur = "Umur tidak valid.";
    }

    if (empty($jk)) {
        $error_jk = "Jenis kelamin harus dipilih.";
    }

    if (empty($alamat)) {
        $error_alamat = "Alamat tidak boleh kosong.";
    }

    if (empty($tgl)) {
        $error_tgl = "Tanggal berobat tidak boleh kosong.";
    }

    // Jika tidak ada error → simpan
    if ($error_nama == "" && $error_umur == "" && $error_jk == "" && $error_alamat == "" && $error_tgl == "") {

        $insert = mysqli_query($koneksi, "
            INSERT INTO pasien (nama_pasien, umur, jenis_kelamin, alamat, tanggal_berobat)
            VALUES ('$nama', '$umur', '$jk', '$alamat', '$tgl')
        ");

        if ($insert) {
            echo "<script>alert('✅ Data pasien berhasil disimpan'); window.location='pasien.php';</script>";
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasien | HealthApps</title>

    <link rel="stylesheet" href="dashboardd.css">
    <link rel="stylesheet" href="crud.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">HealthApps</div>
    </div>

    <ul class="menu">
        <li class="menu-item"><a href="dashboard.php" class="menu-link"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        <li class="menu-item"><a href="pasien.php" class="menu-link active"><i class="fa-solid fa-user"></i> Data Pasien</a></li>
        <li class="menu-item"><a href="obat.php" class="menu-link"><i class="fa-solid fa-pills"></i> Data Obat</a></li>
        <li class="menu-item"><a href="resep.php" class="menu-link"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
        <li class="menu-item"><a href="pembayaran.php" class="menu-link"><i class="fa-solid fa-credit-card"></i> Pembayaran</a></li>
    </ul>

    <div class="logout-section">
        <a href="logout.php" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</div>

<div class="main-content">
    <div class="header">
        <h1>Tambah Pasien</h1>
        <a href="pasien.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="form-wrapper">
        <h2>Form Tambah Data Pasien</h2>

        <form method="POST" action="">
            
            <form method="POST" action="">
    
    <!-- NAMA -->
    <label>Nama Pasien</label>
    <input type="text" name="nama_pasien" value="<?= $nama ?>">
    <?php if ($error_nama): ?>
        <div class="text-error"><?= $error_nama ?></div>
    <?php endif; ?>

    <!-- UMUR -->
    <label>Umur</label>
    <input type="number" name="umur" value="<?= $umur ?>">
    <?php if ($error_umur): ?>
        <div class="text-error"><?= $error_umur ?></div>
    <?php endif; ?>

    <!-- JENIS KELAMIN -->
    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin">
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="laki-laki" <?= ($jk == "laki-laki") ? "selected" : "" ?>>Laki-laki</option>
        <option value="perempuan" <?= ($jk == "perempuan") ? "selected" : "" ?>>Perempuan</option>
    </select>
    <?php if ($error_jk): ?>
        <div class="text-error"><?= $error_jk ?></div>
    <?php endif; ?>

    <!-- ALAMAT -->
    <label>Alamat</label>
    <input type="text" name="alamat" value="<?= $alamat ?>">
    <?php if ($error_alamat): ?>
        <div class="text-error"><?= $error_alamat ?></div>
    <?php endif; ?>

    <!-- TANGGAL -->
    <label>Tanggal Berobat</label>
    <input type="date" name="tanggal_berobat" value="<?= $tgl ?>">
    <?php if ($error_tgl): ?>
        <div class="text-error"><?= $error_tgl ?></div>
    <?php endif; ?>

    <div class="button-group">
        <button type="submit" name="simpan"><i class="fa-solid fa-save"></i> Simpan</button>
        <a href="pasien.php" class="batal">Batal</a>
    </div>

</form>
</div>

</body>
</html>
