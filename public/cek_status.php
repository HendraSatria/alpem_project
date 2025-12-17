<?php
require '../config/koneksi.php';

$data = null;

if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_POST['keyword']);

    $query = "
        SELECT a.Id_aduan, a.Nama_pelapor, a.Kontak,
               t.Status, t.Tanggal_tanggapan, t.Isi_tanggapan,
               p.Nama_Petugas
        FROM aduan a
        LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
        LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
        WHERE a.Id_aduan = '$keyword'
           OR a.Kontak = '$keyword'
        ORDER BY t.Id_tanggapan DESC
        LIMIT 1
    ";

    $data = mysqli_query($koneksi, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Aduan - ALPEM</title>

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
<body class="bg-gray-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

<!-- NAV BAR -->
<nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm transition-all duration-300">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">
        <!-- Logo -->
        <a href="index.php" class="flex items-center gap-3">
             <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                A
            </div>
            <span class="text-xl font-bold tracking-tight text-gray-900">ALPEM</span>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8">
            <a href="index.php" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Beranda</a>
            <a href="data_aduan.php" class="text-sm font-medium text-gray-600 hover:text-primary transition-colors">Data Aduan</a>
            <a href="cek_status.php" class="text-sm font-bold text-primary">Cek Status</a>
        </div>

        <!-- Mobile Menu Button (Simple) -->
        <div class="md:hidden">
             <button class="text-gray-600 hover:text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="pt-32 pb-40 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
     <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080?pattern')] opacity-10 mix-blend-overlay bg-cover bg-center"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
    
    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Lacak Pengaduan Anda</h1>
        <p class="text-lg text-gray-300 max-w-2xl mx-auto mb-10">
            Masukkan Nomor ID Aduan atau Nomor Kontak yang Anda gunakan saat melapor untuk melihat progres tindak lanjut.
        </p>
    </div>
</section>

<!-- MAIN CONTENT -->
<div class="container mx-auto px-6 -mt-32 pb-20 relative z-20 flex-grow">
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 max-w-3xl mx-auto border border-gray-100">

        <!-- SEARCH FORM -->
        <form method="POST" class="flex flex-col md:flex-row gap-4 mb-10">
            <div class="flex-grow">
                 <input type="text" name="keyword" class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-shadow text-gray-900" 
                        placeholder="Contoh: 12 atau 08123456789" required>
            </div>
            <button type="submit" name="cari" class="px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all transform hover:-translate-y-0.5 shadow-lg shadow-primary/30 whitespace-nowrap">
                Cek Status
            </button>
        </form>

        <!-- RESULT AREA -->
        <?php if ($data && mysqli_num_rows($data) > 0) {
            $r = mysqli_fetch_assoc($data);

            $badgeColor = "bg-gray-100 text-gray-600 border-gray-200";
            if ($r['Status'] == 'diproses') $badgeColor = "bg-blue-100 text-blue-700 border-blue-200";
            if ($r['Status'] == 'data tidak lengkap') $badgeColor = "bg-yellow-100 text-yellow-700 border-yellow-200";
            if ($r['Status'] == 'selesai') $badgeColor = "bg-green-100 text-green-700 border-green-200";
        ?>

        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 md:p-8 animate-fade-in-up">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b border-gray-200">
                <div>
                     <span class="text-sm font-semibold text-gray-500 uppercase tracking-wider block mb-1">ID Aduan</span>
                    <h3 class="text-3xl font-bold text-gray-900">#<?= $r['Id_aduan']; ?></h3>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border <?= $badgeColor ?>">
                        <?= strtoupper($r['Status'] ?? 'BARU'); ?>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Tanggal Terakhir Update</span>
                        <p class="text-sm font-medium text-gray-900">
                             <?= $r['Tanggal_tanggapan'] ? date('d F Y', strtotime($r['Tanggal_tanggapan'])) : '-'; ?>
                        </p>
                    </div>
                     <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-1">Petugas Menangani</span>
                        <p class="text-sm font-medium text-gray-900">
                             <?= $r['Nama_Petugas'] ?? '-'; ?>
                        </p>
                    </div>
                </div>

                <!-- Right Column (Response) -->
                <div class="md:col-span-2 mt-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block mb-2">Isi Tanggapan</span>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 text-sm text-gray-700 leading-relaxed">
                        <?= nl2br(htmlspecialchars($r['Isi_tanggapan'] ?? 'Belum ada tanggapan dari petugas.')); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } elseif (isset($_POST['cari'])) { ?>

             <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-center gap-4 animate-fade-in-up">
                <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-bold">Data Tidak Ditemukan</h4>
                    <p class="text-sm mt-1">Nomor aduan atau kontak yang Anda masukkan tidak terdaftar dalam sistem.</p>
                </div>
            </div>

        <?php } else { ?>
            <!-- Empty State / Placeholder -->
             <div class="text-center py-10 opacity-50">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-gray-500">Silahkan cari aduan Anda.</p>
            </div>
        <?php } ?>

    </div>
</div>

<footer class="bg-gray-900 text-white py-8 mt-auto">
    <div class="container mx-auto px-6 text-center">
        <p class="text-gray-400 text-sm text-center">&copy; <?= date("Y"); ?> ALPEM. Aplikasi Layanan Pengaduan Masyarakat.</p>
    </div>
</footer>

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
