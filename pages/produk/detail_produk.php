<?php
// pages/produk/detail_produk.php
$base_url = '../../';
require_once '../../config/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = "SELECT * FROM produk WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $produk = $result->fetch_assoc();
} else {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

// Tangani pembayaran
$pesan_sukses = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah'])) {
    $jumlah = intval($_POST['jumlah']);

    if ($jumlah > 0 && $jumlah <= $produk['stok']) {
        $total = $produk['harga'] * $jumlah;
        $new_stok = $produk['stok'] - $jumlah;

        $update = "UPDATE produk SET stok = ? WHERE id = ?";
        $stmt_update = $koneksi->prepare($update);
        $stmt_update->bind_param("ii", $new_stok, $id);
        $stmt_update->execute();

        // Refresh data produk terbaru
        $produk['stok'] = $new_stok;
        $pesan_sukses = "Pembayaran berhasil. Jumlah: $jumlah, Total: Rp " . number_format($total, 0, ',', '.');
    } else {
        $pesan_sukses = "Jumlah tidak valid atau melebihi stok.";
    }
}

$image_path = "../../assets/images/products/" . strtolower($produk['kategori']) . "/" . $produk['gambar'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?php echo htmlspecialchars($produk['nama']); ?></title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <main class="detail-container">
        <div class="detail-card">
            <div class="image-section">
                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
            </div>
            <div class="info-section">
                <h2><?php echo htmlspecialchars($produk['nama']); ?></h2>
                <p class="price">Harga: Rp. <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                <p class="stock">Stok: <?php echo $produk['stok']; ?> tersedia</p>
                <p class="description"><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>

                <div class="action-buttons">
                    <?php if (isLoggedIn()): ?>
                        <button type="button" class="buy-btn" onclick="showPopup()">Beli</button>

                        <?php if (strtolower($produk['kategori']) === 'drone'): ?>
                            <button type="button" class="rent-btn" onclick="showRentPopup()">Sewa</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="../../auth/login.html" class="buy-btn">Login untuk Membeli</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Popup Form Beli -->
        <div id="popup-form" class="popup">
            <div class="popup-content">
                <span class="close" onclick="hidePopup()">&times;</span>
                <h3>Konfirmasi Pembelian</h3>
                <form action="" method="POST">
                    <input type="hidden" id="harga_satuan" value="<?php echo $produk['harga']; ?>">
                    <p>Jumlah Barang:</p>
                    <input type="number" name="jumlah" id="jumlah" min="1" max="<?php echo $produk['stok']; ?>"
                        value="1" required>
                    <p>Total Harga: Rp <span id="total">0</span></p>
                    <button type="submit" class="buy-btn">Bayar</button>
                </form>
            </div>
        </div>

        <!-- Popup Success -->
        <div id="popup-success" class="popup" <?php if ($pesan_sukses)
            echo 'style="display:block;"'; ?>>
            <div class="popup-content">
                <span class="close" onclick="hideSuccessPopup()">&times;</span>
                <h3>Transaksi Berhasil</h3>
                <p><?php echo $pesan_sukses; ?></p>
                <a href="index.php" class="buy-btn">Kembali ke Produk</a>
            </div>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>

    <script>
        function showPopup() {
            document.getElementById("popup-form").style.display = "block";
            updateTotal();
        }

        function hidePopup() {
            document.getElementById("popup-form").style.display = "none";
        }

        function hideSuccessPopup() {
            document.getElementById("popup-success").style.display = "none";
        }

        function updateTotal() {
            const harga = parseInt(document.getElementById("harga_satuan").value);
            const jumlah = parseInt(document.getElementById("jumlah").value) || 1;
            const total = harga * jumlah;
            document.getElementById("total").innerText = total.toLocaleString("id-ID");
        }

        // Event listener untuk update total saat jumlah berubah
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahInput = document.getElementById("jumlah");
            if (jumlahInput) {
                jumlahInput.addEventListener("input", updateTotal);
            }
        });
    </script>

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
            background-color: rgba(0, 0, 0, 0.5);
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
            color: #2e7d32;
        }

        .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #4CAF50;
            margin: 10px 0;
        }

        .stock {
            font-size: 1em;
            color: #666;
            margin: 10px 0;
        }

        .description {
            margin: 15px 0;
            line-height: 1.6;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .buy-btn,
        .rent-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .rent-btn {
            background-color: #ffc107;
            color: black;
        }

        .buy-btn:hover {
            background-color: #218838;
        }

        .rent-btn:hover {
            background-color: #e0a800;
        }
    </style>
</body>

</html>