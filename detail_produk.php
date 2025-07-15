<?php
$conn = new mysqli("localhost", "root", "root", "petani_genz");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM produk WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows === 1) {
    $produk = $result->fetch_assoc();
} else {
    echo "<p>Produk tidak ditemukan.</p>";
    exit;
}

// Tangani pembayaran
$pesan_sukses = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah'])) {
    $jumlah = intval($_POST['jumlah']);

    if ($jumlah > 0 && $jumlah <= $produk['stok']) {
        $total = $produk['harga'] * $jumlah;
        $new_stok = $produk['stok'] - $jumlah;

        $update = "UPDATE produk SET stok = $new_stok WHERE id = $id";
        $conn->query($update);

        // Refresh data produk terbaru
        $produk['stok'] = $new_stok;
        $pesan_sukses = "Pembayaran berhasil. Jumlah: $jumlah, Total: Rp " . number_format($total, 0, ',', '.');
    } else {
        $pesan_sukses = "Jumlah tidak valid atau melebihi stok.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk - <?php echo htmlspecialchars($produk['nama']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function showPopup() {
            document.getElementById("popup-form").style.display = "block";
            updateTotal();
        }

        function hidePopup() {
            document.getElementById("popup-form").style.display = "none";
        }

        document.getElementById("jumlah").addEventListener("input", updateTotal);

        function updateTotal() {
            const harga = parseInt(document.getElementById("harga_satuan").value);
            const jumlah = parseInt(document.getElementById("jumlah").value);
            const total = harga * jumlah;
            document.getElementById("total").innerText = total.toLocaleString("id-ID");
        }
        function hideSuccessPopup() {
            document.getElementById("popup-success").style.display = "none";
        }

    </script>

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
                    <form action="proses_bayar.php" method="POST" style="display:inline-block;">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <button type="button" class="buy-btn" onclick="showPopup()">Beli</button>
                    </form>

                    <form action="proses_sewa.php" method="POST" style="display:inline-block;">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <div class="action-buttons">

                            <?php if (strtolower($produk['kategori']) === 'drone'): ?>
                                <form action="proses_sewa.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                                    <button type="button" class="buy-btn" onclick="showPopup()">sewa</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
             <div id="popup-form" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="hidePopup()">&times;</span>
                    <h3>Konfirmasi Pembelian</h3>
                    <form action="" method="POST">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <input type="hidden" id="harga_satuan" value="<?php echo $produk['harga']; ?>">
                        <p>Jumlah Barang:</p>
                        <input type="number" name="jumlah" id="jumlah" min="1" max="<?php echo $produk['stok']; ?>"
                            value="1" required>
                        <p>Total Harga: Rp <span id="total">0</span></p>
                        <button type="submit" class="buy-btn">Bayar</button>
                    </form>
                </div>
            </div>
            <div id="popup-success" class="popup" <?php if ($pesan_sukses)
                echo 'style="display:block;"'; ?>>
                <div class="popup-content">
                    <span class="close" onclick="hideSuccessPopup()">&times;</span>
                    <h3>Transaksi Berhasil</h3>
                    <p><?php echo $pesan_sukses; ?></p>
                    <a href="toko_organik.php" class="buy-btn">Kembali ke Beranda</a>
                </div>
            </div>

        </div>
    </main>

    <style>
        .popup {
            display: none;
            position: fixed;
            z-index: 99;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .popup-content {
            background-color: #fff;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 400px;
            border-radius: 10px;
            position: relative;
        }
        .close {
            color: #aaa;
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
        }
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