<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

$data = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM users WHERE id_user='$_GET[id]'")
);

if(isset($_POST['update'])){
  mysqli_query($conn,"UPDATE users SET
    nama='$_POST[nama]',
    username='$_POST[username]'
    WHERE id_user='$_GET[id]'
  ");
  header("location:anggota.php");
}
?>

<div class="container mt-4">
<h4>Edit Anggota</h4>
<form method="post">
<input class="form-control mb-2" name="nama" value="<?= $data['nama'] ?>">
<input class="form-control mb-2" name="username" value="<?= $data['username'] ?>">
<button name="update" class="btn btn-warning">Update</button>
</form>
</div>
