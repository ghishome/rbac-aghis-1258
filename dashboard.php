<?php
session_start();
if (!isset($_SESSION['role'])) { 
    header("Location: login.php"); 
    exit; 
}

// Logika sapaan berdasarkan waktu
$jam = date('H');
$sapaan = ($jam < 11) ? 'Selamat Pagi' : (($jam < 15) ? 'Selamat Siang' : (($jam < 19) ? 'Selamat Sore' : 'Selamat Malam'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= ucfirst($_SESSION['role']) ?></title>
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fe;
            min-height: 100vh;
        }

        /* Top Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Header Welcome Section */
        .welcome-banner {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px; /* Ubah dari -30px ke 20px agar tidak menabrak navbar */
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: none;
            position: relative;
            z-index: 10;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: #e0e7ff;
            color: #764ba2;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
        }

        /* Role Badge Custom */
        .badge-role {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .role-admin { background: #fee2e2; color: #dc2626; }
        .role-dosen { background: #dcfce7; color: #16a34a; }
        .role-mahasiswa { background: #fef9c3; color: #ca8a04; }

        /* Card Menu Styles */
        .menu-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            background: white;
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: inline-block;
            padding: 20px;
            border-radius: 20px;
        }

        /* Button Styling */
        .btn-action {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            color: white;
        }

        .logout-btn:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-university me-2"></i> SIAKAD KAMPUS</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block">Halo, <strong><?= explode(' ', $_SESSION['nama'])[0] ?></strong></span>
            <a href="logout.php" class="btn logout-btn btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container pb-5">
    <div class="row">
        <div class="col-12">
            <!-- Banner Sapaan -->
            <div class="welcome-banner mb-5">
                <div class="d-flex align-items-center">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1"><?= $sapaan ?>, <?= $_SESSION['nama'] ?>!</h3>
                        <?php 
                            $role_class = 'role-' . strtolower($_SESSION['role']);
                        ?>
                        <span class="badge-role <?= $role_class ?>">
                            <i class="fas fa-id-badge me-1"></i> <?= $_SESSION['role'] ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-4 text-secondary">Menu Utama</h5>
    
    <div class="row g-4">
        
        <!-- FITUR KHUSUS ADMIN -->
        <?php if ($_SESSION['role'] == 'admin') : ?>
            <div class="col-md-4">
                <div class="card menu-card shadow-sm p-4">
                    <div class="card-icon bg-light text-primary">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4 class="fw-bold">Panel Admin</h4>
                    <p class="text-muted small">Kelola data mahasiswa, dosen, serta pengaturan sistem RBAC.</p>
                    <a href="manage_users.php" class="btn btn-primary btn-action w-100">Kelola User</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- FITUR KHUSUS DOSEN -->
<?php if ($_SESSION['role'] == 'dosen') : ?>
    <div class="row g-4"> 
        <!-- Card 1: Akses Form Input -->
        <div class="col-md-4"> 
            <div class="card menu-card shadow-sm p-4">
                <div class="card-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h4 class="fw-bold">Input Nilai</h4>
                <p class="text-muted small">Masukkan nilai tugas, UTS, dan UAS mahasiswa bimbingan Anda.</p>
                <a href="input_nilai.php" class="btn btn-success btn-action w-100">Buka Gradebook</a>
            </div>
        </div>

        
        <div class="col-md-4"> 
            <div class="card menu-card shadow-sm p-4">
                <div class="card-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <h4 class="fw-bold">Kelola Nilai</h4>
                <p class="text-muted small">Lihat, edit, atau hapus nilai mahasiswa yang sudah diinput.</p>
                
                <a href="kelola_nilai.php#tabel-nilai" class="btn btn-primary btn-action w-100">Manajemen Nilai</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- FITUR KHUSUS MAHASISWA -->
        
        <?php if ($_SESSION['role'] == 'mahasiswa') : ?>
            <div class="row g-4"> <!-- Tambahkan row di sini -->
                
                <div class="col-md-4">
                    <div class="card menu-card shadow-sm p-4">
                        <div class="card-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4 class="fw-bold">Hasil Studi</h4>
                        <p class="text-muted small">Pantau perkembangan nilai Anda secara real-time.</p>
                        <a href="lihat-nilai.php" class="btn btn-warning btn-action w-100 text-white">Lihat Nilai</a>
                    </div>
                </div> 


            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>