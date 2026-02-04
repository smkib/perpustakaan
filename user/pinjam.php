<?php
include '../config/auth_user.php';
include '../config/koneksi.php';
include '../partials/header_user.php';

$id_user = $_SESSION['id_user'];

/* ================= DATA BUKU TERSEDIA ================= */
$buku = mysqli_query($conn,"
SELECT 
  b.id_buku,
  b.judul,
  b.pengarang,
  (b.stok - IFNULL(SUM(
    CASE 
      WHEN p.status='dipinjam' THEN d.jumlah
      ELSE 0
    END
  ),0)) AS tersedia
FROM buku b
LEFT JOIN detail_peminjaman d ON b.id_buku=d.id_buku
LEFT JOIN peminjaman p ON d.id_pinjam=p.id_pinjam
GROUP BY b.id_buku
HAVING tersedia > 0
");

/* ================= SIMPAN PEMINJAMAN ================= */
$error = "";

if(isset($_POST['pinjam'])){
  $id_buku = $_POST['id_buku'];
  $jumlah  = $_POST['jumlah'];

  $cek = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT 
      (b.stok - IFNULL(SUM(
        CASE WHEN p.status='dipinjam' THEN d.jumlah ELSE 0 END
      ),0)) AS tersedia
    FROM buku b
    LEFT JOIN detail_peminjaman d ON b.id_buku=d.id_buku
    LEFT JOIN peminjaman p ON d.id_pinjam=p.id_pinjam
    WHERE b.id_buku='$id_buku'
    GROUP BY b.id_buku
  "));

  if($jumlah > $cek['tersedia']){
    $error = "Jumlah melebihi stok tersedia";
  } else {
    mysqli_query($conn,"
      INSERT INTO peminjaman 
      (id_user,tanggal_pinjam,tanggal_kembali,status)
      VALUES ('$id_user',CURDATE(),NULL,'dipinjam')
    ");
    $id_pinjam = mysqli_insert_id($conn);

    mysqli_query($conn,"
      INSERT INTO detail_peminjaman 
      (id_pinjam,id_buku,jumlah)
      VALUES ('$id_pinjam','$id_buku','$jumlah')
    ");

    header("Location: peminjaman.php");
    exit;
  }
}

/* ================= DATA RIWAYAT USER ================= */
$pinjam = mysqli_query($conn,"
SELECT 
  p.id_pinjam,
  b.judul,
  d.jumlah,
  p.tanggal_pinjam,
  p.tanggal_kembali,
  p.status
FROM peminjaman p
JOIN detail_peminjaman d ON p.id_pinjam=d.id_pinjam
JOIN buku b ON d.id_buku=b.id_buku
WHERE p.id_user='$id_user'
ORDER BY p.id_pinjam DESC
");
?>

<div class="container my-4">

<h4 class="fw-semibold mb-3">Peminjaman Buku</h4>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="post" class="card shadow-sm border-0 rounded-4 p-4 mb-4">

  <div class="mb-3">
    <label class="form-label">Buku</label>
    <div class="input-group">
      <input type="text" id="judul" class="form-control" readonly required>
      <button type="button" class="btn btn-outline-secondary"
        data-bs-toggle="modal" data-bs-target="#modalBuku">
        Cari Buku
      </button>
    </div>
    <input type="hidden" name="id_buku" id="id_buku">
    <small id="info" class="text-muted"></small>
  </div>

  <div class="mb-3">
    <label class="form-label">Jumlah</label>
    <input type="number" name="jumlah" id="jumlah"
      class="form-control" min="1" required>
  </div>

  <button name="pinjam" class="btn btn-dark w-100">
    Simpan Peminjaman
  </button>
</form>

<!-- ================= RIWAYAT ================= -->
<div class="card shadow-sm border-0 rounded-4">
<div class="card-body">

<h5 class="mb-3">Riwayat Peminjaman</h5>

<table class="table table-hover">
<thead class="table-light">
<tr>
  <th>Judul Buku</th>
  <th>Jumlah</th>
  <th>Tanggal Pinjam</th>
  <th>Tanggal Kembali</th>
  <th>Status</th>
</tr>
</thead>
<tbody>
<?php while($p=mysqli_fetch_assoc($pinjam)){ ?>
<tr>
  <td><?= $p['judul'] ?></td>
  <td><?= $p['jumlah'] ?></td>
  <td><?= $p['tanggal_pinjam'] ?></td>
  <td><?= $p['tanggal_kembali'] ?: '-' ?></td>
  <td>
    <span class="badge <?= $p['status']=='dipinjam'?'bg-warning text-dark':'bg-success' ?>">
      <?= ucfirst($p['status']) ?>
    </span>
  </td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>

</div>

<!-- ================= MODAL BUKU ================= -->
<div class="modal fade" id="modalBuku" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Daftar Buku</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="p-3">
<input type="text" id="searchBuku"
 class="form-control"
 placeholder="Cari judul / pengarang">
</div>

<div class="modal-body p-0">
<table class="table table-hover mb-0">
<tbody>
<?php while($b=mysqli_fetch_assoc($buku)){ ?>
<tr class="buku-row">
<td><?= $b['judul'] ?></td>
<td><?= $b['pengarang'] ?></td>
<td><?= $b['tersedia'] ?></td>
<td>
<button type="button"
 class="btn btn-sm btn-primary"
 data-bs-dismiss="modal"
 onclick="pilihBuku(
   '<?= $b['id_buku'] ?>',
   '<?= $b['judul'] ?>',
   '<?= $b['pengarang'] ?>',
   '<?= $b['tersedia'] ?>'
 )">
 Pilih
</button>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

</div>
</div>
</div>

<script>
function pilihBuku(id, judul, pengarang, stok){
  document.getElementById('id_buku').value = id;
  document.getElementById('judul').value = judul;
  document.getElementById('jumlah').max = stok;
  document.getElementById('info').innerHTML =
    'Pengarang: ' + pengarang + ' | Stok tersedia: ' + stok;
}

document.getElementById('searchBuku').addEventListener('keyup', function(){
  var k = this.value.toLowerCase();
  document.querySelectorAll('.buku-row').forEach(function(r){
    r.style.display = r.innerText.toLowerCase().includes(k) ? '' : 'none';
  });
});
</script>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
