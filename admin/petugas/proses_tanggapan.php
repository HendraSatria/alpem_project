<?php
session_start();
require '../../config/koneksi.php';


// ======================================
// 1. Proteksi halaman
// ======================================
if (!isset($_SESSION['id_petugas']) || 
    ($_SESSION['role'] != 'petugas' && $_SESSION['role'] != 'admin')) {
    header("Location: ../../auth/login.php");
    exit;
}

// ======================================
// 2. Cek apakah form disubmit
// ======================================
if (!isset($_POST['submit_tanggapan'])) {
    header("Location: tanggapan.php");
    exit;
}

// ======================================
// 3. Ambil & validasi data
// ======================================
$id_aduan   = intval($_POST['id_aduan']);
$id_petugas = intval($_POST['id_petugas']);
$status     = mysqli_real_escape_string($koneksi, $_POST['status_tanggapan']);
$isi        = mysqli_real_escape_string($koneksi, $_POST['isi_tanggapan']);
$tanggal    = date('Y-m-d');

// Validasi dasar
if (empty($id_aduan) || empty($id_petugas) || empty($status)) {
    echo "<script>
        alert('Data tanggapan tidak lengkap!');
        window.location='tanggapan.php';
    </script>";
    exit;
}

// Check for status-only update
$is_status_only = isset($_POST['is_status_only']) && $_POST['is_status_only'] == '1';

if (empty($isi)) {
    if ($is_status_only) {
        // Auto-fill message for status update
        $isi = "Status laporan diperbarui dari sistem menjadi: " . ucfirst($status);
    } else {
        // Normal flow requires content
        echo "<script>
            alert('Isi tanggapan tidak boleh kosong!');
            window.location='tanggapan.php';
        </script>";
        exit;
    }
}

// ======================================
// 4. Simpan ke tabel tanggapan
// ======================================
$query = "
    INSERT INTO tanggapan 
    (Id_aduan, Id_petugas, Tanggal_tanggapan, Isi_tanggapan, Status)
    VALUES 
    ('$id_aduan', '$id_petugas', '$tanggal', '$isi', '$status')
";

$insert = mysqli_query($koneksi, $query);

// ======================================
// 5. Redirect hasil
// ======================================
if ($insert) {
    echo "<script>
        alert('Tanggapan berhasil dikirim!');
        window.location='tanggapan.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyimpan tanggapan!');
        window.location='tanggapan.php';
    </script>";
}
