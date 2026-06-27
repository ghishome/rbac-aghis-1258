<?php
include 'config.php';
session_start();

if ($_SESSION['role'] !== 'dosen') { header("Location: login.php"); exit; }

// Logika Simpan Nilai
if (isset($_POST['simpan_nilai'])) {
    $mhs_id = $_POST['mahasiswa_id'];
    $dsn_id = $_SESSION['id'];
    $matkul = mysqli_real_escape_string($conn, $_POST['matkul']);
    $skor   = $_POST['skor'];
    
    // Tentukan Grade berdasarkan skor (Logika sederhana)
    $grade = ($skor >= 80) ? 'A' : (($skor >= 70) ? 'B' : 'C');

    $query = "INSERT INTO nilai (mahasiswa_id, dosen_id, mata_kuliah, skor, keterangan) 
              VALUES ('$mhs_id', '$dsn_id', '$matkul', '$skor', '$grade')";
    mysqli_query($conn, $query);
    $msg = "Nilai berhasil diinput!";
}

// Ambil daftar mahasiswa untuk dropdown
$mahasiswa = mysqli_query($conn, "SELECT id, nama_lengkap FROM users WHERE role = 'mahasiswa'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Input Nilai - Dosen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7fe; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <a href="dashboard.php" class="btn btn-sm btn-outline-secondary mb-3">← Kembali</a>
                <div class="card p-4">
                    <h4 class="fw-bold mb-4 text-center">📝 Input Nilai Mahasiswa</h4>
                    <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Pilih Mahasiswa</label>
                            <select name="mahasiswa_id" class="form-select" required>
                                <?php while($m = mysqli_fetch_assoc($mahasiswa)): ?>
                                    <option value="<?= $m['id'] ?>"><?= $m['nama_lengkap'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <input type="text" name="matkul" class="form-control" placeholder="Contoh: Keamanan Data" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Skor (0-100)</label>
                            <input type="number" name="skor" class="form-control" min="0" max="100" required>
                        </div>
                        <button type="submit" name="simpan_nilai" class="btn btn-primary w-100 p-2 fw-bold">SIMPAN NILAI</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>