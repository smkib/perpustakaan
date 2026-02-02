<?php
include '../config/auth_admin.php';
include '../config/koneksi.php';

mysqli_query($conn,"DELETE FROM users WHERE id_user='$_GET[id]'");
header("location:anggota.php");
