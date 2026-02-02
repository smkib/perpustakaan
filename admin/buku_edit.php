<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

$data = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM buku WHERE id_buku='$_GET[id]'")
);

if(isset($_POST['update'])){
  mysqli_query($conn,"UPDATE buku SET
    judul='$_POST[judul]',
    pengarang='$_POST[pengarang]',
    penerbit='$_POST[penerbit]',
    tahun='$_POST[tahun]',
    stok='$_POST[stok]'
    WHERE id_buku='$_GET[id]'
  ");
  header("location:buku.php");
}
?>

<div class="container mt-4">
<h4>Edit Buku</h4>
<form method="post">
<input class="form-control mb-2" name="judul" value="<?= $data['judul'] ?>">
<input class="form-control mb-2" name="pengarang" value="<?= $data['pengarang'] ?>">
<input class="form-control mb-2" name="penerbit" value="<?= $data['penerbit'] ?>">
<input class="form-control mb-2" name="tahun" value="<?= $data['tahun'] ?>">
<input class="form-control mb-2" name="stok" type="number" value="<?= $data['stok'] ?>">
<button name="update" class="btn btn-warning">Update</button>
</form>
</div>
