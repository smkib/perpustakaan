<?php
include '../config/auth_user.php';
include '../config/koneksi.php';
include '../partials/header_user.php';

/* ambil buku + stok tersedia */
$buku = mysqli_query($conn,"
SELECT 
  b.id_buku,
  b.judul,
  b.stok - IFNULL(SUM(d.jumlah),0) AS tersedia
FROM buku b
LEFT JOIN detail_peminjaman d ON b.id_buku=d.id_buku
LEFT JOIN peminjaman p ON d.id_pinjam=p.id_pinjam AND p.status='dipinjam'
GROUP BY b.id_buku
HAVING tersedia > 0
");

$error = "";
$success = "";

/* proses pinjam */
if(isset($_POST['pinjam'])){

  $id_user = $_SESSION['id_user'];
  $buku_id = $_POST['id_buku'];
  $jumlah  = $_POST['jumlah'];

  /* validasi stok */
  foreach($buku_id as $i => $id){
    $cek = mysqli_fetch_assoc(mysqli_query($conn,"
      SELECT 
        b.stok - IFNULL(SUM(d.jumlah),0) AS tersedia
      FROM buku b
      LEFT JOIN detail_peminjaman d ON b.id_buku=d.id_buku
      LEFT JOIN peminjaman p ON d.id_pinjam=p.id_pinjam AND p.status='dipinjam'
      WHERE b.id_buku='$id'
      GROUP BY b.id_buku
    "));

    if($jumlah[$i] > $cek['tersedia']){
      $error = "Jumlah pinjaman melebihi stok tersedia";
      break;
    }
  }

  /* simpan jika aman */
  if($error == ""){
    mysqli_query($conn,"
      INSERT INTO peminjaman 
      VALUES (NULL,'$id_user',CURDATE(),NULL,'dipinjam')
    ");
    $id_pinjam = mysqli_insert_id($conn);

    foreach($buku_id as $i => $id){
      mysqli_query($conn,"
        INSERT INTO detail_peminjaman 
        VALUES (NULL,'$id_pinjam','$id','$jumlah[$i]')
      ");
    }

    $success = "Peminjaman berhasil disimpan";
  }
}
?>

<div class="container my-4">

  <h4 class="fw-semibold mb-3">Peminjaman Buku</h4>

  <?php if($error){ ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php } ?>

  <?php if($success){ ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php } ?>

  <form method="post" class="card shadow-sm border-0 rounded-4 p-4">

    <div id="buku-wrapper">

      <div class="row mb-3 buku-item">
        <div class="col-md-7">
          <label class="form-label">Judul Buku</label>
          <select name="id_buku[]" class="form-select" required>
            <?php
            mysqli_data_seek($buku,0);
            while($b=mysqli_fetch_assoc($buku)){
              echo "<option value='$b[id_buku]'>
                      $b[judul] (Stok: $b[tersedia])
                    </option>";
            }
            ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Jumlah</label>
          <input type="number" name="jumlah[]" class="form-control" min="1" required>
        </div>

        
      </div>

    </div>

    

    <div class="d-grid">
      <button name="pinjam" class="btn btn-dark btn-lg">
        Simpan Peminjaman
      </button>
    </div>

  </form>
</div>

<script>
document.getElementById('tambah').onclick = function(){
  let item = document.querySelector('.buku-item').cloneNode(true);
  item.querySelectorAll('input').forEach(i => i.value = '');
  document.getElementById('buku-wrapper').appendChild(item);
};

document.addEventListener('click', function(e){
  if(e.target.classList.contains('remove')){
    if(document.querySelectorAll('.buku-item').length > 1){
      e.target.closest('.buku-item').remove();
    }
  }
});
</script>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
