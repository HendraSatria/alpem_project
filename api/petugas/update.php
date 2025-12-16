<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
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
$input = json_decode(file_get_contents("php://input"), true);

$fields = [];
if (isset($input['Nama_Petugas'])) {
    $fields[] = "Nama_Petugas='" . mysqli_real_escape_string($koneksi, $input['Nama_Petugas']) . "'";
}
if (isset($input['Email'])) {
    $fields[] = "Email='" . mysqli_real_escape_string($koneksi, $input['Email']) . "'";
}
if (isset($input['No_Telp'])) {
    $fields[] = "No_Telp='" . mysqli_real_escape_string($koneksi, $input['No_Telp']) . "'";
}
if (isset($input['Alamat'])) {
    $fields[] = "Alamat='" . mysqli_real_escape_string($koneksi, $input['Alamat']) . "'";
}
if (isset($input['Status'])) {
    $fields[] = "Status='" . mysqli_real_escape_string($koneksi, $input['Status']) . "'";
}

if (empty($fields)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Tidak ada data untuk diupdate'
    ]);
    exit;
}

$query = "UPDATE petugas SET " . implode(', ', $fields) . " WHERE Id_Petugas=$id";

if (mysqli_query($koneksi, $query)) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Petugas berhasil diupdate'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Gagal update petugas: ' . mysqli_error($koneksi)
    ]);
}
?>
