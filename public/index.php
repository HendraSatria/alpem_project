<?php require '../config/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALPEM - Layanan Pengaduan Masyarakat</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>    
    <style>
    label:hover img {
  filter: brightness(90%);
}
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C8102E', // Official Red
                        'primary-dark': '#A00D25',
                        'primary-light': '#FFEEEE',
                        neutral: {
                            50: '#F9FAFB',
                            100: '#F3F4F6',
                            800: '#1F2937',
                            900: '#111827',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer utilities {
            .btn-primary {
                @apply bg-primary text-white px-6 py-2.5 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-200 shadow-sm hover:shadow-md;
            }
            .btn-outline {
                @apply border border-primary text-primary px-6 py-2.5 rounded-lg font-medium hover:bg-primary-light transition-colors duration-200;
            }
            .nav-link {
                @apply text-gray-600 hover:text-primary font-medium transition-colors duration-200;
            }
            .nav-link.active {
                @apply text-primary font-bold;
            }
            .card-hover {
                @apply hover:-translate-y-1 hover:shadow-lg transition-all duration-300;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800">

<!-- NAVBAR -->
<nav class="fixed w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-1 flex items-center gap-">
                <img src="../assets/img/Logo1.png" alt="ALPEM Logo" class="h-20 w-auto">
                <div>
                    <h1 class="text-2xl font-bold text-primary tracking-tight">ALPEM</h1>
                    <p class="text-[10px] text-gray-500 font-medium tracking-wide uppercase hidden sm:block">Layanan Pengaduan Masyarakat</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="nav-link active">Beranda</a>
                <a href="statistik.php" class="nav-link">Statistik</a>
                <a href="#alur" class="nav-link">Alur</a>
                <a href="tentang.php" class="nav-link">Tentang</a>
                <div class="h-6 w-px bg-gray-200"></div>
                <!-- Login Buttons -->
                <div class="flex items-center gap-3">
                    <a href="../auth/login.php" class="text-sm font-medium text-gray-600 hover:text-primary">Masuk</a>
                    <a href="../auth/register.php" class="bg-primary text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-primary-dark shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">Daftar</a>
                </div>
            </div>

            <!-- Mobile Menu Button (Placeholder for simple JS toggle if needed) -->
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
<div class="h-20"></div> <!-- Spacer for fixed navbar -->

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-primary via-[#D92C45] to-primary-dark text-white pb-32 pt-16 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('../assets/img/bg2.jpg');"></div>
    <!-- Red overlay with transparency -->
    <div class="absolute inset-0 bg-red-500/30"></div>
    <!-- Decorations -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
        <div class="absolute top-1/2 -right-24 w-64 h-64 bg-white rounded-full mix-blend-overlay blur-2xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-xs font-semibold mb-6 tracking-wider animate-fade-in-up">LAYANAN ASPIRASI PEMERINTAH</span>
        <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight tracking-tight">Layanan Aspirasi dan <br> Pengaduan Online Masyarakat</h2>
        <p class="text-lg md:text-xl text-primary-light max-w-2xl mx-auto font-light leading-relaxed">Sampaikan laporan Anda langsung kepada instansi pemerintah berwenang dengan aman dan terpercaya.</p>
    </div>
</section>

<!-- FORM ADUAN -->
<section class="-mt-24 mb-20 relative z-20 px-4">
    <div class="container mx-auto max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header Form -->
            <div class="flex items-center justify-between border-b pb-4 mb-6">
                <div>
                    <h5 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Sampaikan Laporan Anda
                    </h5>
                    <p class="text-sm text-gray-500 mt-1">Identitas pelapor akan dijaga kerahasiaannya</p>
                </div>
            </div>

            <form action="proses_aduan.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pelapor -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="nama_pelapor">Nama Pelapor</label>
                        <input id="nama_pelapor" type="text" name="nama_pelapor" placeholder="Nama lengkap Anda" required class="w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" />
                    </div>
                    <!-- NIK -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="nik">NIK <span class="text-red-600">*</span></label>
                        <input id="nik" type="text" name="nik" maxlength="16" pattern="[0-9]{16}" inputmode="numeric" required placeholder="Masukkan 16 digit NIK" class="w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" />
                        <p class="text-xs text-gray-500">NIK harus terdiri dari 16 angka</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kontak -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="kontak">No. Handphone <span class="text-red-600">*</span></label>
                        <input id="kontak" type="text" name="kontak" maxlength="13" inputmode="numeric" pattern="^08[0-9]{8,11}$" required placeholder="+62" class="w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" />
                        <p class="text-xs text-gray-500">Gunakan format 08xxxxxxxxxx (10–13 digit)</p>
                    </div>
                    <!-- Lokasi Kejadian -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">Lokasi Kejadian</label>
                        <select id="provinsi" class="form-select w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <select id="kabupaten" class="form-select w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" disabled required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        <select id="kecamatan" class="form-select w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" disabled required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <select name="lokasi" id="desa" class="form-select w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition" disabled required>
                            <option value="">Pilih Desa</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="alamat">Alamat Lengkap Pelapor</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="RT/RW, Dusun, Nomor Rumah" required class="w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition"></textarea>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700" for="deskripsi">Isi Laporan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail kejadian, waktu, dan pelaku jika ada..." required class="w-full rounded-md border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition"></textarea>
                </div>

                <!-- Foto -->
              <div class="space-y-2">
  <label class="block text-sm font-semibold text-gray-700">
    Bukti Foto Lampiran
  </label>

  <div class="flex items-center justify-center w-full">
    <label
      for="dropzone-file"
      class="relative flex flex-col items-center justify-center w-full h-40
             border-2 border-dashed border-gray-300 rounded-lg cursor-pointer
             bg-gray-50 hover:bg-gray-100 transition-colors overflow-hidden"
    >

      <!-- Preview Image -->
      <img id="previewImage"
           class="hidden absolute inset-0 w-full h-full object-cover"
           alt="Preview">

      <!-- Default Content -->
      <div id="placeholderContent"
           class="flex flex-col items-center justify-center pt-5 pb-6 text-center">

        <svg class="w-8 h-8 mb-3 text-gray-400"
             xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 20 16">
          <path stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2"
                d="M13 13h3a3 3 0 0 0 0-6h-.025
                   A5.56 5.56 0 0 0 16 6.5
                   5.5 5.5 0 0 0 5.207 5.021
                   C5.137 5.017 5.071 5 5 5
                   a4 4 0 0 0 0 8h2.167
                   M10 15V6m0 0L8 8m2-2 2 2"/>
        </svg>

        <p class="text-xs text-gray-500">
          <span class="font-semibold">Klik untuk upload</span>
        </p>
        <p class="text-xs text-gray-500">
          PNG, JPG, JPEG (Max 2MB)
        </p>
      </div>

      <input id="dropzone-file"
             type="file"
             name="bukti_foto"
             accept="image/png, image/jpeg"
             class="hidden"
             onchange="previewFile(this)">
    </label>
  </div>
</div>


                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-primary text-white text-base font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-primary-dark hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center gap-2">
                        <span>Kirim Laporan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>


<!-- STATISTIK REAL DARI DATABASE -->
<?php
// Statistik real
$total_aduan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aduan"))['total'];
$aduan_diproses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT a.Id_aduan) as total FROM aduan a JOIN tanggapan t ON a.Id_aduan = t.Id_aduan WHERE t.Status = 'diproses'"))['total'];
$aduan_selesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT a.Id_aduan) as total FROM aduan a JOIN tanggapan t ON a.Id_aduan = t.Id_aduan WHERE t.Status = 'selesai'"))['total'];
$total_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT Kontak) as total FROM aduan"))['total'];
?>
<section id="stats" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-800">Seberapa Efektif Kami?</h3>
            <p class="text-gray-500 mt-2">Data laporan yang telah kami tangani</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Card 1: Total Aduan -->
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-primary text-xl font-bold">L</div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1"><?= $total_aduan ?></h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Laporan Masuk</p>
            </div>
            <!-- Card 2: Diproses -->
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 text-yellow-600 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1"><?= $aduan_diproses ?></h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Sedang Diproses</p>
            </div>
            <!-- Card 3: Selesai -->
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1"><?= $aduan_selesai ?></h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Selesai</p>
            </div>
            <!-- Card 4: User Aktif -->
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 font-bold">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1"><?= $total_user ?></h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Masyarakat Aktif</p>
            </div>
        </div>
    </div>
</section>

<!-- ALUR / LANGKAH-LANGKAH -->
<section id="alur" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="text-3xl font-bold text-gray-800">Alur Pengaduan</h3>
            <p class="text-gray-500 mt-2">Ikuti langkah mudah berikut untuk melaporkan masalah</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Line Connector (Desktop) -->
            <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-gray-200 -z-0 transform translate-y-4"></div>

            <!-- Step 1 -->
            <div class="relative z-10 bg-gray-50 text-center group">
                <div class="w-16 h-16 mx-auto bg-white border-2 border-primary text-primary rounded-full flex items-center justify-center text-xl font-bold shadow-sm group-hover:scale-110 transition-transform duration-300 mb-6">
                    <span>1</span>
                </div>
                <!-- Icons replacements for img src -->
                <div class="mb-4 text-primary">
                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h6 class="text-lg font-bold text-gray-900 mb-2">Tulis Laporan</h6>
                <p class="text-sm text-gray-500 leading-relaxed px-4">Laporkan keluhan atau aspirasi anda dengan jelas dan lengkap.</p>
            </div>

            <!-- Step 2 -->
             <div class="relative z-10 bg-gray-50 text-center group">
                <div class="w-16 h-16 mx-auto bg-white border-2 border-gray-300 text-gray-400 rounded-full flex items-center justify-center text-xl font-bold shadow-sm group-hover:border-primary group-hover:text-primary group-hover:scale-110 transition-all duration-300 mb-6">
                    <span>2</span>
                </div>
                <div class="mb-4 text-gray-400 group-hover:text-primary transition-colors">
                     <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h6 class="text-lg font-bold text-gray-900 mb-2">Verifikasi</h6>
                <p class="text-sm text-gray-500 leading-relaxed px-4">Dalam 3 hari, laporan Anda akan diverifikasi dan diteruskan.</p>
            </div>

            <!-- Step 3 -->
             <div class="relative z-10 bg-gray-50 text-center group">
               <div class="w-16 h-16 mx-auto bg-white border-2 border-gray-300 text-gray-400 rounded-full flex items-center justify-center text-xl font-bold shadow-sm group-hover:border-primary group-hover:text-primary group-hover:scale-110 transition-all duration-300 mb-6">
                    <span>3</span>
                </div>
                 <div class="mb-4 text-gray-400 group-hover:text-primary transition-colors">
                     <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h6 class="text-lg font-bold text-gray-900 mb-2">Tindak Lanjut</h6>
                <p class="text-sm text-gray-500 leading-relaxed px-4">Instansi berwenang akan menindaklanjuti dan menyelesaikan laporan.</p>
            </div>

             <!-- Step 4 -->
            <div class="relative z-10 bg-gray-50 text-center group">
                <div class="w-16 h-16 mx-auto bg-white border-2 border-gray-300 text-gray-400 rounded-full flex items-center justify-center text-xl font-bold shadow-sm group-hover:border-primary group-hover:text-primary group-hover:scale-110 transition-all duration-300 mb-6">
                    <span>4</span>
                </div>
                 <div class="mb-4 text-gray-400 group-hover:text-primary transition-colors">
                     <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h6 class="text-lg font-bold text-gray-900 mb-2">Selesai</h6>
                <p class="text-sm text-gray-500 leading-relaxed px-4">Laporan selesai. Anda bisa memberikan tanggapan balik.</p>
            </div>

        </div>

    </div>

</section>


<!-- FOOTER PROFESIONAL -->
<footer class="bg-primary-dark text-white pt-12 pb-6">
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
<script>
const provinsi = document.getElementById("provinsi");
const kabupaten = document.getElementById("kabupaten");
const kecamatan = document.getElementById("kecamatan");
const desa = document.getElementById("desa");

fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
  .then(res => res.json())
  .then(data => {
    data.forEach(item => {
      provinsi.innerHTML += `<option value="${item.id}">${item.name}</option>`;
    });
  });

// Provinsi → Kabupaten
provinsi.addEventListener("change", function() {
  kabupaten.innerHTML = `<option value="">Pilih Kabupaten/Kota</option>`;
  kecamatan.innerHTML = `<option value="">Pilih Kecamatan</option>`;
  desa.innerHTML = `<option value="">Pilih Desa</option>`;

  kabupaten.disabled = true;
  kecamatan.disabled = true;
  desa.disabled = true;

  if (this.value === "") return;

  fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.value}.json`)
    .then(res => res.json())
    .then(data => {
      data.forEach(item => {
        kabupaten.innerHTML += `<option value="${item.id}">${item.name}</option>`;
      });
      kabupaten.disabled = false;
    });
});

// Kabupaten → Kecamatan
kabupaten.addEventListener("change", function() {
  kecamatan.innerHTML = `<option value="">Pilih Kecamatan</option>`;
  desa.innerHTML = `<option value="">Pilih Desa</option>`;

  kecamatan.disabled = true;
  desa.disabled = true;

  if (this.value === "") return;

  fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.value}.json`)
    .then(res => res.json())
    .then(data => {
      data.forEach(item => {
        kecamatan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
      });
      kecamatan.disabled = false;
    });
});

// Kecamatan → Desa
kecamatan.addEventListener("change", function() {
  desa.innerHTML = `<option value="">Pilih Desa</option>`;
  desa.disabled = true;

  if (this.value === "") return;

  fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.value}.json`)
    .then(res => res.json())
    .then(data => {
      data.forEach(item => {
        desa.innerHTML += `<option value="${item.name}">${item.name}</option>`;
      });
      desa.disabled = false;
    });
});
</script>
<script>
function previewFile(input) {
  const file = input.files[0];
  if (!file) return;

  // Validasi tipe file
  if (!file.type.startsWith("image/")) {
    alert("File harus berupa gambar!");
    input.value = "";
    return;
  }

  // Validasi ukuran (2MB)
  if (file.size > 2 * 1024 * 1024) {
    alert("Ukuran gambar maksimal 2MB!");
    input.value = "";
    return;
  }

  const reader = new FileReader();
  reader.onload = function (e) {
    document.getElementById("previewImage").src = e.target.result;
    document.getElementById("previewImage").classList.remove("hidden");
    document.getElementById("placeholderContent").classList.add("hidden");
  };
  reader.readAsDataURL(file);
}
</script>

</body>
</html>
