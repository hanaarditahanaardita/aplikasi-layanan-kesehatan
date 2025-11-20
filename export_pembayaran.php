<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_pembayaran.xls");

$query = mysqli_query($koneksi, "
    SELECT payment.*, pasien.nama_pasien, resep.id_resep
    FROM payment
    JOIN resep ON payment.id_resep = resep.id_resep
    JOIN pasien ON resep.id_pasien = pasien.id_pasien
");
?>

<table border="1">
    <tr>
        <th>ID Pembayaran</th>
        <th>Nama Pasien</th>
        <th>ID Resep</th>
        <th>Total Harga</th>
        <th>Tanggal Pembayaran</th>
        <th>Metode Pembayaran</th>
        <th>Status</th>
    </tr>

    <?php while ($d = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $d['id_payment']; ?></td>
        <td><?= $d['nama_pasien']; ?></td>
        <td><?= $d['id_resep']; ?></td>
        <td><?= $d['total_harga']; ?></td>
        <td><?= $d['tanggal_pembayaran']; ?></td>
        <td><?= $d['metode_pembayaran']; ?></td>
        <td><?= $d['status']; ?></td>
    </tr>
    <?php } ?>
</table>