<?php
session_start();
require '../config/koneksi.php';

// Proteksi halaman: hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}

// Filter
$status = $_GET['status'] ?? '';
$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

// Query dasar
$query = "
    SELECT a.*, 
           t.Status, 
           p.Nama_Petugas
    FROM aduan a
    LEFT JOIN tanggapan t ON a.Id_aduan = t.Id_aduan
    LEFT JOIN petugas p ON t.Id_petugas = p.Id_Petugas
    WHERE 1
";

// Filter status
if ($status != '') {
    $query .= " AND t.Status = '$status'";
}

// Filter tanggal
if ($tgl_awal != '' && $tgl_akhir != '') {
    $query .= " AND DATE(t.Tanggal_tanggapan) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query .= " ORDER BY a.Id_aduan DESC";

$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unduh Laporan - Admin ALPEM</title>

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
            
            <a href="dashboard_admin.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="kelola_petugas.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Kelola Petugas</span>
            </a>

            <a href="unduh_laporan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white shadow-sm ring-1 ring-white/10 transition-all">
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
                <h1 class="text-xl font-bold text-gray-800 leading-none">Unduh Laporan</h1>
                 <p class="text-xs text-gray-500 mt-1">Halo, <span class="text-primary font-bold"><?= htmlspecialchars($_SESSION['nama_petugas']); ?></span> (Admin)</p>
            </div>

             <div class="flex items-center gap-4">
               <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold">
                    <?= substr($_SESSION['nama_petugas'], 0, 1) ?>
               </div>
            </div>
        </header>

         <!-- MAIN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h5 class="text-md font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Laporan
                    </h5>
                     <!-- FILTER FORM -->
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Aduan</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="baru" <?= $status=='baru'?'selected':''; ?>>Baru</option>
                                    <option value="diproses" <?= $status=='diproses'?'selected':''; ?>>Diproses</option>
                                    <option value="data tidak lengkap" <?= $status=='data tidak lengkap'?'selected':''; ?>>Data Tidak Lengkap</option>
                                    <option value="selesai" <?= $status=='selesai'?'selected':''; ?>>Selesai</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="tgl_awal" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" value="<?= $tgl_awal; ?>">
                        </div>

                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="tgl_akhir" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" value="<?= $tgl_akhir; ?>">
                        </div>

                         <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary-dark shadow hover:shadow-md transition-all flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                 <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                     <div>
                        <h5 class="text-lg font-bold text-gray-800">Hasil Laporan</h5>
                        <p class="text-sm text-gray-500">Menampilkan data berdasarkan filter di atas.</p>
                     </div>
                     <?php if(mysqli_num_rows($data) > 0) { ?>
                     <div>
                        <a href="cetak_laporan.php?status=<?= $status; ?>&tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>" target="_blank" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 shadow-sm transition-all flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                             Unduh / Cetak PDF
                        </a>
                     </div>
                     <?php } ?>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                             <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold w-16 text-center">No</th>
                                <th class="px-6 py-4 font-semibold">Pelapor</th>
                                <th class="px-6 py-4 font-semibold">Lokasi</th>
                                <th class="px-6 py-4 font-semibold">Petugas Handler</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Tanggal Tanggapan</th>
                            </tr>
                        </thead>
                       <tbody class="divide-y divide-gray-100">
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($data) > 0) {
                            while ($row = mysqli_fetch_assoc($data)) {
                                $s_val = $row['Status'] ?? 'baru';
                                $colorClass = "bg-gray-100 text-gray-600";
                                if ($s_val == "diproses") $colorClass = "bg-blue-100 text-blue-700";
                                if ($s_val == "data tidak lengkap") $colorClass = "bg-yellow-100 text-yellow-700";
                                if ($s_val == "selesai") $colorClass = "bg-green-100 text-green-700";
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 text-sm"><?= $no++ ?></td>
                                <td class="px-6 py-4">
                                     <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['Nama_pelapor']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($row['Lokasi']) ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= $row['Nama_Petugas'] ?? '<span class="text-gray-400 italic">Belum ada</span>'; ?></td>
                                <td class="px-6 py-4">
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $colorClass ?>">
                                        <?= strtoupper($s_val) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-500">
                                    <?= $row['Tanggal_tanggapan'] ? date('d M Y', strtotime($row['Tanggal_tanggapan'])) : '-'; ?>
                                </td>
                            </tr>
                        <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                    Tidak ada data yang ditemukan untuk filter ini.
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
