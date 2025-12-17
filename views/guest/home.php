<?php include '../../partials/header.php'; ?>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Alpem Project</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Register</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
  <div class="text-center">
    <h1 class="mb-3">Selamat Datang di Alpem Project</h1>
    <p class="lead mb-4">Platform modern untuk kebutuhan Anda. Silakan login atau daftar untuk melanjutkan.</p>
    <a href="#" class="btn btn-primary btn-lg">Login</a>
    <a href="#" class="btn btn-outline-primary btn-lg ms-2">Register</a>
  </div>
</div>
<footer class="footer mt-5">
  &copy; <?= date('Y') ?> Alpem Project
</footer>
<?php include '../../partials/footer.php'; ?>
