<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang ALPEM - Layanan Aspirasi dan Pengaduan Online Masyarakat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

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
                <a href="index.php" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Beranda</a>
                <a href="statistik.php" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Statistik</a>
                <a href="index.php#alur" class="nav-link text-gray-600 hover:text-primary font-medium transition-colors">Alur</a>
                <a href="tentang.php" class="nav-link text-primary font-bold transition-colors">Tentang</a>
                <div class="h-6 w-px bg-gray-200"></div>
                <!-- Login Buttons -->
                <div class="flex items-center gap-3">
                    <a href="../auth/login.php" class="text-sm font-medium text-gray-600 hover:text-primary">Masuk</a>
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

<!-- HERO HEADER -->
<header class="bg-primary text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('../assets/img/bg2.jpg')] bg-cover bg-center opacity-20"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang ALPEM</h1>
        <p class="text-xl md:text-2xl font-light text-primary-light italic mb-8">"Suara Anda, Perubahan Kita"</p>
        <span class="inline-block w-24 h-1 bg-white rounded-full"></span>
    </div>
</header>

<main class="flex-grow">

    <!-- APA ITU ALPEM -->
    <section class="py-16 container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Apa itu ALPEM?</h2>
            <p class="text-gray-600 text-lg leading-relaxed">
                ALPEM (Aplikasi Layanan Pengaduan Masyarakat) adalah platform digital terintegrasi yang dirancang untuk menjembatani komunikasi antara masyarakat dan pemerintah. Kami hadir sebagai solusi modern untuk menyampaikan aspirasi, keluhan, dan permintaan informasi secara <strong>cepat, mudah, dan transparan</strong>.
            </p>
            <p class="text-gray-600 text-lg leading-relaxed mt-4">
                Dengan ALPEM, setiap laporan Anda dikelola secara profesional dan akuntabel, memastikan setiap suara didengar dan setiap masalah mendapatkan solusi yang tepat.
            </p>
        </div>
    </section>

    <!-- FITUR UTAMA -->
    <section class="py-16 bg-white relative">
        <div class="absolute inset-0 bg-gray-50 transform -skew-y-3 origin-top-left z-0 h-full"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Fitur Unggulan</h2>
                <p class="text-gray-500 mt-2">Didesain untuk kemudahan dan kenyamanan Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-red-100 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Privasi Terjamin</h3>
                    <p class="text-gray-600 text-center">Identitas pelapor dapat dirahasiakan (Anonim) untuk menjamin keamanan dan kenyamanan saat melapor.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-red-100 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Pelacakan Real-time</h3>
                    <p class="text-gray-600 text-center">Pantau status laporan Anda secara langsung mulai dari verifikasi hingga penyelesaian oleh petugas.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-primary hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-14 h-14 bg-red-100 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Mudah Diakses</h3>
                    <p class="text-gray-600 text-center">Akses layanan kapan saja dan di mana saja melalui website yang responsif dan user-friendly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- VISI & MISI -->
    <section class="py-16 container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto items-center">
            <div>
                <img src="../assets/img/visimisi.png" alt="Vision Mission" class="rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
            </div>
            <div>
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-primary mb-3">Visi</h3>
                    <p class="text-gray-700 leading-relaxed">Menjadi jembatan utama yang terpercaya antara masyarakat dan pemerintah dalam mewujudkan pelayanan publik yang responsif, transparan, dan berkeadilan.</p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-primary mb-3">Misi</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Menyediakan kanal pengaduan yang inklusif dan mudah diakses.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Menjamin respons cepat dan penyelesaian masalah yang tuntas.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Mendorong partisipasi aktif masyarakat dalam pembangunan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- VIDEO EDUKASI -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Edukasi Pengaduan</h2>
                <p class="text-gray-600">Simak panduan berikut untuk menyampaikan laporan yang efektif</p>
            </div>
            <div class="max-w-4xl mx-auto rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                <div class="aspect-w-16 aspect-h-9 relative pb-[56.25%] bg-black">
                    <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/TairxlJ3To4" title="Video Edukasi LAPOR!" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- RIWAYAT RILIS -->
    <section class="py-16 container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Riwayat Rilis</h2>
            <p class="text-gray-500 mt-2">Perjalanan pengembangan platform kami</p>
        </div>
        <div class="max-w-3xl mx-auto relative border-l-2 border-gray-200 ml-4 md:ml-auto">
            <!-- Timeline Item 1 -->
            <div class="mb-10 ml-8 relative group">
                <span class="absolute -left-11 top-0 w-6 h-6 bg-primary rounded-full border-4 border-white shadow-md group-hover:scale-125 transition-transform"></span>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <span class="text-xs font-bold text-primary uppercase tracking-wide">Desember 2024</span>
                    <h4 class="text-lg font-bold text-gray-800 mt-1">Versi 1.0 - Peluncuran Resmi</h4>
                    <p class="text-gray-600 mt-2 text-sm">Rilis perdana dengan fitur dasar pelaporan, autentikasi pengguna, dan dashboard admin untuk pengelolaan pengaduan.</p>
                </div>
            </div>
            <!-- Timeline Item 2 -->
            <div class="mb-10 ml-8 relative group">
                <span class="absolute -left-11 top-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-md group-hover:bg-primary transition-colors"></span>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow opacity-75">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Q1 2025 (Estimasi)</span>
                    <h4 class="text-lg font-bold text-gray-800 mt-1">Versi 1.1 - Notifikasi Real-time</h4>
                    <p class="text-gray-600 mt-2 text-sm">Integrasi notifikasi email dan WhatsApp untuk setiap perubahan status laporan pengguna.</p>
                </div>
            </div>
        </div>
    </section>

     <!-- TEAM & CONTACT (Combined clean layout) -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 text-center">
             <h2 class="text-3xl font-bold text-gray-800 mb-8">Hubungi Tim Kami</h2>
             <div class="grid grid-cols-1 md:grid-cols-2 max-w-2xl mx-auto gap-8">
                 <div class="p-6 bg-gray-50 rounded-xl">
                      <h4 class="font-bold text-gray-800 mb-2">Dukungan Teknis</h4>
                      <p class="text-gray-600 text-sm mb-4">Senin - Jumat, 08:00 - 16:00 WIB</p>
                      <a href="mailto:support@alpem.com" class="text-primary font-medium hover:underline">support@alpem.com</a>
                 </div>
                  <div class="p-6 bg-gray-50 rounded-xl">
                      <h4 class="font-bold text-gray-800 mb-2">Informasi Umum</h4>
                      <p class="text-gray-600 text-sm mb-4">Pertanyaan seputar layanan dan kemitraan</p>
                      <a href="tel:02112345678" class="text-primary font-medium hover:underline">021-12345678</a>
                 </div>
             </div>
        </div>
    </section>

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

</body>
</html>