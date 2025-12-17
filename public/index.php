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
            <div class="flex-shrink-0 flex items-center gap-3">
                <img src="../assets/img/logo.png" alt="ALPEM Logo" class="h-10 w-auto">
                <div>
                    <h1 class="text-2xl font-bold text-primary tracking-tight">ALPEM</h1>
                    <p class="text-[10px] text-gray-500 font-medium tracking-wide uppercase hidden sm:block">Layanan Pengaduan Masyarakat</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="nav-link active">Beranda</a>
                <a href="#stats" class="nav-link">Statistik</a>
                <a href="#alur" class="nav-link">Alur</a>
                <a href="#tentang" class="nav-link">Tentang</a>
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
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transform transition-all hover:shadow-2xl">
            <!-- Header Form -->
            <div class="bg-white p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h5 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Sampaikan Laporan Anda
                    </h5>
                    <p class="text-sm text-gray-500 mt-1">Identitas pelapor akan dijaga kerahasiaannya</p>
                </div>
            </div>

            <div class="p-8">
                <form action="proses_aduan.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Nama Pelapor</label>
                            <input type="text" name="nama_pelapor" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Nama lengkap Anda" required>
                        </div>
                        <!-- NIK -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">NIK (Opsional)</label>
                            <input type="number" name="nik" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="16 digit NIK">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kontak -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">No. Handphone</label>
                            <input type="text" name="kontak" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Contoh: 08123456789" required>
                        </div>
                        <!-- Lokasi -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Nama Jalan, Desa, Kecamatan">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                        <input type="text" name="alamat" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Alamat domisili Anda">
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Isi Laporan</label>
                        <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm outline-none" placeholder="Jelaskan detail kejadian, waktu, dan pelaku jika ada..." required></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Bukti Foto Lampiran</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="text-xs text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="bukti_foto" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button class="bg-primary text-white text-base font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-primary-dark hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center gap-2">
                            <span>Kirim Laporan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>


<!-- STATISTIK (Dummy for Visual) -->
<section id="stats" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold text-gray-800">Seberapa Efektif Kami?</h3>
            <p class="text-gray-500 mt-2">Data laporan yang telah kami tangani</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Card 1 -->
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-primary text-xl font-bold">L</div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1">100+</h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Laporan Masuk</p>
            </div>
            <!-- Card 2 -->
             <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 text-yellow-600 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1">45</h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Sedang Diproses</p>
            </div>
             <!-- Card 3 -->
             <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1">50+</h4>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Selesai</p>
            </div>
             <!-- Card 4 -->
             <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 font-bold">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h4 class="text-4xl font-bold text-gray-800 mb-1">10k</h4>
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


<!-- ========================================================= -->
<!-- FOOTER -->
<!-- ========================================================= -->
<!-- FOOTER -->
<footer class="bg-primary-dark text-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h4 class="text-2xl font-bold mb-2">ALPEM</h4>
                <p class="text-white/70 text-sm">Aplikasi Layanan Pengaduan Masyarakat.</p>
            </div>
            
            <div class="flex gap-6 text-sm text-white/80">
                <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-white transition-colors">Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
        
        <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-white/50">
            &copy; <?= date("Y"); ?> ALPEM. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </div>
</footer>

</body>
</html>
