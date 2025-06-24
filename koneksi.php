<?php
$host = "localhost";
$user = "root";
$pass = "root"; // Ganti sesuai password kamu
$db = "petani_genz";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>