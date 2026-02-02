<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

$q=mysqli_query($conn,"SELECT * FROM peminjaman WHERE status='dipinjam'");
?>
<div class="container mt-3">
<table class="table">
<?php while($p=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $p['id_pinjam'] ?></td>
<td>
<a href="?kembali=<?= $p['id_pinjam'] ?>">Kembalikan</a>
</td>
</tr>
<?php } ?>
</table>
</div>
<?php
if(isset($_GET['kembali'])){
mysqli_query($conn,"UPDATE peminjaman SET
status='dikembalikan', tanggal_kembali=CURDATE()
WHERE id_pinjam='$_GET[kembali]'");
}
?>
