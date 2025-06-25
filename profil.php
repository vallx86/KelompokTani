<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil - PetaniGenZ</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .profil-container {
            text-align: center;
            padding: 50px;
        }
        .profil-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profil-container h2 {
            margin-top: 20px;
            font-size: 24px;
        }
        .profil-container .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-title">
            <img src="Image/LOGO GENZ.png" alt="logo">
            <h1>PetaniGenZ</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Keranjang</a></li>
                <li><a href="About.html">About us</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="profil-container">
        <img src="Image/default-profile.png" alt="Foto Profil">
        <h2>Halo, <?= htmlspecialchars($username) ?>!</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </main>

</body>
</html>
