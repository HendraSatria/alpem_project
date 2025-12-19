<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tentang ALPEM</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
<body class="bg-gray-50 font-sans antialiased text-gray-800 min-h-screen flex flex-col">

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

	<main class="flex-grow container mx-auto px-4 py-16">
		<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-10 border border-gray-100">
			<h1 class="text-3xl font-bold text-primary mb-4">Tentang ALPEM</h1>
			<p class="text-gray-700 text-lg mb-6">ALPEM (Aplikasi Layanan Pengaduan Masyarakat) adalah platform digital yang memudahkan masyarakat untuk menyampaikan aspirasi, keluhan, dan pengaduan secara online kepada instansi pemerintah terkait. Kami berkomitmen untuk meningkatkan transparansi, akuntabilitas, dan kualitas pelayanan publik di Indonesia.</p>
			<h2 class="text-xl font-semibold text-gray-800 mb-2 mt-8">Visi</h2>
			<p class="text-gray-700 mb-6">Menjadi jembatan utama antara masyarakat dan pemerintah dalam mewujudkan pelayanan publik yang responsif, transparan, dan terpercaya.</p>
			<h2 class="text-xl font-semibold text-gray-800 mb-2 mt-8">Misi</h2>
			<ul class="list-disc pl-6 text-gray-700 mb-6">
				<li>Menyediakan layanan pengaduan yang mudah, cepat, dan aman.</li>
				<li>Menjamin kerahasiaan identitas pelapor.</li>
				<li>Mendukung proses tindak lanjut yang transparan dan akuntabel.</li>
				<li>Mendorong partisipasi aktif masyarakat dalam pengawasan pelayanan publik.</li>
			</ul>
			<h2 class="text-xl font-semibold text-gray-800 mb-2 mt-8">Kontak & Dukungan</h2>
			<p class="text-gray-700 mb-2">Jika Anda memiliki pertanyaan, saran, atau membutuhkan bantuan, silakan hubungi kami:</p>
			<ul class="text-gray-700 mb-6">
				<li>Email: <a href="mailto:info@alpem.com" class="text-primary underline">info@alpem.com</a></li>
				<li>Telepon: <a href="tel:02112345678" class="text-primary underline">021-12345678</a></li>
			</ul>
			<h2 class="text-xl font-semibold text-gray-800 mb-2 mt-8">Tim Kami</h2>
			<p class="text-gray-700">ALPEM dikembangkan oleh tim profesional yang berpengalaman di bidang teknologi informasi dan pelayanan publik, dengan tujuan menciptakan perubahan positif bagi masyarakat Indonesia.</p>
		</div>
	</main>

	<footer class="bg-primary-dark text-white py-8 mt-auto">
		<div class="container mx-auto text-center">
			<p class="text-sm opacity-70">&copy; <?= date('Y') ?> ALPEM - Aplikasi Pengaduan Masyarakat</p>
		</div>
	</footer>
</body>
</html>