<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat='$id'");
$data = mysqli_fetch_array($query);

$errors = []; // array untuk menampung error
$nama = $data['nama_obat'];
$deskripsi = $data['deskripsi'];
$harga = $data['harga'];

if (isset($_POST['update'])) {

    // Ambil input
    $nama = trim($_POST['nama_obat']);
    $deskripsi = trim($_POST['deskripsi']);
    $harga = trim($_POST['harga']);

    // ===== VALIDASI =====
    if ($nama == "") {
        $errors['nama'] = "Nama obat tidak boleh kosong";
    }
    if ($deskripsi == "") {
        $errors['deskripsi'] = "Deskripsi obat tidak boleh kosong";
    }
    if ($harga == "") {
        $errors['harga'] = "Harga obat tidak boleh kosong";
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = "Harga harus berupa angka";
    } elseif ($harga <= 0) {
        $errors['harga'] = "Harga harus lebih dari 0";
    }

    // Jika tidak ada error → update
    if (empty($errors)) {
        $update = mysqli_query($koneksi, "UPDATE obat SET 
            nama_obat='$nama',
            deskripsi='$deskripsi',
            harga='$harga'
            WHERE id_obat='$id'
        ");

        if ($update) {
            echo "<script>alert('✅ Data obat berhasil diperbarui'); window.location='obat.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat | HealthApps</title>
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
        <li class="menu-item"><a href="obat.php" class="menu-link active"><i class="fa-solid fa-pills"></i> Data Obat</a></li>
        <li class="menu-item"><a href="resep.php" class="menu-link"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
        <li class="menu-item"><a href="pembayaran.php" class="menu-link"><i class="fa-solid fa-credit-card"></i> Pembayaran</a></li>
    </ul>
    <div class="logout-section">
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="header">
        <h1>Edit Data Obat</h1>
        <a href="obat.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="form-wrapper">
        <form method="POST">
            <input type="hidden" name="id_obat" value="<?= $id ?>">

            <!-- NAMA OBAT -->
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" value="<?= $nama ?>" class="<?= isset($errors['nama']) ? 'input-error' : '' ?>">
            <?php if(isset($errors['nama'])): ?>
                <div class="text-error"><?= $errors['nama'] ?></div>
            <?php endif; ?>

            <!-- DESKRIPSI -->
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" value="<?= $deskripsi ?>" class="<?= isset($errors['deskripsi']) ? 'input-error' : '' ?>">
            <?php if(isset($errors['deskripsi'])): ?>
                <div class="text-error"><?= $errors['deskripsi'] ?></div>
            <?php endif; ?>

            <!-- HARGA -->
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $harga ?>" class="<?= isset($errors['harga']) ? 'input-error' : '' ?>">
            <?php if(isset($errors['harga'])): ?>
                <div class="text-error"><?= $errors['harga'] ?></div>
            <?php endif; ?>

            <div class="btn-area">
                <button type="submit" name="update"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="obat.php" class="batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
