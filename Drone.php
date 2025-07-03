<?php
include 'koneksi.php'; // koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaniGenZ - Drone</title>
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
                <li><a href="#">Riwayat</a></li>
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
                <a href="Drone.php" class="btn-green">Drone</a>
                <a href="AlatTani.php" class="btn-outline">Alat Tani</a>
                <a href="Tractor.php" class="btn-outline">Tractor</a>
            </div>
        </section>

        <section class="products">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM produk WHERE kategori = 'drone'");
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <div class="card">
                    <div class="circle-img">
                    <img src="Image/drone/<?php echo $data['gambar']; ?>" alt="<?php echo $data['nama']; ?>">

                        <!-- Debug path -->
                        <!-- <p><?php echo $data['gambar']; ?></p> -->
                    </div>
                    <div class="title-placeholder"><?php echo $data['nama']; ?></div>
                    <div class="text-content">
                        <?php
                        $deskripsi = explode("\n", $data['deskripsi']);
                        foreach ($deskripsi as $baris) {
                            echo "<p>" . htmlspecialchars($baris) . "</p>";
                        }
                        ?>
                    </div>
                    <div class="bottom-row">
                        <div class="price">Rp. <?php echo number_format($data['harga'], 0, ',', '.'); ?></div>
                        <a href="detail_produk.php?id=' . $produk['id'] . '" class="buy-btn">Beli</a>
                    </div>
                </div>
            <?php } ?>
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