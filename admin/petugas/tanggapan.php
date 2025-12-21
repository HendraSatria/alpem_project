<?php
session_start();
require '../../config/koneksi.php';


// ======================================
// 1. Proteksi halaman (Hanya Petugas/Admin yang sudah login)
// ======================================
// Proteksi: hanya petugas
if (!isset($_SESSION['role']) || $_SESSION['role'] != "petugas") {
    header("Location: ../../auth/login.php");
    exit;
}



$nama_petugas = $_SESSION['nama_petugas'];
$role = $_SESSION['role'];

// ======================================
// 2. Query Utama: Ambil semua aduan dan status terbarunya
// ======================================
$query_aduan = "
    SELECT 
        a.Id_aduan, a.Nama_pelapor, a.Kontak, a.Lokasi, a.Deskripsi, a.Bukti_Foto,
        (SELECT Status FROM tanggapan 
         WHERE Id_aduan = a.Id_aduan 
         ORDER BY Id_tanggapan DESC LIMIT 1) AS status_terakhir,
        (SELECT Isi_tanggapan FROM tanggapan 
         WHERE Id_aduan = a.Id_aduan 
         ORDER BY Id_tanggapan DESC LIMIT 1) AS isi_tanggapan,
        (SELECT Tanggal_tanggapan FROM tanggapan 
         WHERE Id_aduan = a.Id_aduan 
         ORDER BY Id_tanggapan DESC LIMIT 1) AS tgl_tanggapan,
        (
            SELECT p.Nama_Petugas 
            FROM tanggapan t 
            JOIN petugas p ON t.Id_petugas = p.Id_Petugas
            WHERE t.Id_aduan = a.Id_aduan 
            ORDER BY t.Id_tanggapan DESC LIMIT 1
        ) AS nama_petugas
    FROM aduan a
    ORDER BY a.Id_aduan DESC
";
$result_aduan = mysqli_query($koneksi, $query_aduan);

