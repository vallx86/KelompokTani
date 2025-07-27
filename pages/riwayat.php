<?php
// pages/riwayat.php
$base_url = '../';
require_once '../config/koneksi.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    header("Location: ../auth/login.html");
    exit;
}

$user_id = getUserId();

// Ambil riwayat transaksi
$transaksi_query = "SELECT t.*, p.nama as nama_produk, p.gambar, p.kategori 
                    FROM transaksi t 
                    JOIN produk p ON t.produk_id = p.id 
                    WHERE t.user_id = ? 
                    ORDER BY t.created_at DESC";
$stmt = $koneksi->prepare($transaksi_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$transaksi_result = $stmt->get_result();

// Ambil riwayat sewa
$sewa_query = "SELECT s.*, p.nama as nama_produk, p.gambar, p.kategori 
               FROM sewa s 
               JOIN produk p ON s.produk_id = p.id 
               WHERE s.user_id = ? 
               ORDER BY s.created_at DESC";
$stmt = $koneksi->prepare($sewa_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$sewa_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian & Sewa - PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <?php echo getStatusBadgeCSS(); ?>
    <style>
        .riwayat-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            color: #2e7d32;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            background: white;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .tab {
            flex: 1;
            padding: 20px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: bold;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            text-align: center;
        }

        .tab.active {
            color: #4CAF50;
            border-bottom-color: #4CAF50;
            background: #f8f9fa;
        }

        .tab:hover {
            color: #4CAF50;
            background: #f8f9fa;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .history-list {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .history-item {
            display: grid;
            grid-template-columns: 80px 1fr auto;
            gap: 20px;
            padding: 25px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
        }

        .history-item:hover {
            background: #f8f9fa;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            background: #f5f5f5;
        }

        .item-details h3 {
            margin: 0 0 8px 0;
            color: #333;
            font-size: 18px;
        }

        .item-details p {
            margin: 4px 0;
            color: #666;
            font-size: 14px;
        }

        .item-meta {
            text-align: right;
        }

        .item-price {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .item-date {
            color: #999;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .rental-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border-left: 4px solid #2196f3;
        }

        .rental-dates {
            font-weight: bold;
            color: #1976d2;
            font-size: 14px;
        }

        .rental-duration {
            color: #666;
            font-size: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .btn-shop {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-shop:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .history-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }

            .item-meta {
                text-align: center;
            }

            .tabs {
                flex-direction: column;
            }

            .summary-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="riwayat-container">
        <div class="page-header">
            <h1 class="page-title">📋 Riwayat Pembelian & Sewa</h1>
            <p>Pantau semua transaksi dan penyewaan Anda di PetaniGenZ</p>
        </div>

        <!-- Summary Statistics -->
        <div class="summary-stats">
            <?php
            $total_transaksi = $transaksi_result->num_rows;
            $total_sewa = $sewa_result->num_rows;

            // Hitung total pengeluaran
            $transaksi_result->data_seek(0);
            $total_pengeluaran = 0;
            while ($t = $transaksi_result->fetch_assoc()) {
                if ($t['status'] == 'success') {
                    $total_pengeluaran += $t['total_harga'];
                }
            }

            $sewa_result->data_seek(0);
            $total_sewa_cost = 0;
            while ($s = $sewa_result->fetch_assoc()) {
                if (in_array($s['status'], ['active', 'completed'])) {
                    $total_sewa_cost += $s['total_harga'];
                }
            }

            // Reset pointer
            $transaksi_result->data_seek(0);
            $sewa_result->data_seek(0);
            ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_transaksi; ?></div>
                <div class="stat-label">Total Pembelian</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_sewa; ?></div>
                <div class="stat-label">Total Sewa</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo formatRupiah($total_pengeluaran); ?></div>
                <div class="stat-label">Total Pengeluaran Beli</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo formatRupiah($total_sewa_cost); ?></div>
                <div class="stat-label">Total Biaya Sewa</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('transaksi')">
                🛒 Riwayat Pembelian (<?php echo $total_transaksi; ?>)
            </button>
            <button class="tab" onclick="showTab('sewa')">
                🚁 Riwayat Sewa (<?php echo $total_sewa; ?>)
            </button>
        </div>

        <!-- Tab Riwayat Transaksi -->
        <div id="transaksi-tab" class="tab-content active">
            <div class="history-list">
                <?php if ($transaksi_result && $transaksi_result->num_rows > 0): ?>
                    <?php while ($transaksi = $transaksi_result->fetch_assoc()): ?>
                        <div class="history-item">
                            <div class="product-image">
                                <img src="../assets/Images/<?php echo strtolower($transaksi['kategori']); ?>/<?php echo $transaksi['gambar']; ?>"
                                    alt="<?php echo htmlspecialchars($transaksi['nama_produk']); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                            </div>

                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($transaksi['nama_produk']); ?></h3>
                                <p><strong>Kategori:</strong> <?php echo ucfirst($transaksi['kategori']); ?></p>
                                <p><strong>Jumlah:</strong> <?php echo $transaksi['jumlah']; ?> unit</p>
                                <p><strong>Metode Pembayaran:</strong>
                                    <?php echo htmlspecialchars($transaksi['metode_bayar']); ?></p>
                                <p><strong>Status:</strong> <?php echo getStatusBadge($transaksi['status']); ?></p>
                            </div>

                            <div class="item-meta">
                                <div class="item-price"><?php echo formatRupiah($transaksi['total_harga']); ?></div>
                                <div class="item-date">
                                    <?php echo date('d/m/Y H:i', strtotime($transaksi['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">🛒</div>
                        <h3>Belum Ada Pembelian</h3>
                        <p>Anda belum melakukan pembelian apapun. Yuk mulai berbelanja produk pertanian berkualitas!</p>
                        <a href="produk/" class="btn-shop">Mulai Belanja</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab Riwayat Sewa -->
        <div id="sewa-tab" class="tab-content">
            <div class="history-list">
                <?php if ($sewa_result && $sewa_result->num_rows > 0): ?>
                    <?php while ($sewa = $sewa_result->fetch_assoc()): ?>
                        <div class="history-item">
                            <div class="product-image">
                                <img src="../assets/Images/<?php echo strtolower($sewa['kategori']); ?>/<?php echo $sewa['gambar']; ?>"
                                    alt="<?php echo htmlspecialchars($sewa['nama_produk']); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                            </div>

                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($sewa['nama_produk']); ?></h3>
                                <p><strong>Kategori:</strong> <?php echo ucfirst($sewa['kategori']); ?></p>
                                <p><strong>Durasi:</strong> <?php echo $sewa['durasi_hari']; ?> hari</p>
                                <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($sewa['metode_bayar']); ?>
                                </p>
                                <p><strong>Status:</strong>
                                    <?php echo getStatusBadge(getStatusSewaByDate($sewa['status'], $sewa['tanggal_mulai'], $sewa['tanggal_selesai'])); ?>
                                </p>

                                <div class="rental-info">
                                    <div class="rental-dates">
                                        📅 <?php echo formatTanggal($sewa['tanggal_mulai']); ?> -
                                        <?php echo formatTanggal($sewa['tanggal_selesai']); ?>
                                    </div>
                                    <div class="rental-duration">
                                        Biaya: Rp 200.000/hari × <?php echo $sewa['durasi_hari']; ?> hari
                                    </div>
                                </div>
                            </div>

                            <div class="item-meta">
                                <div class="item-price"><?php echo formatRupiah($sewa['total_harga']); ?></div>
                                <div class="item-date">
                                    📋 Dipesan: <?php echo date('d/m/Y H:i', strtotime($sewa['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">🚁</div>
                        <h3>Belum Ada Sewa Drone</h3>
                        <p>Anda belum pernah menyewa drone. Coba sewa drone pertanian untuk efisiensi kerja yang maksimal!
                        </p>
                        <a href="produk/?kategori=drone" class="btn-shop">Lihat Drone</a>
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
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>