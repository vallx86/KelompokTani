<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h2>Dashboard</h2>
    <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>

</html>