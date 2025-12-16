<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../config/koneksi.php';

// Ambil JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['username']) || !isset($input['password']) || !isset($input['role'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Username, password, dan role harus diisi'
    ]);
    exit;
}

$username = mysqli_real_escape_string($koneksi, $input['username']);
$password = $input['password'];
$role = mysqli_real_escape_string($koneksi, $input['role']);

// Query petugas
$query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE Username='$username' LIMIT 1");
$petugas = mysqli_fetch_assoc($query);

if (!$petugas) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Username tidak ditemukan'
    ]);
    exit;
}

// Verifikasi password
if (!password_verify($password, $petugas['Password'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Password salah'
    ]);
    exit;
}

// Verifikasi role
if ($petugas['Role'] != $role) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Role tidak sesuai'
    ]);
    exit;
}

// Login berhasil - return token dan user data
$token = bin2hex(random_bytes(32)); // Simple token

http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Login berhasil',
    'data' => [
        'id_petugas' => $petugas['Id_Petugas'],
        'nama_petugas' => $petugas['Nama_Petugas'],
        'username' => $petugas['Username'],
        'email' => $petugas['Email'],
        'role' => $petugas['Role'],
        'token' => $token
    ]
]);
?>
