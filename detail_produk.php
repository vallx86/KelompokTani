<?php
// detail_produk.php
$conn = new mysqli("localhost", "root", "root", "petani_genz");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = intval($_GET['id']); // amankan id dari URL
$sql = "SELECT * FROM produk WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $produk = $result->fetch_assoc();
} else {
    echo "<p>Produk tidak ditemukan.</p>";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk - <?php echo htmlspecialchars($produk['nama']); ?></title>
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

    <main class="detail-container">
        <div class="detail-card">
            <div class="image-section">
                <img src="Image/pestisida/<?php echo htmlspecialchars($produk['gambar']); ?>"
                    alt="<?php echo htmlspecialchars($produk['nama']); ?>">
            </div>
            <div class="info-section">
                <h2><?php echo htmlspecialchars($produk['nama']); ?></h2>
                <p class="price">Harga: Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                <p class="description"><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>

                <div class="action-buttons">
                    <form action="proses_beli.php" method="POST" style="display:inline-block;">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <button type="submit" class="buy-btn">Beli</button>
                    </form>

                    <form action="proses_sewa.php" method="POST" style="display:inline-block;">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <div class="action-buttons">
                        <form action="proses_beli.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                            <button type="submit" class="buy-btn">Beli</button>
                        </form>

                        <?php if (strtolower($produk['kategori']) === 'drone'): ?>
                        <form action="proses_sewa.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                            <button type="submit" class="rent-btn">Sewa</button>
                        </form>
                        <?php endif; ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <style>
        .detail-container {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .detail-card {
            display: flex;
            flex-direction: row;
            background: #f5f5f5;
            border-radius: 10px;
            overflow: hidden;
            max-width: 900px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .image-section img {
            width: 400px;
            height: auto;
            object-fit: cover;
        }

        .info-section {
            padding: 20px;
            flex: 1;
        }

        .info-section h2 {
            margin-top: 0;
        }

        .price {
            font-size: 1.2em;
            font-weight: bold;
            color: green;
            margin: 10px 0;
        }

        .description {
            margin: 15px 0;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .buy-btn,
        .rent-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 25px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .rent-btn {
            background-color: #ffc107;
            color: black;
        }
    </style>
</body>

</html>