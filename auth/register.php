<?php
// auth/register.php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>
            alert('Semua field harus diisi!');
            window.location.href = 'register.html';
        </script>";
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Format email tidak valid!');
            window.location.href = 'register.html';
        </script>";
        exit;
    }

    // Cek apakah username sudah ada
    $stmt = $koneksi->prepare("SELECT id FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('Username atau email sudah terdaftar!');
            window.location.href = 'register.html';
        </script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru
    $stmt = $koneksi->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href = 'login.html';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan saat registrasi!');
            window.location.href = 'register.html';
        </script>";
    }

    $stmt->close();
}
?>