// Query untuk data yang akan digunakan di modal (jika perlu)
// Biasanya data ini di-fetch via JavaScript, tapi kita siapkan kerangka PHP-nya.

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Aduan - ALPEM</title>

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
            
            <a href="dashboard_<?= $role ?>.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="tanggapan.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 text-white shadow-sm ring-1 ring-white/10 transition-all">
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
                <h1 class="text-xl font-bold text-gray-800 leading-none">Verifikasi Aduan</h1>
                 <p class="text-xs text-gray-500 mt-1">Halo, <span class="text-primary font-bold"><?= htmlspecialchars($nama_petugas); ?></span> (<?= ucfirst($role) ?>)</p>
            </div>

             <div class="flex items-center gap-4">
               <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold">
                    <?= substr($nama_petugas, 0, 1) ?>
               </div>
            </div>
        </header>

         <!-- MAIN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h5 class="text-lg font-bold text-gray-800">Daftar Aduan Masuk</h5>
                        <p class="text-sm text-gray-500">Tanggapi aduan masyarakat dengan cepat dan tepat.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                             <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold w-10 text-center">No</th>
                                <th class="px-6 py-4 font-semibold">Pelapor</th>
                                <th class="px-6 py-4 font-semibold w-1/4">Deskripsi</th>
                                <th class="px-6 py-4 font-semibold w-1/4">Tanggapan Terakhir</th>
                                <th class="px-6 py-4 font-semibold">Petugas</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                       <tbody class="divide-y divide-gray-100">
                            <?php 
                            $no = 1;
                            if (mysqli_num_rows($result_aduan) > 0) {
                                while ($data = mysqli_fetch_assoc($result_aduan)) {
                                    $status = $data['status_terakhir'] ?? "Belum Ditanggapi";
                                    
                                    $colorClass = "bg-gray-100 text-gray-600";
                                    if ($status == 'diproses') $colorClass = "bg-blue-100 text-blue-700";
                                    if ($status == 'selesai') $colorClass = "bg-green-100 text-green-700";
                                    if ($status == 'data tidak lengkap') $colorClass = "bg-yellow-100 text-yellow-700";
                            ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-center text-gray-500 text-sm"><?= $no++ ?></td>
                                <td class="px-6 py-4">
                                     <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($data['Nama_pelapor']) ?></div>
                                     <div class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($data['Kontak']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                     <div class="text-sm text-gray-600 line-clamp-3"><?= htmlspecialchars($data['Deskripsi']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($data['isi_tanggapan']) { ?>
                                        <div class="text-sm text-gray-600 line-clamp-2"><?= htmlspecialchars($data['isi_tanggapan']) ?></div>
                                        <div class="text-xs text-gray-400 mt-1"><?= date('d/m/Y', strtotime($data['tgl_tanggapan'])) ?></div>
                                    <?php } else { ?>
                                        <span class="text-xs text-gray-400 italic">- Belum ada -</span>
                                    <?php } ?>
                                </td>
                                <td class="px-6 py-4">
                                     <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($data['nama_petugas'] ?? '-') ?></div>
                                </td>
                                <td class="px-6 py-4">
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass ?>">
                                        <?= ucfirst($status) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="openModal(this)"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary text-white text-xs font-medium rounded-md hover:bg-primary-dark transition-colors shadow-sm"
                                        data-id="<?= $data['Id_aduan'] ?>"
                                        data-nama="<?= htmlspecialchars($data['Nama_pelapor']) ?>"
                                        data-lokasi="<?= htmlspecialchars($data['Lokasi']) ?>"
                                        data-kontak="<?= htmlspecialchars($data['Kontak']) ?>"
                                        data-deskripsi="<?= htmlspecialchars($data['Deskripsi']) ?>"
                                        data-foto="<?= htmlspecialchars($data['Bukti_Foto']) ?>"
                                        data-status="<?= $status ?>"
                                    >
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Tanggapi
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                            ?>
                             <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada aduan yang masuk.
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

<!-- MODAL TANGGAPAN -->
<div id="modalBackdrop" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity opacity-0" aria-hidden="true"></div>
<div id="modalTanggapan" class="fixed inset-0 z-50 hidden overflow-y-auto px-4 py-8 flex items-center justify-center transition-all transform scale-95 opacity-0">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto relative overflow-hidden flex flex-col max-h-[90vh]">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-primary text-white flex items-center justify-between shrink-0">
            <h5 class="text-lg font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Tanggapi Aduan
            </h5>
            <button onclick="closeModal()" class="text-white/80 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto">
             <form action="proses_tanggapan.php" method="POST">
                <input type="hidden" name="id_aduan" id="aduan_id">
                <input type="hidden" name="id_petugas" value="<?= $_SESSION['id_petugas'] ?>">

                <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
                    <h6 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                        Detail Pelapor
                        <span id="detail_nama" class="font-normal text-gray-600"></span>
                    </h6>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Kontak</span>
                            <span id="detail_kontak" class="font-medium text-gray-800"></span>
                        </div>
                         <div>
                            <span class="block text-gray-500 text-xs uppercase tracking-wide">Lokasi</span>
                            <span id="detail_lokasi" class="font-medium text-gray-800"></span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-2 space-y-2">
                         <label class="block text-sm font-semibold text-gray-700">Isi Laporan</label>
                         <textarea id="detail_deskripsi" rows="5" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none resize-none" readonly></textarea>
                    </div>
                     <div class="space-y-2">
                         <label class="block text-sm font-semibold text-gray-700">Bukti Foto</label>
                         <div class="border border-gray-200 rounded-lg p-2 bg-gray-50 h-32 flex items-center justify-center overflow-hidden">
                             <img id="detail_foto" src="" alt="Bukti Foto" class="max-w-full max-h-full object-contain rounded hidden">
                             <span id="no_foto" class="text-xs text-gray-400 italic hidden">Tidak ada foto</span>
                         </div>
                    </div>
                </div>

                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                             <label for="status_tanggapan" class="block text-sm font-semibold text-gray-700">Update Status</label>
                             <div class="relative">
                                 <select name="status_tanggapan" id="status_tanggapan" class="w-full appearance-none px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary cursor-pointer" required>
                                    <option value="diproses">Proses (Sedang dikerjakan)</option>
                                    <option value="selesai">Selesai (Masalah teratasi)</option>
                                    <option value="data tidak lengkap">Tolak (Data tidak lengkap)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                             </div>
                        </div>
                        <div class="space-y-2">
                             <!-- Spacer or additional field -->
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="isi_tanggapan" class="block text-sm font-semibold text-gray-700">Isi Tanggapan</label>
                         <textarea name="isi_tanggapan" id="isi_tanggapan" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Jelaskan tindakan yang diambil atau alasan penolakan..." required></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" name="submit_tanggapan" class="px-5 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:bg-primary-dark shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Tanggapan
                    </button>
                </div>

             </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modalTanggapan');
    const backdrop = document.getElementById('modalBackdrop');

    function openModal(button) {
        // Get Data
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const lokasi = button.getAttribute('data-lokasi');
        const kontak = button.getAttribute('data-kontak');
        const deskripsi = button.getAttribute('data-deskripsi');
        const foto = button.getAttribute('data-foto');
        const status = button.getAttribute('data-status');

        // Set Data
        document.getElementById('aduan_id').value = id;
        document.getElementById('detail_nama').textContent = nama;
        document.getElementById('detail_kontak').textContent = kontak;
        document.getElementById('detail_lokasi').textContent = lokasi;
        document.getElementById('detail_deskripsi').value = deskripsi;
        
        // Foto Logic
        const imgElement = document.getElementById('detail_foto');
        const noFoto = document.getElementById('no_foto');
        if (foto && foto.trim() !== '') {
            imgElement.src = '../../assets/img/' + foto;
            imgElement.classList.remove('hidden');
            noFoto.classList.add('hidden');
        } else {
            imgElement.classList.add('hidden');
            noFoto.classList.remove('hidden');
        }

        // Status
        const select = document.getElementById('status_tanggapan');
        if(status) {
             select.value = status.toLowerCase();
        }

        // Show Modal with Animation
        backdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before opacity transition
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('opacity-0', 'scale-95');
        }, 10);
    }

    function closeModal() {
        // Hide Modal with Animation
        backdrop.classList.add('opacity-0');
        modal.classList.add('opacity-0', 'scale-95');
        
        setTimeout(() => {
            backdrop.classList.add('hidden');
            modal.classList.add('hidden');
        }, 300); // Match transition duration
    }
</script>

</body>
</html>