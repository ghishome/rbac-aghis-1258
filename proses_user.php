<?php
include 'config.php';
session_start();

// Keamanan: Hanya Admin yang bisa akses file ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// --- LOGIKA TAMBAH USER ---
if (isset($_POST['tambah'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$username', '$password', '$nama', '$role')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?msg=tambah_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- LOGIKA EDIT USER ---
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role = $_POST['role'];

    // Cek apakah admin mengganti password atau tidak
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET username='$username', password='$password', nama_lengkap='$nama', role='$role' WHERE id='$id'";
    } else {
        // Jika password kosong, jangan update kolom password
        $query = "UPDATE users SET username='$username', nama_lengkap='$nama', role='$role' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?msg=edit_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// --- LOGIKA HAPUS USER ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Keamanan: Admin tidak boleh menghapus dirinya sendiri (opsional tapi bagus)
    if ($id == $_SESSION['id']) {
        header("Location: manage_users.php?msg=error_self");
        exit;
    }

    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_users.php?msg=hapus_sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>