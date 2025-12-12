<?php
// Pastikan semua file PHP dimulai dengan session_start() jika menggunakan sesi.
session_start();

// 1. Sertakan file koneksi database
include '../config/koneksi.php';

// Cek apakah data dikirim melalui POST
if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {

    // 2. Ambil dan Bersihkan Input
    // Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_input = $_POST['password']; // Password mentah dari form
    $role_input = mysqli_real_escape_string($koneksi, $_POST['role']);

    // 3. Query data petugas (Hanya berdasarkan username)
    // Ambil semua data termasuk password (hash) dan role yang sebenarnya
    $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE Username='$username' LIMIT 1");
    $data_petugas = mysqli_fetch_assoc($query);

    // 4. Verifikasi
    if ($data_petugas) {
        
        // a. Verifikasi Password (HARUS menggunakan password_verify karena password harus di-hash)
        if (password_verify($password_input, $data_petugas['Password'])) {
            
            // b. Verifikasi Role (Cek kecocokan antara input dan data di DB)
            if ($data_petugas['Role'] == $role_input) {
                
                // --- Otentikasi BERHASIL ---
                
                // 5. Buat Session
                $_SESSION['id_petugas'] = $data_petugas['Id_Petugas'];
                $_SESSION['nama_petugas'] = $data_petugas['Nama_Petugas'];
                $_SESSION['role'] = $data_petugas['Role']; // Simpan role yang sebenarnya dari DB
                
                // 6. Redirect berdasarkan Role
                $role = $data_petugas['Role'];
                
                // Perbaikan Sintaks: Menggunakan string concatenation yang benar
                header('Location: ../admin/dashboard_' . $role . '.php');
                exit; // Selalu gunakan exit setelah header redirect

            } else {
                // Role tidak cocok
                $_SESSION['error'] = "Akses ditolak. Anda login sebagai **" . ucfirst($role_input) . "**, tetapi terdaftar sebagai **" . ucfirst($data_petugas['Role']) . "**.";
            }
            
        } else {
            // Password salah
            $_SESSION['error'] = "Username atau Password salah!";
        }
        
    } else {
        // Username tidak ditemukan
        $_SESSION['error'] = "Username atau Password salah!";
    }

} else {
    // Jika tidak ada data POST
    $_SESSION['error'] = "Akses tidak sah.";
}

// Redirect kembali ke halaman login jika gagal
header('Location: login.php');
exit;
?>