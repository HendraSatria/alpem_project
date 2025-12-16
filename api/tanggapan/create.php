<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../../config/koneksi.php';

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['Id_Aduan']) || !isset($input['Id_Petugas']) || !isset($input['Tanggapan'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak lengkap'
    ]);
    exit;
}

$id_aduan = mysqli_real_escape_string($koneksi, $input['Id_Aduan']);
$id_petugas = mysqli_real_escape_string($koneksi, $input['Id_Petugas']);
$tanggapan = mysqli_real_escape_string($koneksi, $input['Tanggapan']);
$status = $input['Status'] ?? 'Pending';
$waktu = date('Y-m-d H:i:s');

$query = "INSERT INTO tanggapan (Id_Aduan, Id_Petugas, Status, Tanggapan, Waktu_Tanggapan) 
          VALUES ('$id_aduan', '$id_petugas', '$status', '$tanggapan', '$waktu')";

if (mysqli_query($koneksi, $query)) {
    // Update status aduan menjadi 'Sedang Diproses'
    $update_aduan = "UPDATE aduan SET Status='Sedang Diproses' WHERE Id_Aduan='$id_aduan'";
    mysqli_query($koneksi, $update_aduan);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Tanggapan berhasil dibuat',
        'data' => [
            'id' => mysqli_insert_id($koneksi),
            'id_aduan' => $id_aduan,
            'waktu' => $waktu
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Gagal membuat tanggapan: ' . mysqli_error($koneksi)
    ]);
}
?>
