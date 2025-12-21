<?php 
require '../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Aduan - ALPEM</title>

    <!-- Google Fonts: Inter -->
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

<!-- NAVBAR -->
<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <img src="../assets/img/Logo1.png" alt="Logo" class="h-16 w-auto">
                <a href="index.php" class="text-xl font-bold text-primary tracking-tight">ALPEM</a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="index.php" class="text-gray-600 hover:text-primary font-medium text-sm transition-colors">Beranda</a>
                <a href="data_aduan.php" class="text-primary font-bold text-sm">Data Aduan</a>
                <a href="../auth/login.php" class="border border-primary text-primary px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary hover:text-white transition-all">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="bg-primary text-white py-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-dark to-primary opacity-50"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h2 class="text-3xl font-bold mb-2">Pantau Aduan Masyarakat</h2>
        <p class="text-white/80 max-w-xl mx-auto">Transparansi layanan publik untuk Indonesia yang lebih baik.</p>
    </div>
</section>

<!-- CONTENT -->
<main class="flex-grow container mx-auto px-4 -mt-8 relative z-20 pb-12">
    
    <!-- Search Box -->
    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 max-w-4xl mx-auto mb-8">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" id="searchInput" 
                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary sm:text-sm transition-all" 
                placeholder="Cari berdasarkan nama, lokasi, atau isi aduan...">
        </div>
    </div>

    <!-- Cards Grid -->
    <div id="aduanContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $query = "
            SELECT a.*, 
            (SELECT Status FROM tanggapan 
                WHERE Id_aduan = a.Id_aduan 
                ORDER BY Id_tanggapan DESC LIMIT 1) AS status_aduan,
            (SELECT Tanggal_tanggapan FROM tanggapan 
                WHERE Id_aduan = a.Id_aduan 
                ORDER BY Id_tanggapan DESC LIMIT 1) AS tgl_tanggapan,
            (SELECT Isi_tanggapan FROM tanggapan 
                WHERE Id_aduan = a.Id_aduan 
                ORDER BY Id_tanggapan DESC LIMIT 1) AS isi_tanggapan,
            (
                SELECT p.Nama_Petugas 
                FROM tanggapan t 
                JOIN petugas p ON t.Id_petugas = p.Id_Petugas
                WHERE t.Id_aduan = a.Id_aduan 
                ORDER BY t.Id_tanggapan DESC LIMIT 1
            ) AS nama_petugas
            FROM aduan a ORDER BY a.Id_aduan DESC
        ";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $status = $row['status_aduan'] ?? "Menunggu";
                $colorClass = "bg-gray-100 text-gray-600"; // Default
                if ($status == "diproses") $colorClass = "bg-blue-100 text-blue-700";
                if ($status == "data tidak lengkap") $colorClass = "bg-yellow-100 text-yellow-700";
                if ($status == "selesai") $colorClass = "bg-green-100 text-green-700";

                $search_data = strtolower(htmlspecialchars($row['Nama_pelapor'] . " " . $row['Kontak'] . " " . $row['Lokasi'] . " " . $row['Deskripsi']));
        ?>
        
        <!-- Card Item -->
        <article class="aduan-item bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col" data-search="<?= $search_data; ?>">
            <div class="p-5 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm">
                            <?= strtoupper(substr($row['Nama_pelapor'], 0, 1)); ?>
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($row['Nama_pelapor']); ?></h5>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <?= htmlspecialchars($row['Lokasi']); ?>
                            </p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $colorClass; ?>">
                        <?= ucfirst($status); ?>
                    </span>
                </div>

                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                    <?= nl2br(htmlspecialchars($row['Deskripsi'])); ?>
                </p>

                <?php if ($row['Bukti_Foto']) { ?>
                    <div class="mt-3 mb-4">
                        <img src="../assets/img/<?= $row['Bukti_Foto']; ?>" class="w-full h-48 object-cover rounded-lg" alt="Bukti Foto">
                    </div>
                <?php } ?>

                <?php if ($row['isi_tanggapan']) { ?>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-2">
                             <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">
                                Tanggapan
                            </p>
                            <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded text-gray-500">
                                <?= date('d M Y', strtotime($row['tgl_tanggapan'])); ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg mb-2">
                            <?= nl2br(htmlspecialchars($row['isi_tanggapan'])); ?>
                        </p>
                         <p class="text-xs text-gray-400 text-right italic">
                            Oleh: <?= htmlspecialchars($row['nama_petugas'] ?? 'Admin'); ?>
                        </p>
                    </div>
                <?php } ?>
            </div>
            
           
        </article>

        <?php 
            } 
        } else { 
        ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <p>Belum ada aduan yang masuk.</p>
            </div>
        <?php } ?>
    </div>

    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Tidak ada hasil ditemukan</h3>
        <p class="text-gray-500">Coba kata kunci lain.</p>
    </div>

</main>

<footer class="bg-gray-900 text-white py-8 mt-auto">
    <div class="container mx-auto text-center">
        <p class="text-sm opacity-70">&copy; <?= date("Y"); ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
    </div>
</footer>

<script>
    const searchInput = document.getElementById("searchInput");
    const container = document.getElementById("aduanContainer");
    const noResults = document.getElementById("noResults");
    const items = document.querySelectorAll(".aduan-item");

    searchInput.addEventListener("keyup", function(e) {
        const term = e.target.value.toLowerCase();
        let hasResults = false;

        items.forEach(item => {
            const data = item.getAttribute('data-search');
            if(data.includes(term)) {
                item.style.display = 'flex'; // Restore flex display
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        if(hasResults) {
            noResults.classList.add('hidden');
        } else {
            noResults.classList.remove('hidden');
        }
    });
</script>

</body>
</html>