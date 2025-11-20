<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien='$id'");
$data = mysqli_fetch_array($query);

$errors = []; // menampung error
$nama = $data['nama_pasien'];
$umur = $data['umur'];
$jk = $data['jenis_kelamin'];
$alamat = $data['alamat'];
$tgl = $data['tanggal_berobat'];

if (isset($_POST['update'])) {

    // Ambil input
    $nama = trim($_POST['nama_pasien']);
    $umur = trim($_POST['umur']);
    $jk   = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $tgl = trim($_POST['tanggal_berobat']);

    // ===== VALIDASI ======
    if ($nama == "") {
        $errors['nama'] = "Nama tidak boleh kosong";
    }
    if ($umur == "") {
        $errors['umur'] = "Umur tidak boleh kosong";
    } elseif (!is_numeric($umur)) {
        $errors['umur'] = "Umur harus angka";
    } elseif ($umur <= 0) {
        $errors['umur'] = "Umur tidak boleh 0";
    }

    if ($jk == "") {
        $errors['jk'] = "Jenis kelamin wajib dipilih";
    }

    if ($alamat == "") {
        $errors['alamat'] = "Alamat tidak boleh kosong";
    }

    if ($tgl == "") {
        $errors['tgl'] = "Tanggal berobat tidak boleh kosong";
    }

    // Jika tidak ada error → update
    if (empty($errors)) {
        $update = mysqli_query($koneksi, "UPDATE pasien SET 
            nama_pasien='$nama',
            umur='$umur',
            jenis_kelamin='$jk',
            alamat='$alamat',
            tanggal_berobat='$tgl'
            WHERE id_pasien='$id'
        ");

        if ($update) {
            echo "<script>alert('✅ Data pasien berhasil diperbarui'); window.location='pasien.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal memperbarui data');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien | HealthApps</title>
    <link rel="stylesheet" href="dashboardd.css">
    <link rel="stylesheet" href="crud.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- Sidebar -->
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
            <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>


    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="header">
            <h1>Edit Data Pasien</h1>
            <a href="pasien.php" class="batal"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="form-wrapper">
            <form method="POST">

                <!-- NAMA -->
                <label>Nama Pasien</label>
                <input 
                    type="text" 
                    name="nama_pasien" 
                    value="<?= $nama ?>" 
                    class="<?= isset($errors['nama']) ? 'input-error' : '' ?>"
                >
                <?php if (isset($errors['nama'])): ?>
                    <div class="error-text"><?= $errors['nama'] ?></div>
                <?php endif; ?>


                <!-- UMUR -->
                <label>Umur</label>
                <input 
                    type="number" 
                    name="umur" 
                    value="<?= $umur ?>" 
                    class="<?= isset($errors['umur']) ? 'input-error' : '' ?>"
                >
                <?php if (isset($errors['umur'])): ?>
                    <div class="error-text"><?= $errors['umur'] ?></div>
                <?php endif; ?>


                <!-- JENIS KELAMIN -->
                <label>Jenis Kelamin</label>
                <select 
                    name="jenis_kelamin"
                    class="<?= isset($errors['jk']) ? 'input-error' : '' ?>"
                >
                    <option value="">-- Pilih --</option>
                    <option value="laki-laki" <?= $jk=='laki-laki'?'selected':'' ?>>Laki-laki</option>
                    <option value="perempuan" <?= $jk=='perempuan'?'selected':'' ?>>Perempuan</option>
                </select>
                <?php if (isset($errors['jk'])): ?>
                    <div class="error-text"><?= $errors['jk'] ?></div>
                <?php endif; ?>


                <!-- ALAMAT -->
                <label>Alamat</label>
                <input 
                    type="text" 
                    name="alamat" 
                    value="<?= $alamat ?>" 
                    class="<?= isset($errors['alamat']) ? 'input-error' : '' ?>"
                >
                <?php if (isset($errors['alamat'])): ?>
                    <div class="error-text"><?= $errors['alamat'] ?></div>
                <?php endif; ?>


                <!-- TANGGAL -->
                <label>Tanggal Berobat</label>
                <input 
                    type="date" 
                    name="tanggal_berobat" 
                    value="<?= $tgl ?>" 
                    class="<?= isset($errors['tgl']) ? 'input-error' : '' ?>"
                >
                <?php if (isset($errors['tgl'])): ?>
                    <div class="error-text"><?= $errors['tgl'] ?></div>
                <?php endif; ?>


                <div class="btn-area">
                    <button type="submit" name="update"><i class="fa-solid fa-save"></i> Simpan</button>
                    <a href="pasien.php" class="batal">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
