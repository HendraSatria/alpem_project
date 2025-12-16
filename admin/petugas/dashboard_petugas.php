<?php
session_start();
require '../../config/koneksi.php';


// Proteksi halaman
if (!isset($_SESSION['id_petugas'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$nama = $_SESSION['nama_petugas'];

// Hitung statistik
$total    = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM aduan"))[0];
$diproses = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='diproses'"))[0];
$selesai  = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='selesai'"))[0];
$tdl      = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='data tidak lengkap'"))[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas - ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body {
            background: #f6f6f6;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #c8102e;
            position: fixed;
            padding-top: 30px;
            color: white;
        }
        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            font-weight: 500;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            transition: 0.3s;
        }
        .content {
            margin-left: 260px;
        }
        .card-stat {
            border-left: 6px solid #c8102e;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<!-- ========================================================= -->
<!-- SIDEBAR -->
<!-- ========================================================= -->
<div class="sidebar">
    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" width="70">
        <h5 class="mt-2">ALPEM</h5>
    </div>

    <a href="dashboard_petugas.php" class="fw-bold"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="tanggapan.php"><i class="bi bi-chat-left-text me-2"></i> Verifikasi Aduan</a>
    <a href="../../auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
</div>


<!-- ========================================================= -->
<!-- TOP NAVBAR -->
<!-- ========================================================= -->
<div class="content">
    <nav class="navbar navbar-light bg-white shadow-sm px-3">
        <span class="navbar-brand fw-bold">Dashboard Petugas</span>
        <span>Halo, <strong><?= $nama ?></strong> 👋</span>
    </nav>


    <!-- ========================================================= -->
    <!-- STATISTIK -->
    <!-- ========================================================= -->
    <div class="container mt-4">

        <div class="row g-4">

            <div class="col-md-3">
                <div class="card p-3 card-stat shadow-sm">
                    <h6 class="fw-semibold">Total Aduan</h6>
                    <h3 class="fw-bold text-danger"><?= $total ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 card-stat shadow-sm">
                    <h6 class="fw-semibold">Diproses</h6>
                    <h3 class="fw-bold text-info"><?= $diproses ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 card-stat shadow-sm">
                    <h6 class="fw-semibold">Selesai</h6>
                    <h3 class="fw-bold text-success"><?= $selesai ?></h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 card-stat shadow-sm">
                    <h6 class="fw-semibold">Data Tidak Lengkap</h6>
                    <h3 class="fw-bold text-warning"><?= $tdl ?></h3>
                </div>
            </div>

        </div>


        <!-- ========================================================= -->
        <!-- TABEL ADUAN TERBARU -->
        <!-- ========================================================= -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-danger text-white fw-bold">
                Aduan Terbaru
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0 text-center align-middle">
                    <thead class="table-light">
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
                        $q = mysqli_query($koneksi, "SELECT a.*, 
                                (SELECT Status FROM tanggapan WHERE Id_aduan = a.Id_aduan ORDER BY Id_tanggapan DESC LIMIT 1) AS status_aduan
                            FROM aduan a 
                            ORDER BY Id_aduan DESC LIMIT 8");

                        $no = 1;
                        while ($d = mysqli_fetch_assoc($q)) {
                            $s = $d['status_aduan'] ?? "Belum Ditanggapi";

                            $color = "secondary";
                            if ($s == 'diproses') $color = "info";
                            if ($s == 'selesai') $color = "success";
                            if ($s == 'data tidak lengkap') $color = "warning";
                        ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['Nama_pelapor'] ?></td>
                            <td><?= $d['Kontak'] ?></td>
                            <td><?= $d['Lokasi'] ?></td>
                            <td style="text-align:left;"><?= $d['Deskripsi'] ?></td>
                            <td><span class="badge bg-<?= $color ?>"><?= $s ?></span></td>
                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


</body>

</html>


