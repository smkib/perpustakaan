<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';

mysqli_query($conn,"DELETE FROM buku WHERE id_buku='$_GET[id]'");
header("location:buku.php");
