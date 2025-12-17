<?php
session_start();
require '../config/koneksi.php';

// Proteksi halaman: hanya admin

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}
$data_grafik = mysqli_query($koneksi,"
    SELECT MONTH(Tanggal_tanggapan) bulan, COUNT(*) total
    FROM tanggapan
    GROUP BY bulan
");

// Ambil jumlah data
$jml_aduan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aduan"))['total'];
$jml_petugas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM petugas"))['total'];

// Ambil data aduan terbaru 5
$aduan_terbaru = mysqli_query($koneksi, "
    SELECT a.*, 
           t.Status,
           p.Nama_Petugas
    FROM aduan a
    LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
    LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
    ORDER BY a.Id_aduan DESC, t.Id_tanggapan
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ALPEM</title>

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
                <img src="../assets/img/logo.png" alt="ALPEM" class="h-8 w-auto">
                <span class="text-xl font-bold tracking-tight">ALPEM</span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="text-xs font-semibold text-primary-light uppercase tracking-wider mb-2">Menu Admin</p>
            
            <a href="dashboard_admin.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white shadow-sm ring-1 ring-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="kelola_petugas.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Kelola Petugas</span>
            </a>

            <a href="unduh_laporan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="font-medium">Unduh Laporan</span>
            </a>
        </nav>

        <div class="p-4 border-t border-primary-dark">
            <a href="../auth/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-red-700 hover:text-white transition-all">
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
                <h1 class="text-xl font-bold text-gray-800 leading-none">Dashboard Admin</h1>
                 <p class="text-xs text-gray-500 mt-1">Selamat datang kembali, <span class="text-primary font-bold"><?= htmlspecialchars($_SESSION['nama_petugas']); ?></span> (Admin)</p>
            </div>

             <div class="flex items-center gap-4">
               <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold">
                    <?= substr($_SESSION['nama_petugas'], 0, 1) ?>
               </div>
            </div>
        </header>

         <!-- MAIN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">

             <!-- STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute right-0 top-0 p-4 opacity-10 scale-150 transform group-hover:scale-125 transition-transform">
                         <svg class="w-32 h-32 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>
                    </div>
                    <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary text-2xl font-bold relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Aduan Masuk</p>
                        <h4 class="text-3xl font-bold text-gray-900"><?= $jml_aduan; ?></h4>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 relative overflow-hidden group hover:shadow-md transition-all">
                     <div class="absolute right-0 top-0 p-4 opacity-10 scale-150 transform group-hover:scale-125 transition-transform">
                          <svg class="w-32 h-32 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-2xl font-bold relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Jumlah Petugas</p>
                        <h4 class="text-3xl font-bold text-gray-900"><?= $jml_petugas; ?></h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                 <!-- CHART -->
                 <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h5 class="text-lg font-bold text-gray-800 mb-4">Statistik Bulanan</h5>
                    <div class="relative h-64 w-full">
                         <canvas id="grafikBulanan"></canvas>
                    </div>
                </div>

                <!-- RECENT ACTIVITY (Simple List) -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
                    <h5 class="text-lg font-bold text-gray-800 mb-4">Aktifitas Terbaru</h5>
                    <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                        <!-- We can reuse $aduan_terbaru here for a quick list -->
                         <?php 
                            mysqli_data_seek($aduan_terbaru, 0); // Reset pointer
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($aduan_terbaru)) {
                                if($count >= 4) break; 
                                $count++;
                                $s_code = $row['Status'] ?? 'pending'; // simplified status check
                         ?>
                        <div class="flex gap-3 items-start p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-50">
                            <div class="w-2 h-2 mt-2 rounded-full bg-primary shrink-0"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 line-clamp-1"><?= htmlspecialchars($row['Nama_pelapor']) ?></p>
                                <p class="text-xs text-gray-500">melapor: <span class="italic">"<?= substr(htmlspecialchars($row['Deskripsi']), 0, 30) ?>..."</span></p>
                                <span class="text-[10px] text-gray-400 mt-1 block"><?= date('d M Y', strtotime($row['Tanggal_aduan'])) ?></span>
                            </div>
                        </div>
                        <?php } ?>
                         <?php if($count == 0) { echo "<p class='text-sm text-gray-500 italic'>Belum ada aktifitas.</p>"; } ?>
                    </div>
                     <a href="unduh_laporan.php" class="mt-4 text-sm text-primary font-medium hover:underline text-center block">Lihat Laporan Lengkap &rarr;</a>
                </div>
            </div>


             <!-- RECENT COMPLAINTS TABLE -->
             <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h5 class="text-lg font-bold text-gray-800">Daftar Aduan Terbaru</h5>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No</th>
                                <th class="px-6 py-4 font-semibold">Pelapor</th>
                                <th class="px-6 py-4 font-semibold">Lokasi</th>
                                <th class="px-6 py-4 font-semibold w-1/4">Deskripsi</th>
                                <th class="px-6 py-4 font-semibold">Petugas Handler</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                         <tbody class="divide-y divide-gray-100">
                             <?php
                            mysqli_data_seek($aduan_terbaru, 0); // Reset pointer again
                            $no = 1;
                            if (mysqli_num_rows($aduan_terbaru) > 0) {
                                while ($row = mysqli_fetch_assoc($aduan_terbaru)) {
                                    $status = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Status FROM tanggapan WHERE Id_aduan=".$row['Id_aduan']." ORDER BY Id_tanggapan DESC LIMIT 1"))['Status'] ?? "Menunggu Tanggapan";

                                    $colorClass = "bg-gray-100 text-gray-600";
                                    if ($status == "diproses") $colorClass = "bg-blue-100 text-blue-700";
                                    if ($status == "data tidak lengkap") $colorClass = "bg-yellow-100 text-yellow-700";
                                    if ($status == "selesai") $colorClass = "bg-green-100 text-green-700";
                            ?>
                             <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500"><?= $no++; ?></td>
                                <td class="px-6 py-4">
                                     <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['Nama_pelapor']); ?></div>
                                     <div class="text-xs text-gray-500"><?= htmlspecialchars($row['Kontak']); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($row['Lokasi']); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 line-clamp-2"><?= nl2br(htmlspecialchars($row['Deskripsi'])); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                     <?= $row['Nama_Petugas'] ?? '<span class="text-gray-400 italic">Belum assign</span>'; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass; ?>">
                                        <?= ucfirst($status); ?>
                                    </span>
                                </td>
                            </tr>
                              <?php } 
                            } else { ?>
                             <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada aduan masuk.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikBulanan');

// Tailwind colors
const primaryColor = '#C8102E';

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php 
            mysqli_data_seek($data_grafik, 0);
            while($g = mysqli_fetch_assoc($data_grafik)) {
                echo "'Bulan ".$g['bulan']."',";
            } ?>
        ],
        datasets: [{
            label: 'Jumlah Aduan',
            data: [
                <?php 
                mysqli_data_seek($data_grafik,0);
                while($g = mysqli_fetch_assoc($data_grafik)) {
                    echo $g['total'].",";
                } ?>
            ],
            backgroundColor: primaryColor,
            borderRadius: 6,
            barThickness: 40,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f6'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>

</body>
</html>
