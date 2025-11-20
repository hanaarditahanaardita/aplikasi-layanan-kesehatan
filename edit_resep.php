<?php
include 'koneksi.php';

// Pastikan ada ID resep yang dikirim
if (!isset($_GET['id'])) {
    echo "<script>alert('ID resep tidak ditemukan!'); window.location='resep.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data resep berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM resep WHERE id_resep = '$id'");
$data = mysqli_fetch_assoc($query);

// Ambil data pasien & obat untuk dropdown
$pasien = mysqli_query($koneksi, "SELECT * FROM pasien");
$obat = mysqli_query($koneksi, "SELECT * FROM obat");

// Variabel input & error
$errors = [];
$id_pasien = $data['id_pasien'];
$id_obat = $data['id_obat'];
$keluhan = $data['keluhan'];
$tgl = $data['tanggal_resep'];

if (isset($_POST['update'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_obat = $_POST['id_obat'];
    $keluhan = trim($_POST['keluhan']);
    $tgl = $_POST['tanggal_resep'];

    // ===== VALIDASI =====
    if ($id_pasien == "") {
        $errors['id_pasien'] = "Silakan pilih pasien";
    }
    if ($id_obat == "") {
        $errors['id_obat'] = "Silakan pilih obat";
    }
    if ($keluhan == "") {
        $errors['keluhan'] = "Keluhan tidak boleh kosong";
    }
    if ($tgl == "") {
        $errors['tgl'] = "Tanggal resep tidak boleh kosong";
    }

    // Jika tidak ada error → update
    if (empty($errors)) {
        $update = mysqli_query($koneksi, "
            UPDATE resep 
            SET id_pasien='$id_pasien', id_obat='$id_obat', keluhan='$keluhan', tanggal_resep='$tgl'
            WHERE id_resep='$id'
        ");

        if ($update) {
            echo "<script>alert('✅ Data resep berhasil diperbarui'); window.location='resep.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Gagal memperbarui data resep');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Resep | HealthApps</title>
<link rel="stylesheet" href="dashboardd.css">
<link rel="stylesheet" href="crud.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo"><div class="logo-text">HealthApps</div></div>
    <ul class="menu">
        <li class="menu-item"><a href="dashboard.php" class="menu-link"><i class="fa-solid fa-house"></i> Dashboard</a></li>
        <li class="menu-item"><a href="pasien.php" class="menu-link"><i class="fa-solid fa-user"></i> Data Pasien</a></li>
        <li class="menu-item"><a href="obat.php" class="menu-link"><i class="fa-solid fa-pills"></i> Data Obat</a></li>
        <li class="menu-item"><a href="resep.php" class="menu-link active"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
        <li class="menu-item"><a href="pembayaran.php" class="menu-link"><i class="fa-solid fa-credit-card"></i> Pembayaran</a></li>
    </ul>
    <div class="logout-section">
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="header">
        <h1>Edit Resep</h1>
        <a href="resep.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="form-wrapper">
        <h2>Form Edit Resep</h2>
        <form method="POST">

            <!-- Nama Pasien -->
            <label>Nama Pasien</label>
            <select name="id_pasien" class="<?= isset($errors['id_pasien']) ? 'input-error' : '' ?>">
                <option value="">-- Pilih Pasien --</option>
                <?php
                mysqli_data_seek($pasien, 0); // reset pointer
                while($p = mysqli_fetch_assoc($pasien)) { ?>
                    <option value="<?= $p['id_pasien'] ?>" <?= ($p['id_pasien']==$id_pasien)?'selected':'' ?>>
                        <?= $p['nama_pasien'] ?>
                    </option>
                <?php } ?>
            </select>
            <?php if(isset($errors['id_pasien'])): ?>
                <div class="text-error"><?= $errors['id_pasien'] ?></div>
            <?php endif; ?>

            <!-- Nama Obat -->
            <label>Nama Obat</label>
            <select name="id_obat" class="<?= isset($errors['id_obat']) ? 'input-error' : '' ?>">
                <option value="">-- Pilih Obat --</option>
                <?php
                mysqli_data_seek($obat, 0); // reset pointer
                while($o = mysqli_fetch_assoc($obat)) { ?>
                    <option value="<?= $o['id_obat'] ?>" <?= ($o['id_obat']==$id_obat)?'selected':'' ?>>
                        <?= $o['nama_obat'] ?>
                    </option>
                <?php } ?>
            </select>
            <?php if(isset($errors['id_obat'])): ?>
                <div class="text-error"><?= $errors['id_obat'] ?></div>
            <?php endif; ?>

            <!-- Keluhan -->
            <label>Keluhan</label>
            <textarea name="keluhan" rows="3" class="<?= isset($errors['keluhan']) ? 'input-error' : '' ?>"><?= $keluhan ?></textarea>
            <?php if(isset($errors['keluhan'])): ?>
                <div class="text-error"><?= $errors['keluhan'] ?></div>
            <?php endif; ?>

            <!-- Tanggal Resep -->
            <label>Tanggal Resep</label>
            <input type="date" name="tanggal_resep" value="<?= $tgl ?>" class="<?= isset($errors['tgl']) ? 'input-error' : '' ?>">
            <?php if(isset($errors['tgl'])): ?>
                <div class="text-error"><?= $errors['tgl'] ?></div>
            <?php endif; ?>

            <div class="button-group">
                <button type="submit" name="update"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="resep.php" class="batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
