<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

require 'koneksi.php'; // pastikan file ini betul-betul berisi variabel $conn

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$sql = "SELECT * FROM produk";
if ($kategori != '') {
    $sql .= " WHERE kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Produk Kategori: <?= htmlspecialchars($kategori) ?></h1>
    <div class="produk-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="produk-card">
                <img src="<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>">
                <h2><?= $row['nama'] ?></h2>
                <p><?= $row['deskripsi'] ?></p>
                <p>Harga: Rp. <?= number_format($row['harga']) ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
