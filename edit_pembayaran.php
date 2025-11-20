<?php
include 'koneksi.php';

// Ambil ID pembayaran dari URL
if (!isset($_GET['id'])) {
    echo "<script>alert('ID pembayaran tidak ditemukan!'); window.location='pembayaran.php';</script>";
    exit;
}

$id = $_GET['id'];
$data_query = mysqli_query($koneksi, "SELECT * FROM payment WHERE id_payment='$id'");
$data = mysqli_fetch_assoc($data_query);

// Ambil data resep untuk dropdown pasien
$resep = mysqli_query($koneksi, "
    SELECT resep.id_resep, pasien.nama_pasien 
    FROM resep 
    JOIN pasien ON resep.id_pasien = pasien.id_pasien
");

// Variabel input & error
$errors = [];
$id_resep = $data['id_resep'];
$total_harga = $data['total_harga'];
$metode_pembayaran = $data['metode_pembayaran'];
$tanggal_pembayaran = $data['tanggal_pembayaran'];
$status = $data['status'];

if (isset($_POST['update'])) {
    $id_resep = $_POST['id_resep'];
    $total_harga = $_POST['total_harga'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $status = $_POST['status'];

    // ===== VALIDASI =====
    if ($id_resep == "") {
        $errors['id_resep'] = "Silakan pilih resep/pasien";
    }
    if ($total_harga == "") {
        $errors['total_harga'] = "Total harga wajib diisi";
    } elseif ($total_harga <= 0) {
        $errors['total_harga'] = "Total harga harus lebih dari 0";
    }
    if ($metode_pembayaran == "") {
        $errors['metode_pembayaran'] = "Silakan pilih metode pembayaran";
    }
    if ($tanggal_pembayaran == "") {
        $errors['tanggal_pembayaran'] = "Tanggal pembayaran wajib diisi";
    }
    if ($status == "") {
        $errors['status'] = "Silakan pilih status pembayaran";
    }

    // Jika tidak ada error → update
    if (empty($errors)) {
        $update = mysqli_query($koneksi, "
            UPDATE payment SET 
                id_resep='$id_resep',
                total_harga='$total_harga',
                metode_pembayaran='$metode_pembayaran',
                tanggal_pembayaran='$tanggal_pembayaran',
                status='$status'
            WHERE id_payment='$id'
        ");

        if ($update) {
            echo "<script>alert('✅ Data pembayaran berhasil diperbarui!'); window.location='pembayaran.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Gagal memperbarui data!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pembayaran | HealthApps</title>
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
        <li class="menu-item"><a href="resep.php" class="menu-link"><i class="fa-solid fa-file-prescription"></i> Resep Obat</a></li>
        <li class="menu-item"><a href="pembayaran.php" class="menu-link active"><i class="fa-solid fa-credit-card"></i> Pembayaran</a></li>
    </ul>
    <div class="logout-section">
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="header">
        <h1>Edit Pembayaran</h1>
        <a href="pembayaran.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="form-wrapper">
        <h2>Form Edit Pembayaran</h2>
        <form method="POST">

            <!-- Resep/Pasien -->
            <label>Resep (Pasien)</label>
            <select name="id_resep" class="<?= isset($errors['id_resep'])?'input-error':'' ?>">
                <option value="">-- Pilih Resep --</option>
                <?php mysqli_data_seek($resep,0); while($r = mysqli_fetch_assoc($resep)): ?>
                    <option value="<?= $r['id_resep'] ?>" <?= ($r['id_resep']==$id_resep)?'selected':'' ?>>
                        #<?= $r['id_resep'] ?> - <?= $r['nama_pasien'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <?php if(isset($errors['id_resep'])): ?>
                <div class="text-error"><?= $errors['id_resep'] ?></div>
            <?php endif; ?>

            <!-- Total Harga -->
            <label>Total Harga</label>
            <input type="number" name="total_harga" value="<?= $total_harga ?>" step="0.01" 
                   class="<?= isset($errors['total_harga'])?'input-error':'' ?>">
            <?php if(isset($errors['total_harga'])): ?>
                <div class="text-error"><?= $errors['total_harga'] ?></div>
            <?php endif; ?>

            <!-- Metode Pembayaran -->
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="<?= isset($errors['metode_pembayaran'])?'input-error':'' ?>">
                <option value="">-- Pilih Metode --</option>
                <option value="Tunai" <?= ($metode_pembayaran=='Tunai')?'selected':'' ?>>Tunai</option>
                <option value="Transfer" <?= ($metode_pembayaran=='Transfer')?'selected':'' ?>>Transfer</option>
                <option value="QRIS" <?= ($metode_pembayaran=='QRIS')?'selected':'' ?>>QRIS</option>
            </select>
            <?php if(isset($errors['metode_pembayaran'])): ?>
                <div class="text-error"><?= $errors['metode_pembayaran'] ?></div>
            <?php endif; ?>

            <!-- Tanggal Pembayaran -->
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" value="<?= $tanggal_pembayaran ?>" 
                   class="<?= isset($errors['tanggal_pembayaran'])?'input-error':'' ?>">
            <?php if(isset($errors['tanggal_pembayaran'])): ?>
                <div class="text-error"><?= $errors['tanggal_pembayaran'] ?></div>
            <?php endif; ?>

            <!-- Status -->
            <label>Status Pembayaran</label>
            <select name="status" class="<?= isset($errors['status'])?'input-error':'' ?>">
                <option value="">-- Pilih Status --</option>
                <option value="belum bayar" <?= ($status=='belum bayar')?'selected':'' ?>>Belum Bayar</option>
                <option value="sudah bayar" <?= ($status=='sudah bayar')?'selected':'' ?>>Sudah Bayar</option>
            </select>
            <?php if(isset($errors['status'])): ?>
                <div class="text-error"><?= $errors['status'] ?></div>
            <?php endif; ?>

            <div class="button-group">
                <button type="submit" name="update"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="pembayaran.php" class="batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
