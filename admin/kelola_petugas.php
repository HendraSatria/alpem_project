<?php
session_start();
require '../config/koneksi.php';

// Proteksi halaman: hanya admin

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit;
}
// Ambil data petugas
$petugas = mysqli_query($koneksi, "SELECT * FROM petugas ORDER BY Id_Petugas DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Petugas - Dashboard Admin ALPEM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="shadow-sm" style="background:#ffffff;">
    <div class="container py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" width="90" class="me-4">
            <h4 class="m-0 fw-bold text-danger">ALPEM</h4>
        </div>
        <nav>
            <span class="me-3">Halo, <?= $_SESSION['nama_petugas']; ?> (Admin)</span>
            <a href="../auth/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
        </nav>
    </div>
</header>

<!-- ================= MAIN ================= -->
<div class="container-fluid mt-4">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 mb-4">
            <div class="bg-white shadow-sm rounded p-3">
                <h5 class="fw-bold text-danger mb-3">Menu Admin</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="dashboard_admin.php" class="nav-link text-dark">Dashboard</a></li>
                    <li class="nav-item mb-2"><a href="kelola_petugas.php" class="nav-link text-danger">Kelola Petugas</a></li>
                    <li class="nav-item mb-2"><a href="unduh_laporan.php" class="nav-link text-dark">Unduh Laporan</a></li>
                    <li class="nav-item mb-2"><a href="tanggapan.php" class="nav-link text-dark">Tanggapan Aduan</a></li>
                </ul>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">

            <div class="bg-white shadow-sm rounded p-4 mb-4">
                <h5 class="fw-bold text-danger mb-3">Kelola Petugas</h5>

                <!-- Tombol Tambah Petugas -->
                <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Petugas</button>

                <!-- Tabel Petugas -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-danger text-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($row=mysqli_fetch_assoc($petugas)) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['Nama_Petugas']); ?></td>
                                <td><?= htmlspecialchars($row['Username']); ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['Role']=='admin'?'danger':'info'; ?>">
                                        <?= ucfirst($row['Role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['Id_Petugas']; ?>">Edit</button>
                                    <a href="hapus_petugas.php?id=<?= $row['Id_Petugas']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus petugas ini?')">Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit Petugas -->
                            <div class="modal fade" id="modalEdit<?= $row['Id_Petugas']; ?>" tabindex="-1">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="proses_edit_petugas.php" method="POST">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Edit Petugas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body">
                                          <input type="hidden" name="id_petugas" value="<?= $row['Id_Petugas']; ?>">
                                          <div class="mb-3">
                                              <label class="form-label">Nama Petugas</label>
                                              <input type="text" name="nama_petugas" class="form-control" value="<?= htmlspecialchars($row['Nama_Petugas']); ?>" required>
                                          </div>
                                          <div class="mb-3">
                                              <label class="form-label">Username</label>
                                              <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['Username']); ?>" required>
                                          </div>
                                          <div class="mb-3">
                                              <label class="form-label">Role</label>
                                              <select name="role" class="form-select">
                                                  <option value="petugas" <?= $row['Role']=='petugas'?'selected':''; ?>>Petugas</option>
                                                  <option value="admin" <?= $row['Role']=='admin'?'selected':''; ?>>Admin</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                      </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_tambah_petugas.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Petugas Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Nama Petugas</label>
                  <input type="text" name="nama_petugas" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Role</label>
                  <select name="role" class="form-select">
                      <option value="petugas">Petugas</option>
                      <option value="admin">Admin</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Tambah Petugas</button>
          </div>
      </form>
      
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="py-4 text-center text-white mt-4" style="background:#c8102e;">
    <p class="m-0">&copy; <?= date("Y"); ?> ALPEM - Dashboard Admin</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
