<?php
session_start();
require '../../config/koneksi.php';


// Proteksi halaman
if (!isset($_SESSION['id_petugas'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$nama = $_SESSION['nama_petugas'];

// Hitung statistik
$total    = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM aduan"))[0];
$diproses = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='diproses'"))[0];
$selesai  = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='selesai'"))[0];
$tdl      = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM tanggapan WHERE Status='data tidak lengkap'"))[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - ALPEM</title>
    
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

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-primary text-white flex flex-col shadow-xl z-20 hidden md:flex">
        <div class="h-16 flex items-center justify-center border-b border-primary-dark shadow-sm">
             <div class="flex items-center gap-2">
                <img src="../../assets/img/logo.png" alt="ALPEM" class="h-8 w-auto">
                <span class="text-xl font-bold tracking-tight">ALPEM</span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="text-xs font-semibold text-primary-light uppercase tracking-wider mb-2">Menu Utama</p>
            
            <a href="dashboard_petugas.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white shadow-sm ring-1 ring-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="tanggapan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="font-medium">Verifikasi Aduan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-primary-dark">
            <a href="../../auth/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-red-700 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="font-medium">Logout</span>
            </a>
        </div>
    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- HEADER -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center md:hidden">
                <button class="text-gray-500 hover:text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            
            <div class="flex flex-col">
                <h1 class="text-xl font-bold text-gray-800 leading-none">Dashboard Petugas</h1>
                <p class="text-xs text-gray-500 mt-1">Selamat datang kembali, <span class="text-primary font-bold"><?= htmlspecialchars($nama); ?></span></p>
            </div>

            <div class="flex items-center gap-4">
               <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold">
                    <?= substr($nama, 0, 1) ?>
               </div>
            </div>
        </header>

        <!-- MAIN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            
            <!-- STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 text-xl font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Aduan</p>
                        <h4 class="text-2xl font-bold text-gray-900"><?= $total ?></h4>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-50 relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-20 h-20 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    </div>
                     <div class="flex items-center gap-4 relative z-10">
                         <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl font-bold">
                           P
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Diproses</p>
                            <h4 class="text-2xl font-bold text-gray-900"><?= $diproses ?></h4>
                        </div>
                    </div>
                </div>

                 <!-- Card 3 -->
                  <div class="bg-white p-6 rounded-xl shadow-sm border border-green-50 relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                         <svg class="w-20 h-20 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                     <div class="flex items-center gap-4 relative z-10">
                         <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xl font-bold">
                           S
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Selesai</p>
                            <h4 class="text-2xl font-bold text-gray-900"><?= $selesai ?></h4>
                        </div>
                    </div>
                </div>
                 <!-- Card 4 -->
                  <div class="bg-white p-6 rounded-xl shadow-sm border border-yellow-50 relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-20 h-20 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    </div>
                     <div class="flex items-center gap-4 relative z-10">
                         <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-xl font-bold">
                           !
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Data Tidak Lengkap</p>
                            <h4 class="text-2xl font-bold text-gray-900"><?= $tdl ?></h4>
                        </div>
                    </div>
                </div>

            </div>

             <!-- RECENT TABLE -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h5 class="text-lg font-bold text-gray-800">Aduan Terbaru</h5>
                    <a href="tanggapan.php" class="text-sm font-medium text-primary hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Pelapor</th>
                                <th class="px-6 py-4 font-semibold">Lokasi</th>
                                <th class="px-6 py-4 font-semibold">Deskripsi</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                             <?php
                                $q = mysqli_query($koneksi, "SELECT a.*, 
                                        (SELECT Status FROM tanggapan WHERE Id_aduan = a.Id_aduan ORDER BY Id_tanggapan DESC LIMIT 1) AS status_aduan
                                    FROM aduan a 
                                    ORDER BY Id_aduan DESC LIMIT 5");

                                while ($d = mysqli_fetch_assoc($q)) {
                                    $s = $d['status_aduan'] ?? "Menunggu";
                                    $colorClass = "bg-gray-100 text-gray-600";
                                    if ($s == 'diproses') $colorClass = "bg-blue-100 text-blue-700";
                                    if ($s == 'selesai') $colorClass = "bg-green-100 text-green-700";
                                    if ($s == 'data tidak lengkap') $colorClass = "bg-yellow-100 text-yellow-700";
                                ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                            <?= strtoupper(substr($d['Nama_pelapor'], 0, 1)); ?>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($d['Nama_pelapor']); ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($d['Lokasi']); ?></td>
                                <td class="px-6 py-4 max-w-xs">
                                    <p class="text-sm text-gray-500 truncate"><?= htmlspecialchars($d['Deskripsi']); ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass; ?>">
                                        <?= ucfirst($s); ?>
                                    </span>
                                </td>
                              
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>


