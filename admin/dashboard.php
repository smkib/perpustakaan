<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

/* hitung data */
$jml_buku     = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM buku"));
$jml_anggota  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='user'"));
$jml_admin    = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='admin'"));
$jml_pinjam   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM peminjaman WHERE status='dipinjam'"));
?>

<div class="container mt-4">
  <h3 class="mb-4">Dashboard Admin</h3>

  <div class="row g-3">
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h6>Total Buku</h6>
          <h2><?= $jml_buku ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h6>Anggota</h6>
          <h2><?= $jml_anggota ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h6>Admin</h6>
          <h2><?= $jml_admin ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h6>Dipinjam</h6>
          <h2><?= $jml_pinjam ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="alert alert-info mt-4">
    Selamat datang, <b>Admin</b>.  
    Gunakan menu navigasi di atas untuk mengelola data perpustakaan.
  </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
