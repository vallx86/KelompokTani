<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "root";
$db = "petani_genz2";

// koneksi
$koneksi = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Set charset
$koneksi->set_charset("utf8");

//  user sudah login apa blum
function isLoggedIn()
{
    return isset($_SESSION['username']);
}

//username
function getUsername()
{
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

//mendapatkan inisial nama
function getInitials($name)
{
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    return substr($initials, 0, 2); // Maksimal 2 huruf
}

//redirect jika belum login
function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../auth/login.html");
        exit;
    }
}
?>