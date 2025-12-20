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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
                        sans: ['Outfit', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .animated-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C8102E' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        /* Custom animated background specific for this page */
        .wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); 
        }
        .box div {
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: transparent;
            border: 6px solid rgba(200, 16, 46, 0.15);
            z-index: 0;
        }
        .box div:nth-child(1) {
            top: 12%;
            left: 42%;
            animation: animate 10s linear infinite;
        }
        .box div:nth-child(2) {
            top: 70%;
            left: 50%;
            animation: animate 7s linear infinite;
        }
        .box div:nth-child(3) {
            top: 17%;
            left: 6%;
            animation: animate 9s linear infinite;
        }
        .box div:nth-child(4) {
            top: 20%;
            left: 60%;
            animation: animate 10s linear infinite;
        }
        .box div:nth-child(5) {
            top: 67%;
            left: 10%;
            animation: animate 6s linear infinite;
        }
        .box div:nth-child(6) {
            top: 80%;
            left: 70%;
            animation: animate 12s linear infinite;
        }
        .box div:nth-child(7) {
            top: 60%;
            left: 80%;
            animation: animate 15s linear infinite;
        }
        .box div:nth-child(8) {
            top: 32%;
            left: 25%;
            animation: animate 16s linear infinite;
        }
        .box div:nth-child(9) {
            top: 90%;
            left: 25%;
            animation: animate 9s linear infinite;
        }
        .box div:nth-child(10) {
            top: 20%;
            left: 80%;
            animation: animate 5s linear infinite;
        }
        @keyframes animate {
            0% {
                transform: scale(0) translateY(0) rotate(0);
                opacity: 1;
            }
            100% {
                transform: scale(1.3) translateY(-90px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">

<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gray-50">
    
    <!-- Animated Background -->
    <div class="wrapper">
        <div class="box">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="relative w-full max-w-4xl flex bg-white rounded-3xl shadow-2xl overflow-hidden m-4 animate-fade-in-up z-10 border border-gray-100">
        
        <!-- Left Side (Illustration/Brand) - Visible on larger screens -->
        <div class="hidden md:flex md:w-1/2 bg-primary relative items-center justify-center p-10 overflow-hidden">
            <div class="absolute inset-0 z-0">
                 <svg class="absolute top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 text-white opacity-10 animate-blob" viewBox="0 0 200 200" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 10m-10 0a10 10 0 1 0 20 0a10 10 0 1 0 -20 0" />
                 </svg>
                 <svg class="absolute bottom-0 right-0 transform translate-x-1/3 translate-y-1/3 w-80 h-80 text-white opacity-10 animate-blob animation-delay-2000" viewBox="0 0 200 200" fill="currentColor">
                    <circle cx="100" cy="100" r="100" />
                 </svg>
            </div>
            
            <div class="relative z-10 text-center text-white">
                <div class="mb-6 inline-block p-4 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
                     <img src="../assets/img/logo1.png" alt="Logo" class="w-24 h-24 object-contain brightness-0 invert">
                </div>
                <h2 class="text-3xl font-bold mb-2">ALPEM</h2>
                <p class="text-primary-light/90 text-sm leading-relaxed">Aplikasi Pengaduan Masyarakat.<br>Layanan aspirasi dan pengaduan online rakyat.</p>
            </div>
        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-white">
            
            <div class="text-center md:text-left mb-8">
                <h4 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h4>
                <p class="text-gray-500 text-sm">Silahkan login untuk mengakses akun Anda.</p>
            </div>

            <?php if (!empty($error)) { ?>
                 <div class="bg-red-50 border-l-4 border-primary text-red-700 p-4 rounded-r shadow-sm mb-6 text-sm flex items-start gap-3 animate-pulse">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="font-bold">Login Gagal</p>
                        <p><?= $error; ?></p>
                    </div>
                </div>
            <?php } ?>

            <form method="POST" class="space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Masuk Sebagai</label>
                    <div class="relative group">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <select name="role" class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50 hover:bg-white cursor-pointer" required>
                            <option value="" disabled selected>Pilih Peran Anda</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                         <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                         </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="username" class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50 hover:bg-white placeholder-gray-400" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm bg-gray-50 hover:bg-white placeholder-gray-400" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" name="login" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Masuk Dashboard
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium">
                    &copy; <?= date("Y"); ?> ALPEM System v2.0
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translate3d(0, 40px, 0); }
        to { opacity: 1; transform: none; }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
</style>

</body>
</html>