<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

    if (mysqli_query($koneksi, $query)) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>