<?php
// pages/index.php
$base_url = '../';
require_once '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-right">
                <img src="../assets/images/Hasilpanen.png" alt="icon" class="hero-img">
            </div>
            <div class="hero-left">
                <h1>ORDER & SEWA<br>YANG KAMU BUTUHKAN</h1>
                <p class="desc">
                    Kami menyediakan berbagai produk pertanian serta layanan penyewaan alat tani modern untuk
                    membantu meningkatkan produktivitas dan efisiensi kerja para petani di seluruh penjuru Indonesia.
                </p>
                <div class="buttons">
                    <a href="produk/" class="btn-green">Order Sekarang</a>
                    <a href="tutorial.html" class="btn-outline">Informasi Lain →</a>
                </div>
            </div>
        </section>

        <!-- Produk Unggulan -->
        <section class="products">
            <?php
            // Ambil 4 produk unggulan
            $query = "SELECT * FROM produk ORDER BY RAND() LIMIT 4";
            $result = $koneksi->query($query);

            if ($result && $result->num_rows > 0) {
                while ($produk = $result->fetch_assoc()) {
                    $image_path = "../assets/images/products/" . strtolower($produk['kategori']) . "/" . $produk['gambar'];
                    ?>
                    <div class="card">
                        <div class="circle-img">
                            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
                        </div>
                        <div class="title-placeholder"><?php echo htmlspecialchars($produk['nama']); ?></div>
                        <div class="text-content">
                            <p><?php echo htmlspecialchars(substr($produk['deskripsi'], 0, 100)) . '...'; ?></p>
                        </div>
                        <div class="bottom-row">
                            <div class="card-footer price">Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                            <a href="produk/detail_produk.php?id=<?php echo $produk['id']; ?>"
                                class="buy-btn btn-sm btn-primary d-block btnDetail">Detail</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>Tidak ada produk untuk ditampilkan.</p>';
            }
            ?>

            <!-- Tombol Telusuri -->
            <div class="btn-outline">
                <a class="link-style" href="produk/">Telusuri lebih Banyak ></a>
            </div>
        </section>

        <!-- Edukasi -->
        <section class="who1">
            <div class="who-right">
                <img src="../assets/images/padi2.png" alt="Tutorial Menanam" class="hero-img">
            </div>
            <div class="whotxt-right">
                <h1>Kamu Tidak Tahu Cara Menanam Yang Baik?</h1>
                <p class="desc">
                    Sekarang kamu juga bisa menanam sendiri dan juga bisa belajar dari sini dari cara menanam,
                    merawat tanaman, memupuk dan lainnya.
                    <br>Tenang, kami siap panduan lengkapnya. Yuk, ikuti Tutorial dari kami!
                </p>
                <div class="buttons">
                    <a class="btn-green" href="tutorial.html">Tutorial</a>
                </div>
            </div>
        </section>

        <?php include '../includes/footer.php'; ?>
    </main>
</body>

</html>