<?php
require '../config/koneksi.php';
session_start();

$error = ''; // Variabel untuk menyimpan pesan error

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    // Ambil data input
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Ambil password mentah
    $role_input = mysqli_real_escape_string($koneksi, $_POST['role']); // Ambil role dari dropdown

    // 1. Cari data petugas berdasarkan username
    $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE Username='$username' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // 2. Verifikasi Password
        if (password_verify($password, $data['Password'])) {
            
            // 3. Verifikasi Role (Periksa kecocokan antara input dan data di DB)
            if ($data['Role'] == $role_input) {
                
                // --- Otentikasi Berhasil ---
                
                // Buat session
                $_SESSION['id_petugas'] = $data['Id_Petugas'];
                $_SESSION['nama_petugas'] = $data['Nama_Petugas'];
                $_SESSION['role'] = $data['Role']; // Role yang sebenarnya dari DB

                // Redirect berdasarkan role
                if ($data['Role'] == "admin") {
                    header("Location: ../admin/dashboard_admin.php");
                    exit;
                } else {
                    // Petugas
                    header("Location: ../admin/petugas/dashboard_petugas.php");
                    exit;
                }

            } else {
                // Role tidak cocok
                $error = "Akses ditolak. Anda mencoba masuk sebagai **" . ucfirst($role_input) . "**, tetapi Anda terdaftar sebagai **" . ucfirst($data['Role']) . "**.";
            }

        } else {
            // Password salah
            $error = "Username atau Password salah!";
        }

    } else {
        // Username tidak ditemukan
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - ALPEM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body style="background:#f5f5f5;">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    
    <div class="p-4 bg-white shadow-lg rounded" style="width: 420px; border-top: 5px solid #c8102e; animation: fadeIn 0.8s;">
        
        <div class="text-center mb-3">
            <img src="../assets/img/logo.png" width="80" class="mb-2">
            <h4 class="fw-bold text-danger m-0">ALPEM</h4>
        </div>

        <h5 class="fw-semibold text-center mb-3">Login Petugas / Admin</h5>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger py-2"><?= $error; ?></div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="fw-semibold">Masuk Sebagai</label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-person-badge"></i></span>
                    <select name="role" class="form-select" required>
                        <option value="" disabled selected>Pilih Peran Anda</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-danger w-100 fw-bold">Masuk</button>
        </form>

        <p class="text-center mt-3 small">
            © <?= date("Y"); ?> ALPEM – Aplikasi Pengaduan Masyarakat
        </p>

    </div>

</div>

</body>
</html>