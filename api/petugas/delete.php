<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../../config/koneksi.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID tidak ditemukan'
    ]);
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = "DELETE FROM petugas WHERE Id_Petugas=$id";

if (mysqli_query($koneksi, $query)) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Petugas berhasil dihapus'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Gagal hapus petugas: ' . mysqli_error($koneksi)
    ]);
}
?>
