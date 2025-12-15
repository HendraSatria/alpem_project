<?php
require '../config/koneksi.php';

$data = mysqli_query($koneksi,"
    SELECT a.*, t.Status, t.Tanggal_tanggapan, p.Nama_Petugas
    FROM aduan a
    LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
    LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>

    <style>
        body { font-family: Arial; }
        h2 { text-align:center; margin-bottom:20px; }
        table { width:100%; border-collapse: collapse; font-size:12px; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#f2f2f2; }
        @media print {
            button { display:none; }
        }
    </style>
</head>

<body onload="window.print()">

<h2>LAPORAN PENGADUAN MASYARAKAT (ALPEM)</h2>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Nama Pelapor</th>
    <th>Lokasi</th>
    <th>Deskripsi</th>
    <th>Status</th>
    <th>Petugas</th>
    <th>Tanggal</th>
</tr>
</thead>
<tbody>
<?php $no=1; while($r=mysqli_fetch_assoc($data)){ ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $r['Nama_pelapor']; ?></td>
    <td><?= $r['Lokasi']; ?></td>
    <td><?= $r['Deskripsi']; ?></td>
    <td><?= $r['Status'] ?? 'Baru'; ?></td>
    <td><?= $r['Nama_Petugas'] ?? '-'; ?></td>
    <td><?= $r['Tanggal_tanggapan'] ?? '-'; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

</body>
</html>
