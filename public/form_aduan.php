
<?php require '../config/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Aduan - ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Custom -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<!-- ===================== HEADER ===================== -->
<header class="py-3 shadow-sm bg-white">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h4 class="m-0 fw-bold">ALPEM</h4>
        </div>

        <nav>
            <a href="index.php" class="btn btn-primary me-2">Beranda</a>
            <a href="data_aduan.php" class="btn btn-outline-primary me-2">Data Aduan</a>
            <a href="tentang.php" class="btn btn-outline-primary">Tentang</a>
        </nav>

    </div>
</header>


<!-- ===================== TITLE ===================== -->
<div class="text-center mt-4">
    <h3 class="fw-bold">Form Aduan Masyarakat</h3>
    <hr class="mx-auto" style="width: 200px; border: 2px solid #0d6efd;">
</div>


<!-- ===================== MAIN FORM ===================== -->
<div class="container my-4">

    <div class="p-4 bg-white shadow-sm rounded" style="max-width: 850px; margin: auto;">

        <form action="proses_aduan.php" method="POST" enctype="multipart/form-data">

            <!-- Row 1 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">Nama</label>
                <div class="col-9">
                    <input type="text" name="nama_pelapor" class="form-control" required>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">Alamat</label>
                <div class="col-9">
                    <input type="text" name="alamat" class="form-control">
                </div>
            </div>

            <!-- Row 3 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">NIK</label>
                <div class="col-9">
                    <input type="number" name="nik" class="form-control">
                </div>
            </div>

            <!-- Row 4 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">No Telp</label>
                <div class="col-9">
                    <input type="text" name="kontak" class="form-control" required>
                </div>
            </div>

            <!-- Row 5 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">Aduan</label>
                <div class="col-9">
                    <input type="text" name="aduan" class="form-control" placeholder="Judul singkat aduan">
                </div>
            </div>

            <!-- Row 6 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">Lokasi</label>
                <div class="col-9">
                    <input type="text" name="lokasi" class="form-control">
                </div>
            </div>

            <!-- Row 7 -->
            <div class="row mb-3">
                <label class="col-3 col-form-label fw-semibold">Bukti Foto</label>
                <div class="col-9">
                    <input type="file" name="bukti_foto" class="form-control">
                </div>
            </div>

            <!-- Row 8 -->
            <div class="row mb-4">
                <label class="col-3 col-form-label fw-semibold">Deskripsi</label>
                <div class="col-9">
                    <textarea name="deskripsi" rows="4" class="form-control" required></textarea>
                </div>
            </div>


            <!-- Submit button aligned RIGHT (sesuai gambar) -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Submit</button>
            </div>

        </form>

    </div>

</div>


<!-- ===================== FOOTER ===================== -->
<footer class="footer-alpem mt-4">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
</footer>

</body>
</html>
