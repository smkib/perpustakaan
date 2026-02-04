<?php
include '../config/koneksi.php';

$dari   = isset($_GET['dari']) ? $_GET['dari'] : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

if ($dari == '' || $sampai == '') {
  echo "Tanggal tidak valid";
  exit;
}

$data = mysqli_query($conn,"
  SELECT 
    p.id_pinjam,
    u.nama,
    b.judul,
    d.jumlah,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    p.status
  FROM peminjaman p
  JOIN users u ON p.id_user = u.id_user
  JOIN detail_peminjaman d ON p.id_pinjam = d.id_pinjam
  JOIN buku b ON d.id_buku = b.id_buku
  WHERE p.tanggal_pinjam BETWEEN '$dari' AND '$sampai'
  ORDER BY p.tanggal_pinjam ASC
");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Peminjaman Buku</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }
    h2, h4 {
      text-align: center;
      margin: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #000;
    }
    th, td {
      padding: 6px;
      text-align: center;
    }
    .text-left {
      text-align: left;
    }
  </style>
</head>
<body>

<h2>LAPORAN PEMINJAMAN BUKU</h2>
<h4>Periode: <?php echo $dari; ?> s/d <?php echo $sampai; ?></h4>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Anggota</th>
      <th>Judul Buku</th>
      <th>Jumlah</th>
      <th>Tanggal Pinjam</th>
      <th>Tanggal Kembali</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    if (mysqli_num_rows($data) > 0) {
      while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td class='text-left'>".$row['nama']."</td>";
        echo "<td class='text-left'>".$row['judul']."</td>";
        echo "<td>".$row['jumlah']."</td>";
        echo "<td>".$row['tanggal_pinjam']."</td>";
        echo "<td>";
        if ($row['tanggal_kembali'] == NULL) {
          echo "-";
        } else {
          echo $row['tanggal_kembali'];
        }
        echo "</td>";
        echo "<td>".$row['status']."</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='7'>Data tidak ditemukan</td></tr>";
    }
    ?>
  </tbody>
</table>

<script>
  window.print();
</script>

</body>
</html>
