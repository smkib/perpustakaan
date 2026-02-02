<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';
include '../partials/header_admin.php';

$q = mysqli_query($conn,"
SELECT 
  b.*, 
  IFNULL(SUM(d.jumlah),0) AS dipinjam,
  (b.stok - IFNULL(SUM(d.jumlah),0)) AS tersedia
FROM buku b
LEFT JOIN detail_peminjaman d ON b.id_buku=d.id_buku
LEFT JOIN peminjaman p ON d.id_pinjam=p.id_pinjam AND p.status='dipinjam'
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
              Data buku belum tersedia
            </td>
          </tr>
        <?php } ?>

        <?php while($b = mysqli_fetch_assoc($q)){ ?>
          <tr>
            <td class="ps-4 fw-medium">
              <?= $b['judul'] ?>
            </td>

            <td class="text-center">
              <span class="badge bg-secondary">
                <?= $b['stok'] ?>
              </span>
            </td>

            <td class="text-center">
              <span class="badge bg-warning text-dark">
                <?= $b['dipinjam'] ?>
              </span>
            </td>

            <td class="text-center">
              <?php if($b['tersedia'] > 0){ ?>
                <span class="badge bg-success">
                  <?= $b['tersedia'] ?>
                </span>
              <?php } else { ?>
                <span class="badge bg-danger">
                  0
                </span>
              <?php } ?>
            </td>

            <td class="text-center pe-4">
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

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
