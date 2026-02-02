<?php
include '../config/auth_user.php';
include '../config/koneksi.php';
include '../partials/header_user.php';

$id_user = $_SESSION['id_user'];

$jml_pinjam = mysqli_num_rows(mysqli_query($conn,"
  SELECT * FROM peminjaman 
  WHERE id_user='$id_user' AND status='dipinjam'
"));

$jml_kembali = mysqli_num_rows(mysqli_query($conn,"
  SELECT * FROM peminjaman 
  WHERE id_user='$id_user' AND status='dikembalikan'
"));
?>

<div class="container mt-4">
  <h3 class="mb-4">Dashboard User</h3>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card shadow-sm border-primary">
        <div class="card-body text-center">
          <h6>Buku Sedang Dipinjam</h6>
          <h2><?= $jml_pinjam ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-success">
        <div class="card-body text-center">
          <h6>Buku Pernah Dikembalikan</h6>
          <h2><?= $jml_kembali ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="alert alert-primary mt-4">
    Selamat datang di aplikasi <b>Perpustakaan Sekolah</b>.  
    Silakan melakukan peminjaman atau pengembalian buku melalui menu di atas.
  </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
