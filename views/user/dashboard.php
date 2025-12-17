<?php include '../../partials/header.php'; ?>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">User Area</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
  <h2 class="mb-4">Halo, User!</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-4">
        <h5>Status Akun</h5>
        <p class="text-success fw-bold">Aktif</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-4">
        <h5>Riwayat Aktivitas</h5>
        <ul>
          <li>Login terakhir: 2 jam lalu</li>
          <li>Update profil: kemarin</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<footer class="footer mt-5">
  &copy; <?= date('Y') ?> Alpem Project - User Area
</footer>
<?php include '../../partials/footer.php'; ?>
