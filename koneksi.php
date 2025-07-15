<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "petani_genz"; // Ganti sesuai nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
