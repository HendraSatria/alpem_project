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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALPEM</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C8102E',
                        'primary-dark': '#A00D25',
                        'primary-light': '#FDE8EB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative Background pattern -->
    <div class="absolute inset-0 z-0 opacity-10">
         <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="#C8102E" />
            <path d="M0 0 C 50 100 80 100 100 0 Z" fill="#C8102E" opacity="0.5" />
        </svg>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md relative z-10 border-t-4 border-primary animate-fade-in-up">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-light text-primary mb-4">
               <img src="../assets/img/logo.png" alt="Logo" class="w-10 h-10 object-contain">
            </div>
            <h4 class="text-2xl font-bold text-gray-900">Selamat Datang di ALPEM</h4>
            <p class="text-sm text-gray-500 mt-2">Silahkan login untuk masuk ke panel petugas/admin</p>
        </div>

        <?php if (!empty($error)) { ?>
             <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?= $error; ?></span>
            </div>
        <?php } ?>

        <form method="POST" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Masuk Sebagai</label>
                <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </div>
                    <select name="role" class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm bg-white" required>
                        <option value="" disabled selected>Pilih Peran Anda</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="username" class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm placeholder-gray-400" placeholder="Masukkan username" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-sm placeholder-gray-400" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-primary text-white py-2.5 rounded-lg font-bold shadow-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; <?= date("Y"); ?> ALPEM – Aplikasi Pengaduan Masyarakat
        </div>

    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translate3d(0, 20px, 0); }
        to { opacity: 1; transform: none; }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
</style>

</body>
</html>