<?php
session_start();
require '../../config/koneksi.php';


// ======================================
// 1. Proteksi halaman (Hanya Petugas/Admin yang sudah login)
// ======================================
// Proteksi: hanya petugas
if (!isset($_SESSION['role']) || $_SESSION['role'] != "petugas") {
    header("Location: ../../auth/login.php");
    exit;
}



$nama_petugas = $_SESSION['nama_petugas'];
$role = $_SESSION['role'];

// ======================================
// 2. Query Utama: Ambil semua aduan dan status terbarunya
// ======================================
$query_aduan = "
    SELECT 
        a.Id_aduan, a.Nama_pelapor, a.Kontak, a.Lokasi, a.Deskripsi, a.Bukti_Foto,
        (SELECT Status FROM tanggapan 
         WHERE Id_aduan = a.Id_aduan 
         ORDER BY Id_tanggapan DESC LIMIT 1) AS status_terakhir
    FROM aduan a
    ORDER BY a.Id_aduan DESC
";
$result_aduan = mysqli_query($koneksi, $query_aduan);

// Query untuk data yang akan digunakan di modal (jika perlu)
// Biasanya data ini di-fetch via JavaScript, tapi kita siapkan kerangka PHP-nya.

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Aduan - ALPEM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body { background: #f6f6f6; }
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
        .sidebar a:hover, .sidebar .active {
            background: rgba(255,255,255,0.2);
            transition: 0.3s;
        }
        .content {
            margin-left: 260px;
        }
        .btn-action {
            width: 120px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="text-center mb-4">
        <img src="../../assets/img/logo.png" width="70">
        <h5 class="mt-2">ALPEM</h5>
    </div>

    <a href="dashboard_<?= $role ?>.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="tanggapan.php" class="active"><i class="bi bi-chat-left-text me-2"></i> Verifikasi Aduan</a>


    <a href="../../auth/login.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
</div>


<div class="content">
    <nav class="navbar navbar-light bg-white shadow-sm px-3">
        <span class="navbar-brand fw-bold">Verifikasi dan Tanggapan Aduan</span>
        <span>Halo, <strong><?= $nama_petugas ?></strong> (<?= ucfirst($role) ?>) 👋</span>
    </nav>


    <div class="container mt-4">
        
        <h4 class="mb-3">Daftar Aduan Masuk</h4>

        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white fw-bold">
                Data Aduan yang Perlu Ditindaklanjuti
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                              
                                <th>Pelapor</th>
                                <th style="width: 30%;">Deskripsi Singkat</th>
                                <th>Status Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $no = 1;
                            if (mysqli_num_rows($result_aduan) > 0) {
                                while ($data = mysqli_fetch_assoc($result_aduan)) {
                                    $status = $data['status_terakhir'] ?? "Belum Ditanggapi";
                                    
                                    $color = "secondary";
                                    if ($status == 'diproses') $color = "info";
                                    if ($status == 'selesai') $color = "success";
                                    if ($status == 'data tidak lengkap') $color = "warning";
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                
                                <td><?= htmlspecialchars($data['Nama_pelapor']) ?></td>
                                <td class="text-start small"><?= substr(htmlspecialchars($data['Deskripsi']), 0, 100) ?>...</td>
                                <td><span class="badge bg-<?= $color ?>"><?= ucfirst($status) ?></span></td>
                                <td>
                                    <button 
                                        type="button" 
                                        class="btn btn-sm btn-action btn-danger detail-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalTanggapan"
                                        data-id="<?= $data['Id_aduan'] ?>"
                                        data-nama="<?= htmlspecialchars($data['Nama_pelapor']) ?>"
                                        data-lokasi="<?= htmlspecialchars($data['Lokasi']) ?>"
                                        data-kontak="<?= htmlspecialchars($data['Kontak']) ?>"
                                        data-deskripsi="<?= htmlspecialchars($data['Deskripsi']) ?>"
                                        data-foto="<?= htmlspecialchars($data['Bukti_Foto']) ?>"
                                        data-status="<?= $status ?>"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i> Tanggapi
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-muted py-3">Tidak ada aduan yang perlu ditindaklanjuti.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="modalTanggapan" tabindex="-1" aria-labelledby="modalTanggapanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalTanggapanLabel"><i class="bi bi-chat-dots me-1"></i> Beri Tanggapan dan Ubah Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_tanggapan.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_aduan" id="aduan_id">
                    <input type="hidden" name="id_petugas" value="<?= $_SESSION['id_petugas'] ?>">

                    <h6>Detail Aduan: <span id="detail_nama" class="fw-bold"></span></h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Kontak:</label>
                            <p class="form-control-plaintext fw-bold" id="detail_kontak"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Lokasi:</label>
                            <p class="form-control-plaintext fw-bold" id="detail_lokasi"></p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label small text-muted">Deskripsi Aduan:</label>
                            <textarea class="form-control" id="detail_deskripsi" rows="4" readonly></textarea>
                        </div>
                        <div class="col-md-4 text-center">
                            <label class="form-label small text-muted">Bukti Foto:</label><br>
                            <img id="detail_foto" src="" alt="Bukti Foto" class="img-fluid rounded shadow" style="max-height: 150px;">
                        </div>
                    </div>
                    <hr>

                    <div class="mb-3">
                        <label for="status_tanggapan" class="form-label fw-bold">Ubah Status</label>
                        <select name="status_tanggapan" id="status_tanggapan" class="form-select" required>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="data tidak lengkap">Data Tidak Lengkap</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="isi_tanggapan" class="form-label fw-bold">Isi Tanggapan / Keterangan</label>
                        <textarea name="isi_tanggapan" id="isi_tanggapan" rows="4" class="form-control" placeholder="Tulis tanggapan atau penjelasan tindakan yang sudah dilakukan..." required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit_tanggapan" class="btn btn-danger"><i class="bi bi-send me-1"></i> Kirim Tanggapan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalTanggapan = document.getElementById('modalTanggapan');
        modalTanggapan.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button yang memicu modal

            // Ambil data dari data-* attributes
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const lokasi = button.getAttribute('data-lokasi');
            const kontak = button.getAttribute('data-kontak');
            const deskripsi = button.getAttribute('data-deskripsi');
            const foto = button.getAttribute('data-foto');
            const status = button.getAttribute('data-status');

            // Update konten modal
            document.getElementById('aduan_id').value = id;
            document.getElementById('detail_nama').textContent = nama;
            document.getElementById('detail_kontak').textContent = kontak;
            document.getElementById('detail_lokasi').textContent = lokasi;
            document.getElementById('detail_deskripsi').value = deskripsi;
            
            // Set status yang dipilih
            document.getElementById('status_tanggapan').value = status.toLowerCase();
            
            // Set foto
            const imgElement = document.getElementById('detail_foto');
            if (foto && foto !== '') {
                imgElement.src = '../../assets/img/' + foto;
                imgElement.style.display = 'block';
            } else {
                imgElement.src = '';
                imgElement.alt = 'Tidak ada bukti foto';
                imgElement.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>