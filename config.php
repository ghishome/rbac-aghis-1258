<?php
$conn = mysqli_connect("localhost", "root", "", "kampus_rbac");

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>