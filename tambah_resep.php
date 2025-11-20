<?php
include 'koneksi.php';

// Ambil data pasien & obat untuk dropdown
$pasien = mysqli_query($koneksi, "SELECT * FROM pasien");
$obat = mysqli_query($koneksi, "SELECT * FROM obat");

// Variabel untuk menampung error
$pasienErr = $obatErr = $keluhanErr = $tglErr = "";

// Variabel nilai input agar tidak hilang saat error
$id_pasien = $id_obat = $keluhan = $tanggal_resep = "";

// Jika form disubmit
if (isset($_POST['simpan'])) {

    $error = false;

    // VALIDASI NAMA PASIEN
    if (empty($_POST['id_pasien'])) {
        $pasienErr = "Silakan pilih pasien!";
        $error = true;
    } else {
        $id_pasien = $_POST['id_pasien'];
    }

    // VALIDASI OBAT
    if (empty($_POST['id_obat'])) {
        $obatErr = "Silakan pilih obat!";
        $error = true;
    } else {
        $id_obat = $_POST['id_obat'];
    }

    // VALIDASI KELUHAN
    if (empty($_POST['keluhan'])) {
        $keluhanErr = "Keluhan tidak boleh kosong!";
        $error = true;
    } else {
        $keluhan = $_POST['keluhan'];
    }

    // VALIDASI TANGGAL
    if (empty($_POST['tanggal_resep'])) {
        $tglErr = "Tanggal resep wajib diisi!";
        $error = true;
    } else {
        $tanggal_resep = $_POST['tanggal_resep'];

        // Tanggal tidak boleh di masa depan
        if ($tanggal_resep > date('Y-m-d')) {
            $tglErr = "Tanggal resep tidak boleh lebih dari hari ini!";
            $error = true;
        }
    }

    // Jika tidak ada error → simpan ke database
    if (!$error) {
        $query = mysqli_query($koneksi, "
            INSERT INTO resep (id_pasien, id_obat, keluhan, tanggal_resep)
            VALUES ('$id_pasien','$id_obat','$keluhan','$tanggal_resep')
        ");

        if ($query) {
            echo "<script>alert('✅ Resep berhasil ditambahkan'); window.location='resep.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal menambah resep');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Resep | HealthApps</title>
<link rel="stylesheet" href="dashboardd.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="crud.css">
<style>
    .error { color:red; font-size:13px; }
</style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">HealthApps</div>
        </div>

        <ul class="menu">
            <li class="menu-item"><a href="dashboard.php" class="menu-link"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li class="menu-item"><a href="pasien.php" class="menu-link"><i class="fa-solid fa-user"></i> Data Pasien</a></li>
            <li class="menu-item"><a href="obat.php" class="menu-link"><i class="fa-solid fa-pills"></i> Data Obat</a></li>
            <li class="menu-item"><a href="resep.php" class="menu-link active"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
            <li class="menu-item"><a href="pembayaran.php" class="menu-link"><i class="fa-solid fa-credit-card"></i> Pembayaran</a></li>
        </ul>

        <div class="logout-section">
            <a href="logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Tambah Resep</h1>
            <a href="resep.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="form-wrapper">
            <h2>Form Tambah Resep</h2>
<form method="POST">

    <!-- PASIEN -->
    <label>Nama Pasien</label>
    <select name="id_pasien">
        <option value="">-- Pilih Pasien --</option>
        <?php
        $pasien2 = mysqli_query($koneksi, "SELECT * FROM pasien");
        while ($p = mysqli_fetch_assoc($pasien2)) { ?>
            <option value="<?= $p['id_pasien'] ?>"
                <?= ($id_pasien == $p['id_pasien']) ? "selected" : "" ?>>
                <?= $p['nama_pasien'] ?>
            </option>
        <?php } ?>
    </select>
    <?php if ($pasienErr): ?>
        <div class="text-error"><?= $pasienErr ?></div>
    <?php endif; ?>


    <!-- OBAT -->
    <label>Nama Obat</label>
    <select name="id_obat">
        <option value="">-- Pilih Obat --</option>
        <?php
        $obat2 = mysqli_query($koneksi, "SELECT * FROM obat");
        while ($o = mysqli_fetch_assoc($obat2)) { ?>
            <option value="<?= $o['id_obat'] ?>"
                <?= ($id_obat == $o['id_obat']) ? "selected" : "" ?>>
                <?= $o['nama_obat'] ?>
            </option>
        <?php } ?>
    </select>
    <?php if ($obatErr): ?>
        <div class="text-error"><?= $obatErr ?></div>
    <?php endif; ?>


    <!-- KELUHAN -->
    <label>Keluhan</label>
    <textarea name="keluhan" rows="3"><?= $keluhan ?></textarea>
    <?php if ($keluhanErr): ?>
        <div class="text-error"><?= $keluhanErr ?></div>
    <?php endif; ?>


    <!-- TANGGAL -->
    <label>Tanggal Resep</label>
    <input type="date" name="tanggal_resep" value="<?= $tanggal_resep ?>">
    <?php if ($tglErr): ?>
        <div class="text-error"><?= $tglErr ?></div>
    <?php endif; ?>


    <div class="button-group">
        <button type="submit" name="simpan"><i class="fa-solid fa-save"></i> Simpan</button>
        <a href="resep.php" class="batal">Batal</a>
    </div>

</form>

        </div>
    </div>

</body>
</html>
