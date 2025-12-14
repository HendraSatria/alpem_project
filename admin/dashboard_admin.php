<?php
session_start();
require '../config/koneksi.php';

// Proteksi halaman: hanya admin

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}
// Ambil jumlah data
$jml_aduan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aduan"))['total'];
$jml_petugas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM petugas"))['total'];

// Ambil data aduan terbaru 5
$aduan_terbaru = mysqli_query($koneksi, "SELECT * FROM aduan ORDER BY Id_aduan DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="shadow-sm" style="background:#ffffff;">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" width="90" class="me-4">
            <h4 class="m-0 fw-bold text-danger">ALPEM</h4>
        </div>

        <nav>
            <span class="me-3">Halo, <?= $_SESSION['nama_petugas']; ?> (Admin)</span>
            <a href="../auth/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
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
                    <li class="nav-item mb-2"><a href="dashboard_admin.php" class="nav-link text-danger">Dashboard</a></li>
                    <li class="nav-item mb-2"><a href="kelola_petugas.php" class="nav-link text-dark">Kelola Petugas</a></li>
                    <li class="nav-item mb-2"><a href="unduh_laporan.php" class="nav-link text-dark">Unduh Laporan</a></li>
                    <li class="nav-item mb-2"><a href="tanggapan.php" class="nav-link text-dark">Tanggapan Aduan</a></li>
                    <li class="nav-item mb-2"><a href="..\auth\logout.php" class="nav-link text-dark">Logout</a></li>

                </ul>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">

            <!-- DASHBOARD CARDS -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="bg-white shadow-sm rounded p-4 text-center">
                        <h6 class="fw-bold text-muted">Jumlah Aduan</h6>
                        <h2 class="fw-bold text-danger"><?= $jml_aduan; ?></h2>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="bg-white shadow-sm rounded p-4 text-center">
                        <h6 class="fw-bold text-muted">Jumlah Petugas</h6>
                        <h2 class="fw-bold text-danger"><?= $jml_petugas; ?></h2>
                    </div>
                </div>
            </div>

            <!-- TABEL ADUAN TERBARU -->
            <div class="bg-white shadow-sm rounded p-4">
                <h5 class="fw-bold text-danger mb-3">Aduan Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-danger text-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelapor</th>
                                <th>Kontak</th>
                                <th>Lokasi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($aduan_terbaru) > 0) {
                                while ($row = mysqli_fetch_assoc($aduan_terbaru)) {
                                    $status = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Status FROM tanggapan WHERE Id_aduan=".$row['Id_aduan']." ORDER BY Id_tanggapan DESC LIMIT 1"))['Status'] ?? "Menunggu Tanggapan";

                                    $color = "secondary";
                                    if ($status == "diproses") $color = "info";
                                    if ($status == "data tidak lengkap") $color = "warning";
                                    if ($status == "selesai") $color = "success";
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['Nama_pelapor']); ?></td>
                                <td><?= htmlspecialchars($row['Kontak']); ?></td>
                                <td><?= htmlspecialchars($row['Lokasi']); ?></td>
                                <td style="text-align:left;"><?= nl2br(htmlspecialchars($row['Deskripsi'])); ?></td>
                                <td><span class="badge bg-<?= $color; ?>"><?= $status; ?></span></td>
                            </tr>
                            <?php } 
                            } else { ?>
                            <tr>
                                <td colspan="6" class="text-muted py-3">Belum ada aduan masuk.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="py-4 text-center text-white mt-4" style="background:#c8102e;">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
</footer>

</body>
</html>
