<?php
// pages/produk/organik.php
$base_url = '../../';
require_once '../../config/koneksi.php';

$kategori = 'alat tani';
$judul = 'alat tani';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $judul; ?> - PetaniGenZ</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <main>
        <!-- Navigation Kategori -->
        <section class="btn-header">
            <div>
                <a href="organik.php" class="btn-outline">Pupuk Organik</a>
                <a href="anorganik.php" class="btn-outline">Pupuk Anorganik</a>
                <a href="pestisida.php" class="btn-outline">Pestisida</a>
                <a href="drone.php" class="btn-outline">Drone</a>
                <a href="alat_tani.php" class="btn-green">Alat Tani</a>
                <a href="traktor.php" class="btn-outline">Traktor</a>
            </div>
        </section>

        <!-- Produk Grid -->
        <section class="products">
            <?php
            $query = "SELECT * FROM produk WHERE kategori = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("s", $kategori);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($produk = $result->fetch_assoc()) {
                    $image_path = "../../assets/Images/alat_tani/" . $produk['gambar'];
                    ?>
                    <div class="card">
                        <div class="circle-img">
                            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
                        </div>
                        <div class="title-placeholder"><?php echo htmlspecialchars($produk['nama']); ?></div>
                        <!-- <div class="text-content">
                           <p><?php echo htmlspecialchars(substr($produk['deskripsi'], 0, 80)) . '...'; ?></p>
                        </div> -->
                        <div class="bottom-row">
                            <div class="price">Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                            <a href="detail_produk.php?id=<?php echo $produk['id']; ?>" class="buy-btn">Detail</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='no-product'><p>Tidak ada produk " . strtolower($judul) . " ditemukan.</p></div>";
            }
            ?>
        </section>

        <?php include '../../includes/footer.php'; ?>
    </main>
</body>

</html>