<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>User | Perpustakaan</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

<style>
.navbar-user {
  background: linear-gradient(135deg,#1e3a8a,#0f172a);
}
.navbar-user .nav-link {
  color: #e5e7eb !important;
  font-weight: 500;
  margin-left: 8px;
}
.navbar-user .nav-link:hover {
  color: #ffffff !important;
}
</style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-user shadow-sm py-3">
  <div class="container">

    <a class="navbar-brand text-light fw-semibold" href="dashboard.php">
      📖 PERPUSTAKAAN
    </a>

    <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navUser">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navUser">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="pinjam.php">Pinjam</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="kembali.php">Kembali</a></li>
         -->

        <li class="nav-item ms-3">
          <a class="btn btn-outline-light btn-sm px-3 rounded-pill" href="../logout.php">
            Logout
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>
