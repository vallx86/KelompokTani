<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaniGenZ</title>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Keranjang</a></li>
                <li><a href="About.html">About us</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-right">
                <img src="Image/Hasil panen.png" alt="icon" class="hero-img">
            </div>
            <div class="hero-left">
                <h1>ORDER & SEWA<br>YANG KAMU BUTUHKAN</h1>
                <p class="desc">
                    Kami menyediakan berbagai produk pertanian serta layanan penyewaan alat tani modern untuk
                    membantu meningkatkan produktivitas dan efisiensi kerja para petani di seluruh penjuru Indonesia.
                </p>
                <div class="buttons">
                    <button class="btn-green">Order Sekarang</button>
                    <button class="btn-outline">Informasi Lain →</button>
                </div>
            </div>
        </section>

        <!-- Produk Unggulan -->
        <section class="products">
            <!-- Kartu 1 -->
            <div class="card">
                <div class="circle-img">
                    <img src="Image/kompos.jpg" alt="Pupuk Kompos">
                </div>
                <div class="title-placeholder">Pupuk Kompos</div>
                <div class="text-content">
                    <p>Pupuk kompos organik</p>
                    <p>dapat digunakan untuk</p>
                    <p>semua jenis tanaman</p>
                </div>
                <div class="bottom-row">
                    <div class="card-footer price">Rp. 50.000</div>
                    <a class="buy-btn btn-sm btn-primary d-block btnDetail">Detail</a>
                </div>
            </div>

            <!-- Kartu 2 -->
            <div class="card">
                <div class="circle-img">
                    <img src="Image/Radoc.jpg" alt="Insektisida">
                </div>
                <div class="title-placeholder">Insektisida</div>
                <div class="text-content">
                    <p>Insektisida Radoc 500 EC</p>
                    <p>berbentuk cair untuk mengusir</p>
                    <p>tikus, burung, serangga</p>
                </div>
                <div class="bottom-row">
                    <div class="card-footer price">Rp. 35.000</div>
                    <a class="buy-btn btn-sm btn-primary d-block btnDetail">Detail</a>
                </div>
            </div>

            <!-- Kartu 3 -->
            <div class="card">
                <div class="circle-img">
                    <img src="Image/boster lengkeng.jpg" alt="Booster Lengkeng">
                </div>
                <div class="title-placeholder">Booster Lengkeng</div>
                <div class="text-content">
                    <p>untuk merangsang munculnya</p>
                    <p>bunga/bakal buah pada</p>
                    <p>tanaman kelengkeng</p>
                </div>
                <div class="bottom-row">
                    <div class="card-footer price">Rp. 40.000</div>
                    <a class="buy-btn btn-sm btn-primary d-block btnDetail">Detail</a>
                </div>
            </div>

            <!-- Kartu 4 -->
            <div class="card">
                <div class="circle-img">
                    <img src="Image/biji benih.jpg" alt="Benih Cover Crop">
                </div>
                <div class="title-placeholder">Benih Cover Crop</div>
                <div class="text-content">
                    <p>Kacang Kacangan Mucuna</p>
                    <p>Bracteata (MB) - 1 kg</p>
                    <p>&nbsp;</p> <!-- Untuk keselarasan tinggi -->
                </div>
                <div class="bottom-row">
                    <div class="card-footer price">Rp. 50.000</div>
                    <a class="buy-btn btn-sm btn-primary d-block btnDetail">Detail</a>
                </div>
            </div>

            <!-- Tombol Telusuri -->
            <div class="btn-outline">
                <a class="link-style" href="produk.html">Telusuri lebih Banyak ></a>
            </div>
        </section>

        <!-- Edukasi -->
        <section class="who1">
            <div class="who-right">
                <img src="Image/padi (2).png" alt="Tutorial Menanam" class="hero-img">
            </div>
            <div class="whotxt-right">
                <h1>Kamu Tidak Tahu Cara Menanam Yang Baik?</h1>
                <p class="desc">
                    Sekarang kamu juga bisa menanam sendiri dan juga bisa belajar dari sini dari cara menanam,
                    merawat tanaman, memupuk dan lainnya.
                    <br>Tenang, kami siap panduan lengkapnya. Yuk, ikuti Tutorial dari kami!
                </p>
                <div class="buttons">
                    <a class="btn-green" href="TutorialTanam.html">Tutorial</a>
                </div>
            </div>
        </section>

        <!-- Jual Produk -->
        <!-- <section class="who2">
            <div class="who-left">
                <img src="Image/padi (1).png" alt="Jual Produk" class="hero-img">
            </div>
            <div class="whotxt-left">
                <h1>Ingin Jual Produk Pertanianmu? Kami Siap Bantu!</h1>
                <p class="desc">
                    Sekarang kamu bisa buka toko sendiri dan jual berbagai hasil pertanian, alat, atau produk
                    lokalmu langsung lewat aplikasi ini!
                    <br>Tenang, kami siap panduan lengkapnya — yuk, mulai perjalanan jualan onlinemu bareng kami hari ini!
                </p>
                <div class="buttons">
                    <a class="btn-green" href="TutorialTanam.html">Tutorial</a>
                </div>
            </div>
         </section> -->

        <!-- Footer -->
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
