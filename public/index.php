<?php require '../config/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Aduan - ALPEM</title>

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
            <a href="data_aduan.php" class="nav-link d-inline mx-2 ">Data Aduan</a>
            <a href="tentang.php" class="nav-link d-inline mx-2 ">Tentang</a>
            <a href="../auth/login.php" class="btn btn-outline-danger ms-3">Masuk Petugas/Admin</a>
        </nav>
    </div>
</header>


<!-- ========================================================= -->
<!-- HERO SECTION -->
<!-- ========================================================= -->
<section class="py-5" style="
    background: linear-gradient(180deg, #c8102e 0%, #dd2b3f 60%, #ffffff 100%);
    color: white;
    min-height: 250px;
">
    <div class="container text-center mt-4">
        <h2 class="fw-bold">Data Aduan Masyarakat</h2>
        <p class="lead">Semua aduan yang telah dikirim oleh masyarakat tersaji di halaman ini</p>
    </div>
</section>


<!-- ========================================================= -->
<!-- DATA ADUAN TABLE -->
<!-- ========================================================= -->
<section class="container" style="margin-top: -150px; margin-bottom: 60px;">
    <div class="bg-white shadow-lg rounded p-4">

        <h5 class="fw-bold text-danger mb-3">Daftar Aduan Masuk</h5>
        <hr>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-danger text-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelapor</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th>Bukti Foto</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "
                        SELECT a.*, 
                        (SELECT Status 
                         FROM tanggapan 
                         WHERE Id_aduan = a.Id_aduan 
                         ORDER BY Id_tanggapan DESC LIMIT 1) AS status_aduan
                        FROM aduan a 
                        ORDER BY a.Id_aduan DESC
                    ";
                    $result = mysqli_query($koneksi, $query);
                    $no = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            $status = $row['status_aduan'] ?? "Menunggu Tanggapan";

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

                        <td>
                            <?php if ($row['Bukti_Foto']) { ?>
                                <img src="../assets/img/<?= $row['Bukti_Foto']; ?>" 
                                     width="60" class="rounded shadow-sm">
                            <?php } else { ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php } ?>
                        </td>

                        <td style="text-align:left;">
                            <?= nl2br(htmlspecialchars($row['Deskripsi'])); ?>
                        </td>

                        <td>
                            <span class="badge bg-<?= $color; ?>">
                                <?= $status; ?>
                            </span>
                        </td>
                    </tr>

                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-muted py-4">Belum ada aduan masuk.</td>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>

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
 