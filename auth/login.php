<?php
// auth/login.php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>
            alert('Username dan password harus diisi!');
            window.location.href = 'login.html';
        </script>";
        exit;
    }

    // Cek apakah user ada
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];

        echo "<script>
            alert('Login berhasil! Selamat datang, " . htmlspecialchars($user['username']) . "');
            window.location.href = '../pages/index.php';
        </script>";
    } else {
        // Gagal login
        echo "<script>
            alert('Username atau password salah!');
            window.location.href = 'login.html';
        </script>";
    }

    $stmt->close();
}
?>