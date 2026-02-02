<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

$data = mysqli_query($conn,"SELECT * FROM users WHERE role='user'");
?>

<div class="container mt-4">
<a href="anggota_tambah.php" class="btn btn-success mb-3">Tambah Anggota</a>
<table class="table table-striped">
<tr><th>Nama</th><th>Username</th><th>Aksi</th></tr>
<?php while($a=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $a['nama'] ?></td>
<td><?= $a['username'] ?></td>
<td>
<a href="anggota_edit.php?id=<?= $a['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="anggota_hapus.php?id=<?= $a['id_user'] ?>" class="btn btn-danger btn-sm">Hapus</a>
</td>
</tr>
<?php } ?>
</table>
</div>
