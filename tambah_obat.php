<?php
include 'koneksi.php';

$namaErr = $descErr = $hargaErr = "";
$nama = $deskripsi = $harga = "";
$error = false;

if (isset($_POST['simpan'])) {

    // Validasi Nama Obat
    if (empty($_POST['nama_obat'])) {
        $namaErr = "Nama obat tidak boleh kosong!";
        $error = true;
    } else {
        $nama = $_POST['nama_obat'];
    }

    // Validasi Deskripsi
    if (empty($_POST['deskripsi'])) {
        $descErr = "Deskripsi tidak boleh kosong!";
        $error = true;
    } else {
        $deskripsi = $_POST['deskripsi'];
    }

    // Validasi Harga
    if (empty($_POST['harga'])) {
        $hargaErr = "Harga tidak boleh kosong!";
        $error = true;
    } elseif (!is_numeric($_POST['harga'])) {
        $hargaErr = "Harga harus berupa angka!";
        $error = true;
    } elseif ($_POST['harga'] <= 0) {
        $hargaErr = "Harga harus lebih dari 0!";
        $error = true;
    } else {
        $harga = $_POST['harga'];
    }

    // Jika tidak ada error → simpan ke database
    if (!$error) {
        $query = "INSERT INTO obat (nama_obat, deskripsi, harga) VALUES ('$nama', '$deskripsi', '$harga')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Data obat berhasil ditambahkan!'); window.location='obat.php';</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat | HealthApps</title>
    <link rel="stylesheet" href="dashboardd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="crud.css">
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
            <li class="menu-item"><a href="obat.php" class="menu-link active"><i class="fa-solid fa-pills"></i> Data Obat</a></li>
            <li class="menu-item"><a href="resep.php" class="menu-link"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
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
            <h1>Tambah Obat</h1>  
            <a href="obat.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="form-wrapper">
            <h2>Form Tambah Data Obat</h2>

            <form method="POST" action="">

               <form method="POST" action="">

    <!-- NAMA OBAT -->
    <label>Nama Obat</label>
    <input type="text" name="nama_obat" value="<?= $nama ?>">
    <?php if ($namaErr): ?>
        <div class="text-error"><?= $namaErr ?></div>
    <?php endif; ?>

    <!-- DESKRIPSI -->
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="3"><?= $deskripsi ?></textarea>
    <?php if ($descErr): ?>
        <div class="text-error"><?= $descErr ?></div>
    <?php endif; ?>

    <!-- HARGA -->
    <label>Harga</label>
    <input type="number" name="harga" value="<?= $harga ?>">
    <?php if ($hargaErr): ?>
        <div class="text-error"><?= $hargaErr ?></div>
    <?php endif; ?>

    <div class="button-group">
        <button type="submit" name="simpan"><i class="fa-solid fa-save"></i> Simpan</button>
        <a href="obat.php" class="batal">Batal</a>
    </div>

</form>

    </div>

<style>
/* Tambahan styling error agar rapi */
.error {
    color: red;
    font-size: 13px;
}
</style>

</body>
</html>
