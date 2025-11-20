<?php
include 'koneksi.php';

// Ambil data resep untuk dropdown
$resep = mysqli_query($koneksi, "
    SELECT resep.id_resep, pasien.nama_pasien 
    FROM resep 
    JOIN pasien ON resep.id_pasien = pasien.id_pasien
");

// Variabel error
$resepErr = $hargaErr = $tglErr = $metodeErr = $statusErr = "";

// Variabel input
$id_resep = $total_harga = $tanggal_pembayaran = $metode_pembayaran = $status = "";

if (isset($_POST['simpan'])) {

    $error = false;

    // VALIDASI ID RESEP
    if (empty($_POST['id_resep'])) {
        $resepErr = "Silakan pilih resep!";
        $error = true;
    } else {
        $id_resep = $_POST['id_resep'];
    }

    // VALIDASI TOTAL HARGA
    if (empty($_POST['total_harga'])) {
        $hargaErr = "Total harga wajib diisi!";
        $error = true;
    } else {
        $total_harga = $_POST['total_harga'];
        if (!is_numeric($total_harga) || $total_harga <= 0) {
            $hargaErr = "Total harga harus lebih dari 0!";
            $error = true;
        }
    }

    // VALIDASI TANGGAL PEMBAYARAN
    if (empty($_POST['tanggal_pembayaran'])) {
        $tglErr = "Tanggal pembayaran wajib diisi!";
        $error = true;
    } else {
        $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
        if ($tanggal_pembayaran > date('Y-m-d')) {
            $tglErr = "Tanggal tidak boleh di masa depan!";
            $error = true;
        }
    }

    // VALIDASI METODE PEMBAYARAN
    if (empty($_POST['metode_pembayaran'])) {
        $metodeErr = "Silakan pilih metode pembayaran!";
        $error = true;
    } else {
        $metode_pembayaran = $_POST['metode_pembayaran'];
    }

    // VALIDASI STATUS
    if (empty($_POST['status'])) {
        $statusErr = "Silakan pilih status pembayaran!";
        $error = true;
    } else {
        $status = $_POST['status'];
    }

    // Jika tidak ada error → Simpan
    if (!$error) {
        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO payment (id_resep, total_harga, tanggal_pembayaran, metode_pembayaran, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        mysqli_stmt_bind_param($stmt, "idsss", $id_resep, $total_harga, $tanggal_pembayaran, $metode_pembayaran, $status);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('✅ Pembayaran berhasil ditambahkan!'); window.location='pembayaran.php';</script>";
            exit;
        } else {
            echo "<script>alert('❌ Gagal menambah pembayaran. Silakan coba lagi!');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Pembayaran | HealthApps</title>
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
        <h1>Tambah Pembayaran</h1>
        <a href="pembayaran.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="form-wrapper">
        <h2>Form Tambah Pembayaran</h2>
        <form method="POST">

            <!-- Resep -->
            <label>Resep (Pasien)</label>
            <select name="id_resep" class="<?= !empty($resepErr) ? 'input-error' : '' ?>">
                <option value="">-- Pilih Resep --</option>
                <?php while($r = mysqli_fetch_assoc($resep)) { ?>
                    <option value="<?= $r['id_resep'] ?>" <?= ($id_resep == $r['id_resep']) ? "selected" : "" ?>>
                        #<?= $r['id_resep'] ?> - <?= $r['nama_pasien'] ?>
                    </option>
                <?php } ?>
            </select>
            <?php if(!empty($resepErr)) echo '<small class="text-error">'.$resepErr.'</small>'; ?>

            <!-- Total Harga -->
            <label>Total Harga (Rp)</label>
            <input type="number" name="total_harga" value="<?= $total_harga ?>" placeholder="Masukkan total pembayaran" class="<?= !empty($hargaErr) ? 'input-error' : '' ?>">
            <?php if(!empty($hargaErr)) echo '<small class="text-error">'.$hargaErr.'</small>'; ?>

            <!-- Tanggal -->
            <label>Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" value="<?= $tanggal_pembayaran ?>" class="<?= !empty($tglErr) ? 'input-error' : '' ?>">
            <?php if(!empty($tglErr)) echo '<small class="text-error">'.$tglErr.'</small>'; ?>

            <!-- Metode pembayaran -->
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="<?= !empty($metodeErr) ? 'input-error' : '' ?>">
                <option value="">-- Pilih Metode --</option>
                <option value="Tunai" <?= ($metode_pembayaran=="Tunai")?"selected":"" ?>>Tunai</option>
                <option value="Transfer" <?= ($metode_pembayaran=="Transfer")?"selected":"" ?>>Transfer</option>
                <option value="QRIS" <?= ($metode_pembayaran=="QRIS")?"selected":"" ?>>QRIS</option>
            </select>
            <?php if(!empty($metodeErr)) echo '<small class="text-error">'.$metodeErr.'</small>'; ?>

            <!-- Status -->
            <label>Status Pembayaran</label>
            <select name="status" class="<?= !empty($statusErr) ? 'input-error' : '' ?>">
                <option value="">-- Pilih Status --</option>
                <option value="sudah bayar" <?= ($status=="sudah bayar")?"selected":"" ?>>Sudah Bayar</option>
                <option value="belum bayar" <?= ($status=="belum bayar")?"selected":"" ?>>Belum Bayar</option>
            </select>
            <?php if(!empty($statusErr)) echo '<small class="text-error">'.$statusErr.'</small>'; ?>

            <div class="button-group">
                <button type="submit" name="simpan"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="pembayaran.php" class="batal">Batal</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
