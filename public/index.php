<?php require '../config/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ALPEM - Aplikasi Layanan Pengaduan Masyarakat</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<!-- ========================================================= -->
<!-- HEADER -->
<!-- ========================================================= -->
<header class="shadow-sm" style="background: #ffffff;">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" width="90" class="me-4">
            <h4 class="m-0 fw-bold text-danger">ALPEM</h4>
        </div>

        <nav>
            <a href="index.php" class="nav-link d-inline mx-2 fw-semibold text-danger">Beranda</a>
            <a href="data_aduan.php" class="nav-link d-inline mx-2">Data Aduan</a>
            <a href="tentang.php" class="nav-link d-inline mx-2">Tentang</a>
            <a href="../auth/login.php" class="btn btn-outline-danger ms-3">Masuk Petugas/Admin</a>
           
        </nav>
    </div>
</header>


<!-- ========================================================= -->
<!-- HERO SECTION (Background Merah Lengkung) -->
<!-- ========================================================= -->
<section class="py-5" style="
    background: linear-gradient(180deg, #c8102e 0%, #dd2b3f 60%, #ffffff 100%);
    color: white;
    min-height: 350px;
">

    <div class="container text-center mt-4">
        <h2 class="fw-bold">Layanan Aspirasi dan Pengaduan Online Masyarakat</h2>
        <p class="lead">Sampaikan laporan Anda langsung kepada instansi pemerintah berwenang</p>
    </div>

</section>


<!-- ========================================================= -->
<!-- FORM ADUAN (Kotak Putih di Tengah) -->
<!-- ========================================================= -->
<section class="form-section" style="margin-top: -200px; margin-bottom: 60px;">
    <div class="container d-flex justify-content-center">

        <div class="p-4 bg-white shadow-lg rounded" style="width: 700px; border-top: 5px solid #c8102e;">

            <h5 class="fw-bold mb-3 text-danger">Sampaikan Laporan Anda</h5>

            <form action="proses_aduan.php" method="POST" enctype="multipart/form-data">

                <!-- Nama -->
                <label class="fw-semibold">Nama Pelapor</label>
                <input type="text" name="nama_pelapor" class="form-control mb-3" required>

                <!-- Alamat -->
                <label class="fw-semibold">Alamat</label>
                <input type="text" name="alamat" class="form-control mb-3">

                <!-- NIK -->
                <label class="fw-semibold">NIK</label>
                <input type="number" name="nik" class="form-control mb-3">

                <!-- Kontak -->
                <label class="fw-semibold">Kontak / No Hp</label>
                <input type="text" name="kontak" class="form-control mb-3" required>

                <!-- Lokasi -->
                <label class="fw-semibold">Lokasi Kejadian</label>
                <input type="text" name="lokasi" class="form-control mb-3">

                <!-- Foto -->
                <label class="fw-semibold">Upload Bukti Foto</label>
                <input type="file" name="bukti_foto" class="form-control mb-3">

                <!-- Deskripsi -->
                <label class="fw-semibold">Deskripsi Aduan</label>
                <textarea name="deskripsi" rows="5" class="form-control mb-4" required></textarea>

                <div class="text-end">
                    <button class="btn btn-danger px-4">Kirim Aduan</button>
                </div>

            </form>
        </div>
    </div>
</section>


<!-- ========================================================= -->
<!-- ALUR / LANGKAH-LANGKAH -->
<!-- ========================================================= -->
<section class="container text-center my-5">

    <div class="row mt-4">

        <div class="col-md-3">
            <img src="../assets/img/icon1.png" width="60">
            <h6 class="fw-bold mt-2">Tulis Laporan</h6>
            <p class="small text-muted">Masyarakat dapat menyampaikan laporan mengenai masalah publik.</p>
        </div>

        <div class="col-md-3">
            <img src="../assets/img/icon2.png" width="60">
            <h6 class="fw-bold mt-2">Proses Verifikasi</h6>
            <p class="small text-muted">Dalam 3 hari kerja aduan akan diverifikasi oleh petugas.</p>
        </div>

        <div class="col-md-3">
            <img src="../assets/img/icon3.png" width="60">
            <h6 class="fw-bold mt-2">Tindak Lanjut</h6>
            <p class="small text-muted">Instansi terkait menindaklanjuti laporan masyarakat.</p>
        </div>

        <div class="col-md-3">
            <img src="../assets/img/icon4.png" width="60">
            <h6 class="fw-bold mt-2">Selesai</h6>
            <p class="small text-muted">Pelapor mendapat pemberitahuan setelah laporan selesai.</p>
        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- FOOTER -->
<!-- ========================================================= -->
<footer class="py-4 text-center text-white" style="background:#c8102e;">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
</footer>

</body>
</html>
