<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah user ada
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        // Login berhasil
        $_SESSION['username'] = $data['username']; // Simpan session
        echo "<script>
            alert('Login berhasil!');
            window.location.href = 'index.php';
        </script>";
    } else {
        // Gagal login
        echo "<script>
            alert('Username atau password salah!');
            window.location.href = 'login.html';
        </script>";
    }
}
?>