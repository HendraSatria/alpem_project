<?php
require '../config/koneksi.php';

$data = null;

if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST['keyword']);

    $query = "
        SELECT a.Id_aduan, a.Nama_pelapor, a.Kontak,
               t.Status, t.Tanggal_tanggapan, t.Isi_tanggapan,
               p.Nama_Petugas
        FROM aduan a
        LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
        LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
        WHERE a.Id_aduan = '$keyword'
           OR a.Kontak = '$keyword'
        ORDER BY t.Id_tanggapan DESC
        LIMIT 1
    ";

    $data = mysqli_query($koneksi, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Status Aduan - ALPEM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="shadow-sm bg-white">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" width="80" class="me-3">
            <h4 class="fw-bold text-danger m-0">ALPEM</h4>
        </div>
        <nav>
            <a href="index.php" class="nav-link d-inline mx-2">Beranda</a>
            <a href="data_aduan.php" class="nav-link d-inline mx-2">Data Aduan</a>
            <a href="cek_status.php" class="nav-link d-inline mx-2 fw-semibold text-danger">Cek Status</a>
        </nav>
    </div>
</header>

<!-- ================= HERO ================= -->
<section class="hero fade-in" style="padding:60px 0;">
    <div class="container text-center text-white">
        <h2 class="fw-bold">Cek Status Aduan</h2>
        <p class="lead">Masukkan Nomor Aduan atau Nomor Kontak Anda</p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<div class="container fade-in" style="margin-top:-120px; margin-bottom:70px;">
    <div class="bg-white shadow-lg rounded p-4 form-card">

        <!-- FORM -->
        <form method="POST" class="row g-3 mb-4">
            <div class="col-md-9">
                <input type="text" name="keyword" class="form-control"
                       placeholder="Masukkan Nomor Aduan atau Nomor Kontak" required>
            </div>
            <div class="col-md-3 d-grid">
                <button name="cari" class="btn btn-danger">Cek Status</button>
            </div>
        </form>

        <!-- HASIL -->
        <?php if ($data && mysqli_num_rows($data) > 0) {
            $r = mysqli_fetch_assoc($data);

            $color = 'secondary';
            if ($r['Status'] == 'diproses') $color = 'info';
            if ($r['Status'] == 'data tidak lengkap') $color = 'warning';
            if ($r['Status'] == 'selesai') $color = 'success';
        ?>

        <div class="border rounded p-3">
            <h6 class="fw-bold text-danger mb-3">Hasil Pengecekan</h6>

            <table class="table table-borderless">
                <tr>
                    <th width="30%">Nomor Aduan</th>
                    <td>: <?= $r['Id_aduan']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        : <span class="badge bg-<?= $color; ?> px-3"><?= $r['Status'] ?? 'Baru'; ?></span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Tanggapan</th>
                    <td>: <?= $r['Tanggal_tanggapan'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td>: <?= $r['Nama_Petugas'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <th>Tanggapan</th>
                    <td>: <?= nl2br(htmlspecialchars($r['Isi_tanggapan'] ?? 'Belum ada tanggapan')); ?></td>
                </tr>
            </table>
        </div>

        <?php } elseif (isset($_POST['cari'])) { ?>

            <div class="alert alert-warning mt-3">
                Data aduan tidak ditemukan. Pastikan nomor aduan atau kontak benar.
            </div>

        <?php } ?>

    </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="text-center py-4 text-white" style="background:#c8102e;">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM</p>
</footer>

</body>
</html>
