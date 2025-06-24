<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaniGenZ - Pestisida</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
                <a href="Pestisida.php" class="btn-green">Pestisida</a>
                <a href="Drone.php" class="btn-outline">Drone</a>
                <a href="AlatTani.php" class="btn-outline">Alat Tani</a>
                <a href="Tractor.php" class="btn-outline">Tractor</a>
            </div>
        </section>

        <section class="products">
            <?php
        $query = "SELECT * FROM produk WHERE kategori='pestisida'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($produk = $result->fetch_assoc()) {
                echo '<div class="card">
                        <div class="circle-img">
                            <img src="Image/pestisida/' . $produk["gambar"] . '" alt="' . $produk["nama"] . '">
                        </div>
                        <div class="title-placeholder">' . $produk["nama"] . '</div>
                        <div class="text-content">';
                // Pisah deskripsi ke dalam <p>
                $deskripsi = explode("\n", $produk["deskripsi"]);
                foreach ($deskripsi as $line) {
                    echo '<p>' . htmlspecialchars($line) . '</p>';
                }
                echo    '</div>
                        <div class="bottom-row">
                            <div class="price">Rp. ' . number_format($produk["harga"], 0, ',', '.') . '</div>
                            <button class="buy-btn">Beli</button>
                        </div>
                    </div>';
            }
        } else {
            echo "<p>Tidak ada produk pestisida ditemukan.</p>";
        }

        $conn->close();
        ?>
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