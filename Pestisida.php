<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaniGenZ - Pestisida</title>
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
                <a href="Pestisida.php" class="btn-green">Pestisida</a>
                <a href="Drone.php" class="btn-outline">Drone</a>
                <a href="AlatTani.php" class="btn-outline">Alat Tani</a>
                <a href="Tractor.php" class="btn-outline">Tractor</a>
            </div>
        </section>

        <section class="products">
            <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "root", "petani_genz");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil data produk kategori pestisida
        $sql = "SELECT * FROM produk WHERE kategori = 'pestisida'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($produk = $result->fetch_assoc()) {
                echo '
                <div class="card">
                    <div class="circle-img">
                        <img src="Image/pestisida/' . htmlspecialchars($produk["gambar"]) . '" alt="' . htmlspecialchars($produk["nama"]) . '">
                    </div>
                    <div class="title-placeholder">' . htmlspecialchars($produk["nama"]) . '</div>
                    <div class="text-content">
                        <p>' . nl2br(htmlspecialchars($produk["deskripsi"])) . '</p>
                    </div>
                    <div class="bottom-row">
                        <div class="price">Rp. ' . number_format($produk["harga"], 0, ',', '.') . '</div>
                       <a href="detail_produk.php?id=' . $produk['id'] . '" class="buy-btn">Beli</a>
                    </div>
                </div>';
            }
        } else {
            echo "<p>Tidak ada produk pestisida yang tersedia.</p>";
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