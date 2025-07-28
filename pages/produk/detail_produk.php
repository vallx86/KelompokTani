<?php
// pages/produk/detail_produk.php
$base_url = '../../';
require_once '../../config/koneksi.php';

// Ambil ID produk dari URL
$produk_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$produk_id) {
    header("Location: index.php");
    exit;
}

// Ambil detail produk
$stmt = $koneksi->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $produk_id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    header("Location: index.php");
    exit;
}

// Handle transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    if (isset($_POST['action'])) {
        $user_id = getUserId();

        if ($_POST['action'] === 'beli') {
            $jumlah = intval($_POST['jumlah']);
            $metode_bayar = $_POST['metode_bayar'];
            $total_harga = $produk['harga'] * $jumlah;

            // Cek stok
            if ($jumlah > $produk['stok']) {
                $error = "Stok tidak mencukupi!";
            } else {
                // Insert transaksi
                $stmt = $koneksi->prepare("INSERT INTO transaksi (user_id, produk_id, jumlah, total_harga, metode_bayar, status) VALUES (?, ?, ?, ?, ?, 'pending')");
                $stmt->bind_param("iisds", $user_id, $produk_id, $jumlah, $total_harga, $metode_bayar);

                if ($stmt->execute()) {
                    // Update stok
                    $new_stok = $produk['stok'] - $jumlah;
                    $update_stmt = $koneksi->prepare("UPDATE produk SET stok = ? WHERE id = ?");
                    $update_stmt->bind_param("ii", $new_stok, $produk_id);
                    $update_stmt->execute();

                    $success = "Pesanan berhasil dibuat! Silakan lakukan pembayaran.";
                    $produk['stok'] = $new_stok; // Update untuk tampilan
                } else {
                    $error = "Gagal membuat pesanan!";
                }
            }
        } elseif ($_POST['action'] === 'sewa' && $produk['kategori'] === 'drone') {
            $tanggal_mulai = $_POST['tanggal_mulai'];
            $tanggal_selesai = $_POST['tanggal_selesai'];
            $metode_bayar = $_POST['metode_bayar'];

            // Hitung durasi sewa dalam hari
            $start = new DateTime($tanggal_mulai);
            $end = new DateTime($tanggal_selesai);
            $interval = $start->diff($end);
            $durasi_hari = $interval->days + 1; // +1 karena termasuk hari pertama

            $harga_per_hari = 200000; // Rp 200.000 per hari
            $total_harga = $harga_per_hari * $durasi_hari;

            // Insert sewa
            $stmt = $koneksi->prepare("INSERT INTO sewa (user_id, produk_id, tanggal_mulai, tanggal_selesai, durasi_hari, total_harga, metode_bayar, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("iisssds", $user_id, $produk_id, $tanggal_mulai, $tanggal_selesai, $durasi_hari, $total_harga, $metode_bayar);

            if ($stmt->execute()) {
                $success = "Pemesanan sewa berhasil! Total: Rp " . number_format($total_harga, 0, ',', '.') . " untuk $durasi_hari hari.";
            } else {
                $error = "Gagal membuat pemesanan sewa!";
            }
        }
    }
}

