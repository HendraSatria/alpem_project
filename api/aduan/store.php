<?php
require '../config.php';

$nama = $_POST['nama_pelapor'];
$kontak = $_POST['kontak'];
$deskripsi = $_POST['deskripsi'];

mysqli_query($koneksi,"
    INSERT INTO aduan (Nama_pelapor, Kontak, Deskripsi)
    VALUES ('$nama','$kontak','$deskripsi')
");

header("Content-Type: application/json");
echo json_encode([
    "status" => "success",
    "message" => "Aduan berhasil dikirim"
]);
