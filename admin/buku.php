<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

/* ambil keyword pencarian */
$keyword = isset($_GET['cari']) ? $_GET['cari'] : "";

/* query utama + search */
$q = mysqli_query($conn,"
SELECT 
  b.*,
  IFNULL(SUM(
    CASE 
      WHEN p.status = 'dipinjam' THEN d.jumlah
      ELSE 0
    END
  ),0) AS dipinjam,
  (b.stok - IFNULL(SUM(
    CASE 
      WHEN p.status = 'dipinjam' THEN d.jumlah
      ELSE 0
    END
  ),0)) AS tersedia
FROM buku b
LEFT JOIN detail_peminjaman d ON b.id_buku = d.id_buku
LEFT JOIN peminjaman p ON d.id_pinjam = p.id_pinjam
WHERE b.judul LIKE '%$keyword%'
   OR b.pengarang LIKE '%$keyword%'
GROUP BY b.id_buku
");

?>

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0 fw-semibold">Data Buku</h4>
      <small class="text-muted">Manajemen koleksi perpustakaan</small>
    </div>
    <a href="buku_tambah.php" class="btn btn-dark rounded-pill px-4">
      + Tambah Buku
    </a>
  </div>

  <!-- FORM PENCARIAN (TAMBAHAN) -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input 
        type="text" 
        name="cari" 
        class="form-control"
        placeholder="Cari judul buku atau pengarang..."
        value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-outline-secondary">
        Cari
      </button>
    </div>
  </form>
  <!-- END SEARCH -->

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">

      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Judul Buku</th>
            <th class="text-center">Total</th>
            <th class="text-center">Dipinjam</th>
            <th class="text-center">Tersedia</th>
            <th class="text-center pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>

        <?php if(mysqli_num_rows($q) == 0){ ?>
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">
              Data buku tidak ditemukan
            </td>
          </tr>
        <?php } ?>

        <?php while($b = mysqli_fetch_assoc($q)){ ?>
          <tr>
            <td class="ps-4 fw-medium"><?= $b['judul'] ?></td>

            <td class="text-center">
              <span class="badge bg-secondary"><?= $b['stok'] ?></span>
            </td>

            <td class="text-center">
              <span class="badge bg-warning text-dark"><?= $b['dipinjam'] ?></span>
            </td>

            <td class="text-center">
              <?php if($b['tersedia'] > 0){ ?>
                <span class="badge bg-success"><?= $b['tersedia'] ?></span>
              <?php } else { ?>
                <span class="badge bg-danger">0</span>
              <?php } ?>
            </td>

            <td class="text-center pe-4">

              <button
                type="button"
                class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#detail<?= $b['id_buku'] ?>">
                Detail
              </button>

              <a href="buku_edit.php?id=<?= $b['id_buku'] ?>"
                 class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Edit
              </a>

              <a href="buku_hapus.php?id=<?= $b['id_buku'] ?>"
                 class="btn btn-sm btn-outline-danger rounded-pill px-3"
                 onclick="return confirm('Hapus buku ini?')">
                Hapus
              </a>

            </td>
          </tr>
        <?php } ?>

        </tbody>
      </table>

    </div>
  </div>

</div>

<!-- ================= MODAL DETAIL ================= -->
<?php
mysqli_data_seek($q, 0);
while($b = mysqli_fetch_assoc($q)){
?>
<div class="modal fade" id="detail<?= $b['id_buku'] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <table class="table table-borderless mb-0">
          <tr><th>Judul</th><td><?= $b['judul'] ?></td></tr>
          <tr><th>Pengarang</th><td><?= $b['pengarang'] ?></td></tr>
          <tr><th>Penerbit</th><td><?= $b['penerbit'] ?></td></tr>
          <tr><th>Tahun</th><td><?= $b['tahun'] ?></td></tr>
          <tr><th>Stok Total</th><td><?= $b['stok'] ?></td></tr>
          <tr><th>Dipinjam</th><td><?= $b['dipinjam'] ?></td></tr>
          <tr><th>Tersedia</th><td><?= $b['tersedia'] ?></td></tr>
        </table>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>
<?php } ?>
<!-- ================= END MODAL ================= -->

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