$image_path = "../../assets/Images/" . strtolower($produk['kategori']) . "/" . $produk['gambar'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produk['nama']); ?> - PetaniGenZ</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        .detail-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .product-image {
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .product-info h1 {
            color: #2e7d32;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .product-category {
            background: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
            margin: 20px 0;
        }

        .product-stock {
            color: #666;
            margin-bottom: 20px;
        }

        .product-description {
            line-height: 1.6;
            color: #444;
            margin-bottom: 30px;
        }

        .purchase-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .tab {
            padding: 12px 24px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: bold;
            color: #666;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }

        .tab.active {
            color: #4CAF50;
            border-bottom-color: #4CAF50;
        }

        .tab:hover {
            color: #4CAF50;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .payment-option {
            position: relative;
        }

        .payment-option input[type="radio"] {
            display: none;
        }

        .payment-option label {
            display: block;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .payment-option input[type="radio"]:checked+label {
            border-color: #4CAF50;
            background: #f0f8f0;
            color: #4CAF50;
            font-weight: bold;
        }

        .payment-option label:hover {
            border-color: #4CAF50;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .rental-info {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }

        .rental-price {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .total-calculation {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border: 2px solid #4CAF50;
        }

        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 20px;
            }

            .payment-methods {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include '../../includes/header.php'; ?>

    <div class="detail-container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="product-detail">
            <div class="product-image">
                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
            </div>

            <div class="product-info">
                <span class="product-category"><?php echo ucfirst($produk['kategori']); ?></span>
                <h1><?php echo htmlspecialchars($produk['nama']); ?></h1>
                <div class="product-price">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></div>
                <div class="product-stock">
                    <strong>Stok tersedia:</strong> <?php echo $produk['stok']; ?> unit
                </div>
                <div class="product-description">
                    <?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?>
                </div>

                <?php if (isLoggedIn()): ?>
                    <div class="purchase-section">
                        <div class="tabs">
                            <button class="tab active" onclick="showTab('beli')">
                                 Beli Produk
                            </button>
                            <?php if ($produk['kategori'] === 'drone'): ?>
                                <button class="tab" onclick="showTab('sewa')">
                                     Sewa Drone
                                </button>
                            <?php endif; ?>
                        </div>

                        <!-- Tab Beli -->
                        <div id="beli-tab" class="tab-content active">
                            <form method="POST" onsubmit="return validatePurchase()">
                                <input type="hidden" name="action" value="beli">

                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" id="jumlah" name="jumlah" min="1"
                                        max="<?php echo $produk['stok']; ?>" value="1" required onchange="calculateTotal()">
                                </div>

                                <div class="total-calculation">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span>Harga per unit:</span>
                                        <span>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; color: #4CAF50;">
                                        <span>Total:</span>
                                        <span id="total-harga">Rp
                                            <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Metode Pembayaran</label>
                                    <div class="payment-methods">
                                        <div class="payment-option">
                                            <input type="radio" id="dana" name="metode_bayar" value="DANA" required>
                                            <label for="dana">💳 DANA</label>
                                        </div>
                                        <div class="payment-option">
                                            <input type="radio" id="ovo" name="metode_bayar" value="OVO" required>
                                            <label for="ovo">🟠 OVO</label>
                                        </div>
                                        <div class="payment-option">
                                            <input type="radio" id="gopay" name="metode_bayar" value="GoPay" required>
                                            <label for="gopay">🟢 GoPay</label>
                                        </div>
                                        <div class="payment-option">
                                            <input type="radio" id="bca" name="metode_bayar" value="Transfer BCA" required>
                                            <label for="bca">BCA</label>
                                        </div>
                                        <div class="payment-option">
                                            <input type="radio" id="mandiri" name="metode_bayar" value="Transfer Mandiri"
                                                required>
                                            <label for="mandiri">Mandiri</label>
                                        </div>
                                        <div class="payment-option">
                                            <input type="radio" id="bni" name="metode_bayar" value="Transfer BNI" required>
                                            <label for="bni">BNI</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit" <?php echo $produk['stok'] <= 0 ? 'disabled' : ''; ?>>
                                    <?php echo $produk['stok'] <= 0 ? 'Stok Habis' : ' Beli Sekarang'; ?>
                                </button>
                            </form>
                        </div>

                        <!-- Tab Sewa (khusus drone) -->
                        <?php if ($produk['kategori'] === 'drone'): ?>
                            <div id="sewa-tab" class="tab-content">
                                <div class="rental-info">
                                    <div class="rental-price"> Harga Sewa: Rp 200.000 per hari</div>
                                    <p><strong>Ketentuan Sewa:</strong></p>
                                    <ul>
                                        <li>Minimal sewa 1 hari</li>
                                        <li>Maksimal sewa 30 hari</li>
                                        <li>Termasuk panduan penggunaan</li>
                                        <li>Wajib mengembalikan dalam kondisi baik</li>
                                        <li>Denda keterlambatan: Rp 50.000/hari</li>
                                    </ul>
                                </div>

                                <form method="POST" onsubmit="return validateRental()">
                                    <input type="hidden" name="action" value="sewa">

                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai Sewa</label>
                                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                                            min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                                            onchange="calculateRentalTotal()">
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_selesai">Tanggal Selesai Sewa</label>
                                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                                            onchange="calculateRentalTotal()">
                                    </div>

                                    <div class="total-calculation" id="rental-calculation" style="display: none;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span>Durasi sewa:</span>
                                            <span id="rental-duration">0 hari</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                            <span>Harga per hari:</span>
                                            <span>Rp 200.000</span>
                                        </div>
                                        <div
                                            style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; color: #4CAF50;">
                                            <span>Total Biaya Sewa:</span>
                                            <span id="total-sewa">Rp 0</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Metode Pembayaran</label>
                                        <div class="payment-methods">
                                            <div class="payment-option">
                                                <input type="radio" id="dana-sewa" name="metode_bayar" value="DANA" required>
                                                <label for="dana-sewa">💳 DANA</label>
                                            </div>
                                            <div class="payment-option">
                                                <input type="radio" id="ovo-sewa" name="metode_bayar" value="OVO" required>
                                                <label for="ovo-sewa">🟠 OVO</label>
                                            </div>
                                            <div class="payment-option">
                                                <input type="radio" id="gopay-sewa" name="metode_bayar" value="GoPay" required>
                                                <label for="gopay-sewa">🟢 GoPay</label>
                                            </div>
                                            <div class="payment-option">
                                                <input type="radio" id="bca-sewa" name="metode_bayar" value="Transfer BCA"
                                                    required>
                                                <label for="bca-sewa">🏦 BCA</label>
                                            </div>
                                            <div class="payment-option">
                                                <input type="radio" id="mandiri-sewa" name="metode_bayar"
                                                    value="Transfer Mandiri" required>
                                                <label for="mandiri-sewa">🏦 Mandiri</label>
                                            </div>
                                            <div class="payment-option">
                                                <input type="radio" id="bni-sewa" name="metode_bayar" value="Transfer BNI"
                                                    required>
                                                <label for="bni-sewa">🏦 BNI</label>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-submit" id="sewa-button" disabled>
                                        Sewa Drone Sekarang
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="purchase-section">
                        <p style="text-align: center; color: #666; margin-bottom: 20px;">
                            Silakan login terlebih dahulu untuk melakukan pembelian atau penyewaan
                        </p>
                        <a href="../../auth/login.html" class="btn-submit"
                            style="display: block; text-align: center; text-decoration: none;">
                             Login untuk Membeli
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            event.target.classList.add('active');
        }

        function calculateTotal() {
            const jumlah = parseInt(document.getElementById('jumlah').value) || 1;
            const hargaPerUnit = <?php echo $produk['harga']; ?>;
            const total = jumlah * hargaPerUnit;

            document.getElementById('total-harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function calculateRentalTotal() {
            const startDate = document.getElementById('tanggal_mulai').value;
            const endDate = document.getElementById('tanggal_selesai').value;

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 karena termasuk hari pertama

                if (diffDays > 0) {
                    const hargaPerHari = 200000;
                    const totalBiaya = diffDays * hargaPerHari;

                    document.getElementById('rental-duration').textContent = diffDays + ' hari';
                    document.getElementById('total-sewa').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
                    document.getElementById('rental-calculation').style.display = 'block';
                    document.getElementById('sewa-button').disabled = false;
                } else {
                    document.getElementById('rental-calculation').style.display = 'none';
                    document.getElementById('sewa-button').disabled = true;
                }
            }
        }

        function validatePurchase() {
            const jumlah = parseInt(document.getElementById('jumlah').value);
            const stok = <?php echo $produk['stok']; ?>;

            if (jumlah > stok) {
                alert('Jumlah pembelian melebihi stok yang tersedia!');
                return false;
            }

            return confirm('Yakin ingin membeli produk ini?');
        }

        function validateRental() {
            const startDate = new Date(document.getElementById('tanggal_mulai').value);
            const endDate = new Date(document.getElementById('tanggal_selesai').value);
            const today = new Date();

            if (startDate <= today) {
                alert('Tanggal mulai sewa harus minimal besok!');
                return false;
            }

            if (endDate <= startDate) {
                alert('Tanggal selesai harus setelah tanggal mulai!');
                return false;
            }

            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            if (diffDays > 30) {
                alert('Maksimal sewa adalah 30 hari!');
                return false;
            }

            return confirm('Yakin ingin menyewa drone ini?');
        }

        // Set minimum date for rental
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minDate = tomorrow.toISOString().split('T')[0];

            document.getElementById('tanggal_mulai').setAttribute('min', minDate);

            // Update end date minimum when start date changes
            document.getElementById('tanggal_mulai').addEventListener('change', function () {
                const startDate = new Date(this.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                const minEndDate = nextDay.toISOString().split('T')[0];

                document.getElementById('tanggal_selesai').setAttribute('min', minEndDate);
                document.getElementById('tanggal_selesai').value = '';
                document.getElementById('rental-calculation').style.display = 'none';
                document.getElementById('sewa-button').disabled = true;
            });
        });
    </script>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>