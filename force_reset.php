<?php
include 'config.php';

echo "<h2>🛡️ Sistem Keamanan Data: Mass Password Reset</h2>";
echo "<hr>";

// Data user dan password asli yang ingin di-set
$data_users = [
    ['username' => 'admin1', 'password' => 'admin123'],
    ['username' => 'dosen1', 'password' => 'dosen123'],
    ['username' => 'mhs1',   'password' => 'mhs123']
];

foreach ($data_users as $user) {
    $uname = $user['username'];
    $pass  = $user['password'];
    
    // Proses Hashing Bcrypt
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    
    // Update ke Database
    $sql = "UPDATE users SET password = '$hash' WHERE username = '$uname'";
    
    if (mysqli_query($conn, $sql)) {
        echo "✅ User: <b>$uname</b> | Password: <code>$pass</code> | Status: <b>Berhasil di-hash</b><br>";
    } else {
        echo "❌ User: <b>$uname</b> | Status: <b>Gagal!</b> " . mysqli_error($conn) . "<br>";
    }
}

echo "<hr>";
echo "<b>Instruksi Selanjutnya:</b><br>";
echo "1. Hapus file ini dari server setelah digunakan (Prinsip Keamanan Data: Jangan tinggalkan file reset di server!).<br>";
echo "2. Silakan coba login satu per satu di <a href='index.php'>Halaman Login</a>.";
?>