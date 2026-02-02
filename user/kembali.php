<?php
include '../config/auth_user.php';
include '../config/koneksi.php';
include '../partials/header_user.php';

$id_user = $_SESSION['id_user'];

/* data pinjaman user */
$data = mysqli_query($conn,"
  SELECT p.id_pinjam, b.judul, d.jumlah, p.tanggal_pinjam
  FROM peminjaman p
  JOIN detail_peminjaman d ON p.id_pinjam=d.id_pinjam
  JOIN buku b ON d.id_buku=b.id_buku
  WHERE p.id_user='$id_user' AND p.status='dipinjam'
");

/* proses pengembalian */
if(isset($_GET['kembali'])){
  $id_pinjam = $_GET['kembali'];

  // ambil detail buku yang dipinjam
  $detail = mysqli_query($conn,"
    SELECT d.id_buku, d.jumlah 
    FROM detail_peminjaman d
    WHERE d.id_pinjam='$id_pinjam'
  ");

  while($d = mysqli_fetch_assoc($detail)){
    // tambahkan stok buku
    mysqli_query($conn,"
      UPDATE buku 
      SET stok = stok + $d[jumlah]
      WHERE id_buku='$d[id_buku]'
    ");
  }

  // update status peminjaman
  mysqli_query($conn,"
    UPDATE peminjaman 
    SET status='dikembalikan',
        tanggal_kembali=CURDATE()
    WHERE id_pinjam='$id_pinjam' 
      AND id_user='$id_user'
  ");

  echo "<script>alert('Buku berhasil dikembalikan');location='kembali.php';</script>";
}

?>

<div class="container mt-4">
<h4>Pengembalian Buku</h4>

<table class="table table-bordered">
<tr class="table-primary">
  <th>Judul Buku</th>
  <th>Jumlah</th>
  <th>Tanggal Pinjam</th>
  <th>Aksi</th>
</tr>

<?php if(mysqli_num_rows($data)==0){ ?>
<tr>
  <td colspan="4" class="text-center">Tidak ada buku yang dipinjam</td>
</tr>
<?php } ?>

<?php while($p=mysqli_fetch_assoc($data)){ ?>
<tr>
  <td><?= $p['judul'] ?></td>
  <td><?= $p['jumlah'] ?></td>
  <td><?= $p['tanggal_pinjam'] ?></td>
  <td>
    <a href="?kembali=<?= $p['id_pinjam'] ?>" 
       class="btn btn-success btn-sm"
       onclick="return confirm('Kembalikan buku ini?')">
       Kembalikan
    </a>
  </td>
</tr>
<?php } ?>
</table>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
