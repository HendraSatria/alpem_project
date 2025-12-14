<?php
session_start();
require '../config/koneksi.php';

// ======================================
// 1. Proteksi halaman: hanya admin
// ======================================
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: ../auth/login.php");
    exit;
}

// ======================================
// 2. Pastikan request POST
// ======================================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['notif'] = [
        'tipe' => 'danger',
        'pesan' => 'Akses tidak sah.'
    ];
    header("Location: kelola_petugas.php");
    exit;
}

// ======================================
// 3. Ambil & bersihkan data
// ======================================
$nama_admin = trim(mysqli_real_escape_string($koneksi, $_POST['nama_admin']));
$username   = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
$password   = $_POST['password'];

// Role dipaksa admin (tidak dari input user)
$role = "admin";

// Validasi
if (empty($nama_admin) || empty($username) || empty($password)) {
    $_SESSION['notif'] = [
        'tipe' => 'warning',
        'pesan' => 'Semua kolom wajib diisi.'
    ];
    header("Location: kelola_petugas.php");
    exit;
}

// ======================================
// 4. Cek username unik
// ======================================
$cek = mysqli_query($koneksi, "SELECT Username FROM petugas WHERE Username = '$username'");
if (mysqli_num_rows($cek) > 0) {
    $_SESSION['notif'] = [
        'tipe' => 'warning',
        'pesan' => 'Username <b>' . htmlspecialchars($username) . '</b> sudah digunakan.'
    ];
    header("Location: kelola_petugas.php");
    exit;
}

// ======================================
// 5. Hash password
// ======================================
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// ======================================
// 6. Simpan ke database
// ======================================
$query = "INSERT INTO petugas (Nama_Petugas, Username, Password, Role)
          VALUES ('$nama_admin', '$username', '$password_hash', '$role')";

if (mysqli_query($koneksi, $query)) {
    $_SESSION['notif'] = [
        'tipe' => 'success',
        'pesan' => 'Admin <b>' . htmlspecialchars($nama_admin) . '</b> berhasil ditambahkan.'
    ];
} else {
    $_SESSION['notif'] = [
        'tipe' => 'danger',
        'pesan' => 'Gagal menambahkan admin. Error: ' . mysqli_error($koneksi)
    ];
}

// ======================================
// 7. Redirect
// ======================================
header("Location: kelola_petugas.php");
exit;
