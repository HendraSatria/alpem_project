<?php
// Konfigurasi Database
$host     = "localhost";
$user     = "root";       // sesuaikan jika memakai user lain
$pass     = "";           // sesuaikan dengan password MySQL anda
$db       = "db_alpem1";   // sesuai dengan database yang anda buat

// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// (Opsional) Set charset agar mendukung karakter UTF-8
mysqli_set_charset($koneksi, "utf8");

?>
