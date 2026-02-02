<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

if(isset($_POST['simpan'])){
  mysqli_query($conn,"INSERT INTO users VALUES(
    NULL,
    '$_POST[nama]',
    '$_POST[username]',
    MD5('$_POST[password]'),
    'user'
  )");
  header("location:anggota.php");
}
?>

<div class="container mt-4">
<h4>Tambah Anggota</h4>
<form method="post">
<input class="form-control mb-2" name="nama" placeholder="Nama" required>
<input class="form-control mb-2" name="username" placeholder="Username" required>
<input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
<button name="simpan" class="btn btn-success">Simpan</button>
</form>
</div>
