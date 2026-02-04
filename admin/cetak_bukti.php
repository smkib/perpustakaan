<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';

if(!isset($_GET['id'])){
  echo "ID peminjaman tidak ditemukan";
  exit;
}

$id_pinjam = $_GET['id'];

/* ================= DATA PEMINJAMAN ================= */
$q = mysqli_query($conn,"
  SELECT 
    p.id_pinjam,
    p.tanggal_pinjam,
    p.tanggal_kembali,
    p.status,
    u.nama,
    b.judul,
    b.pengarang,
    d.jumlah
  FROM peminjaman p
  JOIN users u ON p.id_user = u.id_user
  JOIN detail_peminjaman d ON p.id_pinjam = d.id_pinjam
  JOIN buku b ON d.id_buku = b.id_buku
  WHERE p.id_pinjam = '$id_pinjam'
");

$data = mysqli_fetch_assoc($q);

if(!$data){
  echo "Data peminjaman tidak ditemukan";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Peminjaman Buku</title>
  <style>
    body{
      font-family: Arial, sans-serif;
      font-size: 14px;
    }
    .container{
      width: 600px;
      margin: auto;
    }
    h2{
      text-align: center;
      margin-bottom: 5px;
    }
    hr{
      margin: 10px 0;
    }
    table{
      width: 100%;
      border-collapse: collapse;
    }
    td{
      padding: 6px;
      vertical-align: top;
    }
    .label{
      width: 180px;
    }
    .ttd{
      margin-top: 50px;
      text-align: right;
    }
  </style>
</head>
<body onload="window.print()">

<div class="container">
  <h2>BUKTI PEMINJAMAN BUKU</h2>
  <hr>

  <table>
    <tr>
      <td class="label">Nama Anggota</td>
      <td>: <?= $data['nama'] ?></td>
    </tr>
    <tr>
      <td>Judul Buku</td>
      <td>: <?= $data['judul'] ?></td>
    </tr>
    <tr>
      <td>Pengarang</td>
      <td>: <?= $data['pengarang'] ?></td>
    </tr>
    <tr>
      <td>Jumlah</td>
      <td>: <?= $data['jumlah'] ?></td>
    </tr>
    <tr>
      <td>Tanggal Pinjam</td>
      <td>: <?= $data['tanggal_pinjam'] ?></td>
    </tr>
    <tr>
      <td>Tanggal Kembali</td>
      <td>:
        <?= ($data['tanggal_kembali'] == NULL ? '-' : $data['tanggal_kembali']) ?>
      </td>
    </tr>
    <tr>
      <td>Status</td>
      <td>: <?= strtoupper($data['status']) ?></td>
    </tr>
  </table>

  <div class="ttd">
    <p>Petugas Perpustakaan</p>
    <br><br>
    <p>( ____________________ )</p>
  </div>
</div>

</body>
</html>
