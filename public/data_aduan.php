<?php 
require '../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ALPEM - Aplikasi Layanan Pengaduan Masyarakat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

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

<section class="hero fade-in" style="padding: 60px 0; min-height: 200px;">
    <div class="container text-center text-white mt-3">
        <h2 class="fw-bold">Data Aduan Masyarakat</h2>
        <p class="lead">Pantau seluruh aduan yang telah masuk ke sistem ALPEM</p>
    </div>
</section>

<div class="container fade-in" style="margin-top: -100px; margin-bottom: 70px;">

    <div class="p-4 bg-white shadow-lg rounded form-card">

        <h5 class="fw-bold text-danger mb-3">Daftar Aduan Terbaru</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control"
                    placeholder="🔍 Cari nama, kontak, atau lokasi aduan...">
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center" id="aduanTable">


                <thead class="table-danger">
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

                <tbody id="aduanBody">

                    <?php
                    $query = "
                        SELECT a.*, 
                        (SELECT Status FROM tanggapan 
                         WHERE Id_aduan = a.Id_aduan 
                         ORDER BY Id_tanggapan DESC LIMIT 1) AS status_aduan
                        FROM aduan a ORDER BY a.Id_aduan DESC
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
                            
                            // *** PERBAIKAN 1: Buat string data pencarian ***
                            $search_data = strtolower(
                                htmlspecialchars($row['Nama_pelapor']) . " " . 
                                htmlspecialchars($row['Kontak']) . " " . 
                                htmlspecialchars($row['Lokasi'])
                            );
                    ?>

                    <tr class="aduan-row" data-search="<?= $search_data; ?>">
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['Nama_pelapor']); ?></td>
                        <td><?= htmlspecialchars($row['Kontak']); ?></td>
                        <td><?= htmlspecialchars($row['Lokasi']); ?></td>

                        <td>
                            <?php if ($row['Bukti_Foto']) { ?>
                                <img src="../assets/img/<?= $row['Bukti_Foto']; ?>" 
                                    width="80" class="rounded shadow-sm" alt="Bukti Foto">
                            <?php } else { ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php } ?>
                        </td>

                        <td class="text-start">
                            <div style="max-width: 250px; margin:auto;">
                                <?= nl2br(htmlspecialchars($row['Deskripsi'])); ?>
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-<?= $color; ?> px-3 py-2">
                                <?= $status; ?>
                            </span>
                        </td>
                    </tr>

                    <?php 
                        } 
                    } else { 
                    ?>

                    <tr>
                        <td colspan="7" class="text-muted py-3 no-aduan">
                            Belum ada aduan masuk.
                        </td>
                    </tr>

                    <?php } ?>
                </tbody>

            </table>
        </div>
        <div id="noResults" class="text-center text-muted py-3" style="display: none;">
            Tidak ada aduan yang cocok dengan kata kunci Anda.
        </div>

    </div>

</div>

<footer class="text-center py-4 text-white" style="background:#c8102e;">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
</footer>

<script>
const searchInput = document.getElementById("searchInput");
const tableBody = document.getElementById("aduanBody");
const noResultsDiv = document.getElementById("noResults"); // Elemen baru untuk pesan tidak ditemukan
const allRows = tableBody.querySelectorAll(".aduan-row"); // Ambil semua baris aduan

searchInput.addEventListener("keyup", function () {
    const keyword = this.value.toLowerCase().trim();
    let rowCount = 0;

    // Iterasi melalui semua baris data
    allRows.forEach(row => {
        // Ambil data pencarian dari atribut data-search
        const searchData = row.dataset.search; 

        if (searchData && searchData.includes(keyword)) {
            // Jika keyword ditemukan, tampilkan baris
            row.style.display = "";
            rowCount++;
        } else {
            // Jika keyword tidak ditemukan, sembunyikan baris
            row.style.display = "none";
        }
    });

    // Tampilkan/sembunyikan pesan "Tidak Ada Hasil"
    if (rowCount === 0 && keyword !== "") {
        noResultsDiv.style.display = "block";
    } else {
        noResultsDiv.style.display = "none";
    }
});
</script>


</body>
</html>