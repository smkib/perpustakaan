<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

if(isset($_POST['simpan'])){
  mysqli_query($conn,"INSERT INTO buku VALUES(
    NULL,
    '$_POST[judul]',
    '$_POST[pengarang]',
    '$_POST[penerbit]',
    '$_POST[tahun]',
    '$_POST[stok]'
  )");
  header("location:buku.php");
}
?>

<div class="container mt-4">
<h4>Tambah Buku</h4>
<form method="post">
<input class="form-control mb-2" name="judul" placeholder="Judul" required>
<input class="form-control mb-2" name="pengarang" placeholder="Pengarang">
<input class="form-control mb-2" name="penerbit" placeholder="Penerbit">
<input class="form-control mb-2" name="tahun" placeholder="Tahun">
<input class="form-control mb-2" name="stok" type="number" placeholder="Stok" required>
<button name="simpan" class="btn btn-success">Simpan</button>
</form>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
