<?php require '../config/koneksi.php'; 

// Fetch Data for Summary Cards
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aduan");
$total = mysqli_fetch_assoc($q_total)['total'];

$q_diproses = mysqli_query($koneksi, "SELECT COUNT(DISTINCT a.Id_aduan) as total FROM aduan a JOIN tanggapan t ON a.Id_aduan = t.Id_aduan WHERE t.Status = 'diproses'");
$diproses = mysqli_fetch_assoc($q_diproses)['total'];

$q_selesai = mysqli_query($koneksi, "SELECT COUNT(DISTINCT a.Id_aduan) as total FROM aduan a JOIN tanggapan t ON a.Id_aduan = t.Id_aduan WHERE t.Status = 'selesai'");
$selesai = mysqli_fetch_assoc($q_selesai)['total'];

// Assuming 'pending' is total minus (diproses + selesai), or queries where not in tanggapan
// To be safe and simple, let's treat "Belum Diproses" as Total - (Diproses + Selesai)
// Note: This logic assumes an aduan is either pending, diproses, or selesai.
$pending = $total - ($diproses + $selesai);
if ($pending < 0) $pending = 0;

// Fetch Data for Location Chart (Top 5)
$q_loc = mysqli_query($koneksi, "SELECT Lokasi, COUNT(*) as jlh FROM aduan GROUP BY Lokasi ORDER BY jlh DESC LIMIT 5");
$loc_labels = [];
$loc_data = [];
while($row = mysqli_fetch_assoc($q_loc)) {
    $loc_labels[] = $row['Lokasi'];
    $loc_data[] = $row['jlh'];
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik - ALPEM</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C8102E', 
                        'primary-dark': '#A00D25',
                        'primary-light': '#FFEEEE',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="../assets/img/logo1.png" alt="ALPEM Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-primary tracking-tight">ALPEM</h1>
                        <p class="text-[10px] text-gray-500 font-medium tracking-wide uppercase hidden sm:block">Layanan Pengaduan Masyarakat</p>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Beranda</a>
                    <a href="statistik.php" class="nav-link text-primary font-bold transition-colors">Statistik</a>
                    <a href="index.php#alur" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Alur</a>
                    <a href="tentang.php" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Tentang</a>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <!-- Login Buttons -->
                    <div class="flex items-center gap-3">
                        <a href="../auth/login.php" class="text-sm font-medium text-gray-600 hover:text-primary">Masuk</a>
                        <a href="../auth/register.php" class="bg-primary text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-primary-dark shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">Daftar</a>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-primary focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <div class="h-20"></div>

    <!-- HEADER / HERO -->
    <header class="bg-primary text-white py-16 text-center shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('../assets/img/bg2.jpg')] bg-cover bg-center opacity-20"></div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-4xl font-bold mb-4">Statistik Pengaduan</h1>
            <p class="text-primary-light text-lg max-w-2xl mx-auto">
                Transparansi data pengaduan yang masuk, diproses, dan diselesaikan oleh instansi terkait.
            </p>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-grow container mx-auto px-4 py-12">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h4 class="text-3xl font-bold text-gray-800"><?= $total ?></h4>
                    <span class="text-sm text-gray-500 font-medium">Total Laporan</span>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>
            <!-- Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h4 class="text-3xl font-bold text-gray-800"><?= $pending ?></h4>
                    <span class="text-sm text-gray-500 font-medium">Belum Diproses</span>
                </div>
                <div class="w-12 h-12 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Diproses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h4 class="text-3xl font-bold text-gray-800"><?= $diproses ?></h4>
                    <span class="text-sm text-gray-500 font-medium">Sedang Diproses</span>
                </div>
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Selesai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h4 class="text-3xl font-bold text-gray-800"><?= $selesai ?></h4>
                    <span class="text-sm text-gray-500 font-medium">Selesai</span>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Pie Chart: Status Distribution -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Distribusi Status Laporan</h3>
                <div class="relative h-64 w-full">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart: Lokasi Terbanyak -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Top 5 Lokasi Pengaduan</h3>
                <div class="relative h-64 w-full">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-primary-dark text-white pt-12 pb-6 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 md:gap-0">
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <div class="flex items-center gap-2 mb-2 justify-center md:justify-start">
                        <img src="../assets/img/logo1.png" alt="ALPEM Logo" class="h-8 w-auto">
                        <span class="text-2xl font-bold tracking-tight">ALPEM</span>
                    </div>
                    <p class="text-white/70 text-sm max-w-xs">Aplikasi Layanan Pengaduan Masyarakat berbasis web untuk transparansi dan pelayanan publik yang lebih baik.</p>
                </div>
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <h5 class="font-semibold mb-2 text-white">Kontak</h5>
                    <p class="text-white/80 text-sm">Email: <a href="mailto:info@alpem.com" class="underline hover:text-primary-light">info@alpem.com</a></p>
                    <p class="text-white/80 text-sm">Telepon: <a href="tel:02112345678" class="underline hover:text-primary-light">021-12345678</a></p>
                </div>
                <div class="text-center md:text-left">
                    <h5 class="font-semibold mb-2 text-white">Tautan</h5>
                    <ul class="space-y-1">
                        <li><a href="tentang.php" class="hover:text-primary-light transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary-light transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-primary-light transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h5 class="font-semibold mb-2 text-white">Ikuti Kami</h5>
                    <div class="flex gap-4 justify-center md:justify-start">
                        <a href="#" class="hover:text-primary-light" title="Instagram"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5a5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5zm6 1.25a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"/></svg></a>
                        <a href="#" class="hover:text-primary-light" title="Facebook"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 2.1c1.1 0 2 .9 2 2v15.8c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V4.1c0-1.1.9-2 2-2h10zm-2.5 4.4h-1.2c-.3 0-.5.2-.5.5v1.2h1.7l-.2 1.7h-1.5v4.3h-1.8v-4.3H9.5V8.2h1.2V7.1c0-1.1.9-2 2-2h1.8v1.7z"/></svg></a>
                        <a href="#" class="hover:text-primary-light" title="Twitter"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.59-2.47.7a4.3 4.3 0 0 0 1.88-2.37a8.59 8.59 0 0 1-2.72 1.04a4.28 4.28 0 0 0-7.29 3.9A12.13 12.13 0 0 1 3.1 4.9a4.28 4.28 0 0 0 1.32 5.71a4.23 4.23 0 0 1-1.94-.54v.05a4.28 4.28 0 0 0 3.43 4.19a4.3 4.3 0 0 1-1.93.07a4.29 4.29 0 0 0 4 2.98A8.6 8.6 0 0 1 2 19.54a12.13 12.13 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2c0-.19 0-.38-.01-.57A8.7 8.7 0 0 0 24 4.59a8.5 8.5 0 0 1-2.54.7z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-white/50">
                &copy; <?= date("Y"); ?> ALPEM. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>

    <!-- CHART SCRIPTS -->
    <script>
        // Data for Status Chart
        const statusData = {
            labels: ['Belum Diproses', 'Sedang Diproses', 'Selesai'],
            datasets: [{
                data: [<?= $pending ?>, <?= $diproses ?>, <?= $selesai ?>],
                backgroundColor: ['#E5E7EB', '#FBBF24', '#10B981'],
                hoverBackgroundColor: ['#D1D5DB', '#F59E0B', '#059669'],
                borderWidth: 0
            }]
        };

        const statusConfig = {
            type: 'doughnut',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter', size: 12 },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        };

        new Chart(document.getElementById('statusChart'), statusConfig);

        // Data for Location Chart
        const locationData = {
            labels: <?= json_encode($loc_labels) ?>,
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: <?= json_encode($loc_data) ?>,
                backgroundColor: '#C8102E',
                borderRadius: 4,
            }]
        };

        const locationConfig = {
            type: 'bar',
            data: locationData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#F3F4F6' },
                        ticks: { stepSize: 1, font: { family: 'Inter' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter' } }
                    }
                }
            }
        };

        new Chart(document.getElementById('locationChart'), locationConfig);
    </script>

</body>
</html>
