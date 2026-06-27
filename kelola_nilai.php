<?php
include 'config.php';
session_start();

// Proteksi: Hanya Dosen dan Admin
if ($_SESSION['role'] !== 'dosen' && $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$dosen_id = $_SESSION['id'];
$query_nilai = mysqli_query($conn, "SELECT nilai.*, users.nama_lengkap 
                                   FROM nilai 
                                   JOIN users ON nilai.mahasiswa_id = users.id 
                                   WHERE nilai.dosen_id = '$dosen_id'
                                   ORDER BY nilai.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Nilai - SIAKAD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Poppins', sans-serif; }
        .card { border-radius: 20px; border: none; }
        .table thead { background: #f8fafc; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">Manajemen Nilai Mahasiswa</h3>
                <p class="text-muted">Lihat dan kelola nilai yang telah Anda berikan.</p>
            </div>
            <a href="dashboard.php" class="btn btn-outline-secondary"><i class="fas fa-home me-2"></i>Dashboard</a>
        </div>

        <div class="card shadow-sm p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">Skor</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($n = mysqli_fetch_assoc($query_nilai)) : ?>
                        <tr>
                            <td class="fw-bold"><?= $n['nama_lengkap'] ?></td>
                            <td><?= $n['mata_kuliah'] ?></td>
                            <td class="text-center"><?= $n['skor'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3"><?= $n['keterangan'] ?></span>
                            </td>
                            <td class="text-center">
                                <!-- Tombol Hapus -->
                                <a href="hapus_nilai.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>