<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "root", "petani_genz");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data produk kategori Alat Tani
$sql = "SELECT * FROM produk WHERE kategori='Alat Tani'";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PetaniGenZ - Alat Tani</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <div class="logo-title">
            <img src="Image/LOGO GENZ.png" alt="logo">
            <h1>PetaniGenZ</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Keranjang</a></li>
                <li><a href="About.html">About us</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="login.html">Log In</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="btn-header">
            <div>
                <a href="Toko_organik.php" class="btn-outline">Pupuk Organik</a>
                <a href="Anorganik.php" class="btn-outline">Pupuk Anorganik</a>
                <a href="Pestisida.php" class="btn-outline">Pestisida</a>
                <a href="Drone.php" class="btn-outline">Drone</a>
                <a href="AlatTani.php" class="btn-green">Alat Tani</a>
                <a href="Tractor.php" class="btn-outline">Tractor</a>
            </div>
        </section>

        <section class="products">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="circle-img">
                    <img src="<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>">
                </div>
                <div class="title-placeholder">
                    <?= $row['nama'] ?>
                </div>
                <div class="text-content">
                    <p>
                        <?= $row['deskripsi'] ?>
                    </p>
                </div>
                <div class="bottom-row">
                    <div class="price">Rp.
                        <?= number_format($row['harga'], 0, ',', '.') ?>
                    </div>
                    <button class="buy-btn">Beli</button>
                </div>
            </div>
            <?php endwhile; ?>
        </section>

        <section class="footer-info">
            <h3>Our Services</h3>
            <div class="services-container">
                <div class="service">
                    <div class="service-icon">
                        <img src="Image/friendly.png" alt="Eco Friendly">
                    </div>
                    <p>Eco-Friendly</p>
                </div>
                <div class="service">
                    <div class="service-icon">
                        <img src="Image/delivery.png" alt="Fast Delivery">
                    </div>
                    <p>Fast Delivery</p>
                </div>
                <div class="service">
                    <div class="service-icon">
                        <img src="Image/repeat.png" alt="Easy Returns">
                    </div>
                    <p>Easy Returns</p>
                </div>
            </div>
        </section>
    </main>

</body>

</html>