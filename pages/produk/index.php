<?php
// pages/produk/index.php
$base_url = '../../';
require_once '../../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - PetaniGenZ</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-left" style="text-align: center; width: 100%;">
                <h1>Produk Apa yang Ingin Kamu Beli?</h1>
                <p class="desc">Pilih kategori produk yang sesuai dengan kebutuhan pertanian Anda</p>
            </div>
        </section>

        <div class="kategori-grid-produk">
            <!-- Kategori 1 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/organik.png" alt="Pupuk Organik">
                <h2>Pupuk Organik</h2>
                <a href="organik.php" class="btn-produk">Lihat Produk</a>
            </div>

            <!-- Kategori 2 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/anorganik.png" alt="Pupuk Anorganik">
                <h2>Pupuk Anorganik</h2>
                <a href="anorganik.php" class="btn-produk">Lihat Produk</a>
            </div>

            <!-- Kategori 3 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/pestisida.png" alt="Pestisida">
                <h2>Pestisida</h2>
                <a href="pestisida.php" class="btn-produk">Lihat Produk</a>
            </div>

            <!-- Kategori 4 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/drone.png" alt="Drone">
                <h2>Drone</h2>
                <a href="drone.php" class="btn-produk">Lihat Produk</a>
            </div>

            <!-- Kategori 5 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/alat.png" alt="Alat Tani">
                <h2>Alat Tani</h2>
                <a href="alat_tani.php" class="btn-produk">Lihat Produk</a>
            </div>

            <!-- Kategori 6 -->
            <div class="kategori-box-produk">
                <img src="../../assets/Images/icon/traktor.png" alt="Traktor">
                <h2>Traktor</h2>
                <a href="traktor.php" class="btn-produk">Lihat Produk</a>
            </div>
        </div>

        <?php include '../../includes/footer.php'; ?>
    </main>
</body>
</html>