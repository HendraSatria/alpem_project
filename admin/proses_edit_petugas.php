<?php
session_start();
require '../config/koneksi.php'; // Pastikan path ini benar

// ======================================
// 1. Proteksi halaman: hanya admin yang bisa mengakses
// ======================================
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}

// Cek apakah data dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ======================================
    // 2. Ambil dan Bersihkan Data Input
    // ======================================
    $id_petugas = mysqli_real_escape_string($koneksi, $_POST['id_petugas']);
    $nama_petugas = trim(mysqli_real_escape_string($koneksi, $_POST['nama_petugas']));
    $username = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    
    // Asumsi: Password tidak diubah di form edit ini. Jika ingin mengubah password, 
    // biasanya disediakan field password kosong opsional yang jika diisi akan diupdate.
    
    // Validasi sederhana
    if (empty($id_petugas) || empty($nama_petugas) || empty($username) || empty($role)) {
        $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Semua kolom wajib diisi.'];
        header("Location: kelola_petugas.php");
        exit;
    }
    
    // ======================================
    // 3. Cek ketersediaan Username (untuk user lain)
    // ======================================
    $cek_username = mysqli_query($koneksi, "SELECT Id_Petugas FROM petugas WHERE Username = '$username' AND Id_Petugas != '$id_petugas'");
    if (mysqli_num_rows($cek_username) > 0) {
        $_SESSION['notif'] = ['tipe' => 'warning', 'pesan' => 'Username **' . htmlspecialchars($username) . '** sudah digunakan oleh petugas lain. Pilih username lain.'];
        header("Location: kelola_petugas.php");
        exit;
    }

    // ======================================
    // 4. Query UPDATE Data ke Database
    // ======================================
    $query_update = "UPDATE petugas SET 
                     Nama_Petugas = '$nama_petugas', 
                     Username = '$username', 
                     Role = '$role' 
                     WHERE Id_Petugas = '$id_petugas'";

    if (mysqli_query($koneksi, $query_update)) {
        // Berhasil diupdate
        $_SESSION['notif'] = ['tipe' => 'success', 'pesan' => 'Data petugas **' . htmlspecialchars($nama_petugas) . '** berhasil diubah!'];
    } else {
        // Gagal diupdate
        $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Gagal mengubah data petugas. Error: ' . mysqli_error($koneksi)];
    }
} else {
    // Jika diakses tidak melalui POST
    $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Akses tidak sah.'];
}

// ======================================
// 5. Redirect kembali ke halaman kelola petugas
// ======================================
header("Location: kelola_petugas.php");
exit;
?>