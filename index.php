<?php
session_start();
include 'config/koneksi.php';

$error = "";
if(isset($_POST['login'])){
  $u = $_POST['username'];
  $p = md5($_POST['password']);

  $q = mysqli_query($conn,"
    SELECT * FROM users 
    WHERE username='$u' AND password='$p'
  ");
  $d = mysqli_fetch_assoc($q);

  if(mysqli_num_rows($q) > 0){
    $_SESSION['id_user'] = $d['id_user'];
    $_SESSION['role']    = $d['role'];
    header("location:".$d['role']."/dashboard.php");
  } else {
    $error = "Username atau password salah";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Perpustakaan Sekolah</title>

<!-- Bootstrap Offline -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

<style>
body{
  background: linear-gradient(135deg,#1e293b,#0f172a);
  min-height: 100vh;
  display: flex;
  align-items: center;
}
.login-card{
  max-width: 420px;
  width: 100%;
}
.brand{
  font-weight: 600;
  letter-spacing: 1px;
}
</style>
</head>

<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="card login-card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

          <div class="text-center mb-4">
            <h4 class="brand">📚 PERPUSTAKAAN</h4>
            <small class="text-muted">Sistem Peminjaman Buku</small>
          </div>

          <?php if($error!=""){ ?>
            <div class="alert alert-danger text-center">
              <?= $error ?>
            </div>
          <?php } ?>

          <form method="post">

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" 
                     name="username" 
                     class="form-control form-control-lg"
                     placeholder="Masukkan username"
                     required>
            </div>

            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" 
                     name="password" 
                     class="form-control form-control-lg"
                     placeholder="Masukkan password"
                     required>
            </div>

            <div class="d-grid">
              <button name="login" class="btn btn-dark btn-lg">
                Login
              </button>
            </div>

          </form>

        </div>
      </div>

      <p class="text-center text-light mt-3 small">
        © <?= date('Y') ?> Perpustakaan Sekolah
      </p>

    </div>
  </div>
</div>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
