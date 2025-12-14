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

// Cek apakah parameter ID Petugas ada
if (isset($_GET['id'])) {

    // ======================================
    // 2. Ambil dan Bersihkan ID
    // ======================================
    $id_petugas = mysqli_real_escape_string($koneksi, $_GET['id']);

    // ======================================
    // 3. Ambil Nama Petugas untuk Notifikasi
    // ======================================
    $query_select = mysqli_query($koneksi, "SELECT Nama_Petugas FROM petugas WHERE Id_Petugas = '$id_petugas'");
    $data_petugas = mysqli_fetch_assoc($query_select);
    $nama_petugas = $data_petugas ? $data_petugas['Nama_Petugas'] : 'Petugas Tidak Dikenal';

    // ======================================
    // 4. Query DELETE Data dari Database
    // ======================================
    $query_delete = "DELETE FROM petugas WHERE Id_Petugas = '$id_petugas'";

    if (mysqli_query($koneksi, $query_delete)) {
        // Berhasil dihapus
        $_SESSION['notif'] = ['tipe' => 'success', 'pesan' => 'Petugas **' . htmlspecialchars($nama_petugas) . '** berhasil dihapus!'];
    } else {
        // Gagal dihapus
        $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Gagal menghapus petugas. Error: ' . mysqli_error($koneksi)];
    }
} else {
    // Jika diakses tanpa parameter ID
    $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'ID Petugas tidak ditemukan.'];
}

// ======================================
// 5. Redirect kembali ke halaman kelola petugas
// ======================================
header("Location: kelola_petugas.php");
exit;
?>