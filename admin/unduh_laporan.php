<?php
session_start();
require '../config/koneksi.php';

// Proteksi halaman: hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}

// Filter
$status = $_GET['status'] ?? '';
$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

// Query dasar
$query = "
    SELECT a.*, 
           t.Status, 
           p.Nama_Petugas
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
    <title>Unduh Laporan - Admin ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="shadow-sm bg-white">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" width="90" class="me-4">
            <h4 class="fw-bold text-danger m-0">ALPEM</h4>
        </div>
        <nav>
            <span class="me-3">Halo, <?= $_SESSION['nama_petugas']; ?> (Admin)</span>
            <a href="../auth/logout.php" class="btn btn-outline-danger">Logout</a>
        </nav>
    </div>
</header>

<!-- ================= MAIN ================= -->
<div class="container-fluid mt-4">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 mb-4">
            <div class="bg-white shadow-sm rounded p-3">
                <h5 class="fw-bold text-danger mb-3">Menu Admin</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="dashboard_admin.php" class="nav-link text-dark">Dashboard</a></li>
                    <li class="nav-item mb-2"><a href="kelola_petugas.php" class="nav-link text-dark">Kelola Petugas</a></li>
                    
                    <li class="nav-item mb-2"><a href="unduh_laporan.php" class="nav-link text-danger">Unduh Laporan</a></li>
                    <li class="nav-item mb-2"><a href="..\auth\logout.php" class="nav-link text-dark">Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">
            <div class="bg-white shadow-sm rounded p-4">

                <h5 class="fw-bold text-danger mb-3">Unduh Laporan Aduan</h5>

                <!-- FILTER -->
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="baru" <?= $status=='baru'?'selected':''; ?>>Baru</option>
                            <option value="diproses" <?= $status=='diproses'?'selected':''; ?>>Diproses</option>
                            <option value="data tidak lengkap" <?= $status=='data tidak lengkap'?'selected':''; ?>>Data Tidak Lengkap</option>
                            <option value="selesai" <?= $status=='selesai'?'selected':''; ?>>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-danger w-100">Tampilkan</button>
                    </div>
                </form>

                <!-- TOMBOL UNDUH -->
                <div class="mb-3 text-end">
                    <a href="cetak_laporan.php?status=<?= $status; ?>&tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>"
                       class="btn btn-outline-danger">
                        Unduh PDF
                    </a>
                </div>

                <!-- TABEL LAPORAN -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-danger">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelapor</th>
                                <th>Lokasi</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th>Tanggal Tanggapan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($data) > 0) {
                            while ($row = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['Nama_pelapor']); ?></td>
                                <td><?= htmlspecialchars($row['Lokasi']); ?></td>
                                <td><?= $row['Nama_Petugas'] ?? '<span class="text-muted">-</span>'; ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $row['Status'] ?? 'baru'; ?>
                                    </span>
                                </td>
                                <td><?= $row['Tanggal_tanggapan'] ?? '-'; ?></td>
                            </tr>
                        <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-muted py-3">Data tidak ditemukan.</td>
                            </tr>
                        <?php } ?>
                        </tbody>
