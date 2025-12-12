<?php
require '../config/koneksi.php';
session_start();

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE Username='$username' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Verifikasi password
        if (password_verify($password, $data['Password'])) {

            // Buat session
            $_SESSION['id_petugas'] = $data['Id_Petugas'];
            $_SESSION['nama_petugas'] = $data['Nama_Petugas'];
            $_SESSION['role'] = $data['Role'];

            // Redirect berdasarkan role
            if ($data['Role'] == "admin") {
                header("Location: ../admin/dashboard_admin.php");
                exit;
            } else {
                header("Location: ../admin/dashboard_petugas.php");
                exit;
            }

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body style="background:#f5f5f5;">

<!-- ========================================================= -->
<!-- FORM LOGIN -->
<!-- ========================================================= -->

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    
    <div class="p-4 bg-white shadow-lg rounded" style="width: 420px; border-top: 5px solid #c8102e; animation: fadeIn 0.8s;">
        
        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="../assets/img/logo.png" width="80" class="mb-2">
            <h4 class="fw-bold text-danger m-0">ALPEM</h4>
        </div>

        <h5 class="fw-semibold text-center mb-3">Login Petugas / Admin</h5>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger py-2"><?= $error; ?></div>
        <?php } ?>

        <form method="POST">

            <!-- Username -->
            <div class="mb-3">
                <label class="fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <!-- Tombol Login -->
            <button type="submit" name="login" class="btn btn-danger w-100 fw-bold">Masuk</button>
        </form>

        <p class="text-center mt-3 small">
            © <?= date("Y"); ?> ALPEM – Aplikasi Pengaduan Masyarakat
        </p>

    </div>

</div>


<!-- ICONS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.js"></script>

</body>
</html>
