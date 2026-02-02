<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin | Perpustakaan</title>

<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

<style>
.navbar-admin {
  background: linear-gradient(135deg,#ffffff,#0f172a);
}
.navbar-admin .nav-link {
  color: #e5e7eb !important;
  font-weight: 500;
  margin-left: 8px;
}
.navbar-admin .nav-link:hover {
  color: #c91212 !important;
}
.brand-text {
  font-weight: 600;
  letter-spacing: 1px;
}
</style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-admin shadow-sm py-3">
  <div class="container">

    <a class="navbar-brand text-light brand-text" href="dashboard.php">
      📚 ADMIN PERPUS
    </a>

    <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navAdmin">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="buku.php">Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="anggota.php">Anggota</a></li>
        <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="peminjaman.php">Peminjaman</a></li>

        <li class="nav-item ms-3">
          <a class="btn btn-outline-light btn-sm px-3 rounded-pill" href="../logout.php">
            Logout
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>
