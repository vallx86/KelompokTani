<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar'); window.location.href='register.html';</script>";
    } else {
        mysqli_query($koneksi, "INSERT INTO user (username, password) VALUES ('$username', '$password')");
        echo "<script>alert('Registrasi berhasil!'); window.location.href='login.html';</script>";
    }
}
?>