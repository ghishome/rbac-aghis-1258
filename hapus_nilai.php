<?php
include 'config.php';
session_start();

// Cek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Debug: Cek apakah ID terbaca
    // die("ID yang akan dihapus adalah: " . $id); 

    $query = "DELETE FROM nilai WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, balik ke halaman kelola
        header("Location: kelola_nilai.php?msg=hapus_ok");
        exit;
    } else {
        // Jika gagal query, tampilkan error SQL-nya
        die("Gagal menghapus: " . mysqli_error($conn));
    }
} else {
    die("ID tidak ditemukan di URL!");
}
?>