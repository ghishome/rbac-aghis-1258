<?php
include 'config.php';
session_start();

if ($_SESSION['role'] !== 'mahasiswa') { header("Location: login.php"); exit; }

$mhs_id = $_SESSION['id'];

// Query JOIN untuk mengambil nama dosen yang memberi nilai
$query = "SELECT nilai.*, users.nama_lengkap as nama_dosen 
          FROM nilai 
          JOIN users ON nilai.dosen_id = users.id 
          WHERE nilai.mahasiswa_id = '$mhs_id'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>KHS - Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7fe; }
        .table-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .thead-custom { background: #764ba2; color: white; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">🎓 Kartu Hasil Studi</h3>
            <a href="dashboard.php" class="btn btn-sm btn-secondary">Dashboard</a>
        </div>

        <div class="table-card p-4">
            <table class="table table-hover">
                <thead class="thead-custom">
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Dosen Pengampu</th>
                        <th class="text-center">Skor</th>
                        <th class="text-center">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['mata_kuliah'] ?></td>
                            <td><?= $row['nama_dosen'] ?></td>
                            <td class="text-center fw-bold"><?= $row['skor'] ?></td>
                            <td class="text-center">
                                <span class="badge <?= $row['keterangan'] == 'A' ? 'bg-success' : 'bg-primary' ?>">
                                    <?= $row['keterangan'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted">Belum ada nilai yang diinput.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>