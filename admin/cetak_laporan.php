<?php
require '../config/koneksi.php';

// Filter
$status = $_GET['status'] ?? '';
$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

// Query dasar
$query = "
    SELECT a.*, t.Status, t.Tanggal_tanggapan, p.Nama_Petugas
    FROM aduan a
    LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
    LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
    WHERE 1
";

// Filter status
if ($status != '') {
    $query .= " AND t.Status = '$status'";
}

// Filter tanggal
if ($tgl_awal != '' && $tgl_akhir != '') {
    $query .= " AND DATE(t.Tanggal_tanggapan) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query .= " ORDER BY a.Id_aduan DESC";

$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; font-size: 12px; color: #1f2937; }
        h2 { text-align:center; margin-bottom:10px; text-transform: uppercase; letter-spacing: 1px; }
        p.subtitle { text-align: center; margin-bottom: 20px; color: #6b7280; font-size: 10px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #e5e7eb; padding:8px 10px; text-align: left; vertical-align: top; }
        th { background:#f9fafb; font-weight: 600; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .badge { display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: 600; border-radius: 4px; text-transform: uppercase; }
        .status-baru { background-color: #e5e7eb; color: #374151; }
        .status-diproses { background-color: #dbeafe; color: #1e40af; }
        .status-selesai { background-color: #dcfce7; color: #166534; }
        .status-incomplete { background-color: #fef9c3; color: #854d0e; }
        
        @media print {
            button { display:none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>

<body onload="window.print()">

<h2>Laporan Pengaduan Masyarakat (ALPEM)</h2>
<p class="subtitle">
    Dicetak pada: <?= date("d F Y H:i"); ?> <br>
    <?= ($status || ($tgl_awal && $tgl_akhir)) ? 'Filter: ' . ($status ? "Status: ".ucfirst($status) : "") . (($status && $tgl_awal) ? ", " : "") . (($tgl_awal && $tgl_akhir) ? "Tanggal: $tgl_awal s/d $tgl_akhir" : "") : "Semua Data"; ?>
</p>

<table>
<thead>
<tr>
    <th width="5%">No</th>
    <th width="15%">Nama Pelapor</th>
    <th width="15%">Lokasi</th>
    <th width="30%">Deskripsi</th>
    <th width="10%">Status</th>
    <th width="15%">Petugas</th>
    <th width="10%">Tanggal</th>
</tr>
</thead>
<tbody>
<?php 
$no=1; 
if(mysqli_num_rows($data) > 0) {
    while($r=mysqli_fetch_assoc($data)){ 
        $s = $r['Status'] ?? 'baru';
        $class = 'status-baru';
        if($s == 'diproses') $class = 'status-diproses';
        if($s == 'selesai') $class = 'status-selesai';
        if($s == 'data tidak lengkap') $class = 'status-incomplete';
?>
<tr>
    <td style="text-align: center;"><?= $no++; ?></td>
    <td><?= htmlspecialchars($r['Nama_pelapor']); ?></td>
    <td><?= htmlspecialchars($r['Lokasi']); ?></td>
    <td><?= nl2br(htmlspecialchars($r['Deskripsi'])); ?></td>
    <td><span class="badge <?= $class; ?>"><?= ucfirst($s); ?></span></td>
    <td><?= htmlspecialchars($r['Nama_Petugas'] ?? '-'); ?></td>
    <td><?= $r['Tanggal_tanggapan'] ? date('d/m/Y', strtotime($r['Tanggal_tanggapan'])) : '-'; ?></td>
</tr>
<?php } 
} else { ?>
<tr>
    <td colspan="7" style="text-align: center;">Tidak ada data ditemukan.</td>
</tr>
<?php } ?>
</tbody>
</table>

</body>
</html>
