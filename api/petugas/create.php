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

if (!isset($input['Nama_Petugas']) || !isset($input['Email']) || !isset($input['No_Telp'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak lengkap'
    ]);
    exit;
}

$nama = mysqli_real_escape_string($koneksi, $input['Nama_Petugas']);
$email = mysqli_real_escape_string($koneksi, $input['Email']);
$telp = mysqli_real_escape_string($koneksi, $input['No_Telp']);
$alamat = mysqli_real_escape_string($koneksi, $input['Alamat'] ?? '');
$username = strtolower(str_replace(' ', '_', $nama));
$password = password_hash('password123', PASSWORD_BCRYPT);
$role = $input['Role'] ?? 'petugas';
$status = $input['Status'] ?? 'Aktif';

$query = "INSERT INTO petugas (Nama_Petugas, Username, Email, No_Telp, Alamat, Password, Role, Status) 
          VALUES ('$nama', '$username', '$email', '$telp', '$alamat', '$password', '$role', '$status')";

if (mysqli_query($koneksi, $query)) {
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Petugas berhasil dibuat',
        'data' => [
            'id' => mysqli_insert_id($koneksi),
            'nama' => $nama,
            'email' => $email
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Gagal membuat petugas: ' . mysqli_error($koneksi)
    ]);
}
?>
