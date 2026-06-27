<?php
include 'config.php';
session_start();

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil data user yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        header("Location: manage_users.php");
        exit;
    }
} else {
    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User - SIAKAD</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7fe; min-height: 100vh; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .form-label { font-weight: 600; color: #4a5568; font-size: 0.9rem; }
        .form-control, .form-select { border-radius: 10px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; }
        .btn-update { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 10px; padding: 12px; font-weight: 600; transition: all 0.3s; }
        .btn-update:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-5">
    <div class="container">
        <a class="navbar-brand" href="manage_users.php"><i class="fas fa-arrow-left me-2"></i> Kembali ke Manajemen User</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="mb-3" style="font-size: 40px; color: #764ba2;">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h3 class="fw-bold">Edit Akun Pengguna</h3>
                    <p class="text-muted">Perbarui informasi profil atau hak akses user.</p>
                </div>

                <form action="proses_user.php" method="POST">
                    <!-- ID User disembunyikan agar tahu mana yang diupdate -->
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $user['nama_lengkap'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role / Hak Akses</label>
                        <select name="role" class="form-select">
                            <option value="mahasiswa" <?= $user['role'] == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                            <option value="dosen" <?= $user['role'] == 'dosen' ? 'selected' : '' ?>>Dosen</option>
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password Baru (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                        <div class="form-text text-danger" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika password tetap sama.
                        </div>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary btn-update w-100 shadow">
                        <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>