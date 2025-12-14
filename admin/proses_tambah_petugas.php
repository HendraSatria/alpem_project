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
    $nama_petugas = trim(mysqli_real_escape_string($koneksi, $_POST['nama_petugas']));
    $username = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
    $password_plain = $_POST['password']; // Ambil password mentah
    $role = $_POST['role'];
    
    // Validasi sederhana
    if (empty($nama_petugas) || empty($username) || empty($password_plain) || empty($role)) {
        $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Semua kolom wajib diisi.'];
        header("Location: kelola_petugas.php");
        exit;
    }

    // ======================================
    // 3. Cek ketersediaan Username
    // ======================================
    $cek_username = mysqli_query($koneksi, "SELECT Username FROM petugas WHERE Username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        $_SESSION['notif'] = ['tipe' => 'warning', 'pesan' => 'Username **' . htmlspecialchars($username) . '** sudah digunakan. Pilih username lain.'];
        header("Location: kelola_petugas.php");
        exit;
    }

    // ======================================
    // 4. Hash Password
    // ======================================
    // Gunakan password_hash() untuk menyimpan password secara aman
    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

    // ======================================
    // 5. Query INSERT Data ke Database
    // ======================================
    $query_insert = "INSERT INTO petugas (Nama_Petugas, Username, Password, Role) 
                     VALUES ('$nama_petugas', '$username', '$password_hashed', '$role')";

    if (mysqli_query($koneksi, $query_insert)) {
        // Berhasil disimpan
        $_SESSION['notif'] = ['tipe' => 'success', 'pesan' => 'Petugas **' . htmlspecialchars($nama_petugas) . '** berhasil ditambahkan!'];
    } else {
        // Gagal disimpan
        $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Gagal menambahkan petugas. Error: ' . mysqli_error($koneksi)];
    }
} else {
    // Jika diakses tidak melalui POST (misal langsung dari URL)
    $_SESSION['notif'] = ['tipe' => 'danger', 'pesan' => 'Akses tidak sah.'];
}

// ======================================
// 6. Redirect kembali ke halaman kelola petugas
// ======================================
header("Location: kelola_petugas.php");
exit;
?>