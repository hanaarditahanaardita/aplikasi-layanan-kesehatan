<?php
session_start();
include "koneksi.php";  

/* =====================================================
   AMBIL DATA PASIEN OKTOBER & NOVEMBER
===================================================== */
$query = mysqli_query($koneksi, "
    SELECT 
        MONTH(tanggal_berobat) AS bulan,
        COUNT(*) AS total
    FROM pasien
    WHERE MONTH(tanggal_berobat) IN (10, 11)
    GROUP BY MONTH(tanggal_berobat)
");

$oktober = 0;
$november = 0;

while ($row = mysqli_fetch_assoc($query)) {
    if ($row['bulan'] == 10) $oktober = $row['total'];
    if ($row['bulan'] == 11) $november = $row['total'];
}

$data_js = json_encode([
    0,0,0,0,0,0,0,0,0,
    $oktober,
    $november,
    0
]);

/* =====================================================
   AMBIL DATA PEMBAYARAN OKTOBER & NOVEMBER
===================================================== */
$queryPay = mysqli_query($koneksi, "
    SELECT 
        MONTH(tanggal_pembayaran) AS bulan,
        COUNT(*) AS total_transaksi
    FROM payment
    WHERE MONTH(tanggal_pembayaran) IN (10, 11)
    GROUP BY MONTH(tanggal_pembayaran)
");

$pay_oktober = 0;
$pay_november = 0;

while ($p = mysqli_fetch_assoc($queryPay)) {
    if ($p['bulan'] == 10) $pay_oktober = $p['total_transaksi'];
    if ($p['bulan'] == 11) $pay_november = $p['total_transaksi'];
}

$data_payment_js = json_encode([
    0,0,0,0,0,0,0,0,0,
    $pay_oktober,
    $pay_november,
    0
]);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HealthApps</title>

    <link rel="stylesheet" href="dashboardd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">HealthApps</div>
        </div>

        <ul class="menu">
            <li class="menu-item">
                <a href="dashboard.php" class="menu-link active">
                    <span class="menu-icon"><i class="fa-solid fa-house"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="menu-item"><a href="pasien.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-user"></i></span><span class="menu-text">Data Pasien</span></a></li>
            <li class="menu-item"><a href="obat.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-pills"></i></span><span class="menu-text">Data Obat</span></a></li>
            <li class="menu-item"><a href="resep.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-file-prescription"></i></span><span class="menu-text">Resep Obat</span></a></li>
            <li class="menu-item"><a href="pembayaran.php" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-credit-card"></i></span><span class="menu-text">Pembayaran</span></a></li>
        </ul>

        <div class="logout-section">
            <a href="logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Main -->
    <div class="main-content">

        <div class="header">
            <h1>Selamat Datang di Dashboard HealthApps</h1>
        </div>

        <!-- Cards -->
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-users card-icon"></i>
                <div class="card-info">
                    <p>Total Pasien</p>
                    <h2>120</h2>
                </div>
            </div>

            <div class="card">
                <i class="fa-solid fa-pills card-icon"></i>
                <div class="card-info">
                    <p>Total Obat</p>
                    <h2>45</h2>
                </div>
            </div>

            <div class="card">
                <i class="fa-solid fa-file-prescription card-icon"></i>
                <div class="card-info">
                    <p>Resep Diterbitkan</p>
                    <h2>85</h2>
                </div>
            </div>

            <div class="card">
                <i class="fa-solid fa-money-bill-wave card-icon"></i>
                <div class="card-info">
                    <p>Total Pembayaran</p>
                    <h2>Rp 12.500.000</h2>
                </div>
            </div>
        </div>

        <!-- ================= CHARTS ================= -->
        <div class="charts">

            <!-- CHART PASIEN -->
            <div class="chart-container pasien">
                <h3>Statistik Pasien</h3>
                <canvas id="lineChart"></canvas>
            </div>

            <!-- CHART PEMBAYARAN -->
            <div class="chart-container pembayaran">
                <h3>Statistik Pembayaran</h3>
                <canvas id="paymentChart"></canvas>
            </div>

            <!-- PIE CHART DISTRIBUSI -->
            <div class="chart-container distribusi">
                <h3>Distribusi Data</h3>
                <canvas id="pieChart"></canvas>
            </div>

        </div>

    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <script>
        const pasienData = <?= $data_js ?>;
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: pasienData,
                    borderColor: '#22c55e',
                    borderWidth: 3,
                    tension: 0.35,
                    pointRadius: 6,
                    pointBackgroundColor: '#16a34a',
                    fill: false
                }]
            }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Pasien', 'Obat', 'Resep'],
                datasets: [{
                    data: [120, 45, 85],
                    backgroundColor: ['#22c55e', '#4ade80', '#86efac'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            }
        });

        const paymentData = <?= $data_payment_js ?>;
        new Chart(document.getElementById('paymentChart'), {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Jumlah Pembayaran',
                    data: paymentData,
                    borderColor: '#22c55e',
                    borderWidth: 3,
                    tension: 0.35,
                    pointRadius: 6,
                    pointBackgroundColor: '#16a34a',
                    fill: false
                }]
            }
        });
    </script>

</body>
</html>