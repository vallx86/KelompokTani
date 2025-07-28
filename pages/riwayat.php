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
    <link rel="stylesheet" href="/KelompokTani/assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php
    // Tambahkan function getStatusBadgeCSS() jika belum ada
    if (function_exists('getStatusBadgeCSS')) {
        echo getStatusBadgeCSS();
    }
    ?>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
            color: #333;
        }

        /* Status Badge Styles - Jika function getStatusBadgeCSS() tidak ada */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-active {
            background: #cce5ff;
            color: #004085;
            border: 1px solid #b8daff;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Container */
        .riwayat-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            min-height: calc(100vh - 200px);
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* Summary Statistics */
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #4CAF50, #2e7d32);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 8px;
            display: block;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            margin-bottom: 0;
            border-bottom: none;
            background: white;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .tab {
            flex: 1;
            padding: 20px 25px;
            cursor: pointer;
            border: none;
            background: white;
            font-size: 16px;
            font-weight: 600;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
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

        .tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: #4CAF50;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .tab.active::after {
            width: 100%;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .history-list {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            min-height: 400px;
        }

        /* History Items */
        .history-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 25px;
            padding: 25px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
            align-items: start;
            position: relative;
        }

        .history-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #4CAF50, #2e7d32);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .history-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .history-item:hover::before {
            opacity: 1;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        /* Product Image */
        .product-image {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        /* Item Details */
        .item-details h3 {
            margin: 0 0 12px 0;
            color: #2e7d32;
            font-size: 1.3rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .item-details p {
            margin: 8px 0;
            color: #666;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .item-details strong {
            color: #333;
            font-weight: 600;
        }

        /* Item Meta */
        .item-meta {
            text-align: right;
            min-width: 180px;
        }

        .item-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 12px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .item-date {
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        /* Rental Info */
        .rental-info {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            padding: 15px;
            border-radius: 12px;
            margin-top: 12px;
            border-left: 4px solid #2196f3;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .rental-dates {
            font-weight: bold;
            color: #1976d2;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .rental-duration {
            color: #666;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 30px;
            color: #666;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 25px;
            opacity: 0.6;
            color: #ccc;
        }

        .empty-state h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .empty-state p {
            margin-bottom: 25px;
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-shop {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-shop:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .riwayat-container {
                padding: 15px;
                margin: 15px auto;
            }

            .page-header {
                padding: 30px 20px;
            }

            .page-title {
                font-size: 2rem;
            }

            .history-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 20px;
            }

            .item-meta {
                text-align: center;
            }

            .tabs {
                flex-direction: column;
            }

            .tab {
                border-bottom: 1px solid #eee;
                border-radius: 0;
            }

            .tab:last-child {
                border-bottom: none;
            }

            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-card {
                padding: 20px 15px;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .product-image {
                width: 80px;
                height: 80px;
                margin: 0 auto;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .history-item {
                padding: 20px 15px;
            }
            
            .summary-stats {
                grid-template-columns: 1fr;
            }
            
            .item-price {
                font-size: 1.3rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Smooth Transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Focus States untuk Accessibility */
        .tab:focus,
        .btn-shop:focus {
            outline: 2px solid #4CAF50;
            outline-offset: 2px;
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
                <div class="stat-number"><?php echo function_exists('formatRupiah') ? formatRupiah($total_pengeluaran) : 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'); ?></div>
                <div class="stat-label">Total Pengeluaran Beli</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo function_exists('formatRupiah') ? formatRupiah($total_sewa_cost) : 'Rp ' . number_format($total_sewa_cost, 0, ',', '.'); ?></div>
                <div class="stat-label">Total Biaya Sewa</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('transaksi')">
                Riwayat Pembelian (<?php echo $total_transaksi; ?>)
            </button>
            <button class="tab" onclick="showTab('sewa')">
                Riwayat Sewa (<?php echo $total_sewa; ?>)
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
                                        <p><strong>Status:</strong> 
                                            <?php
                                            if (function_exists('getStatusBadge')) {
                                                echo getStatusBadge($transaksi['status']);
                                            } else {
                                                // Fallback jika function tidak ada
                                                $status_class = 'status-' . $transaksi['status'];
                                                echo '<span class="status-badge ' . $status_class . '">' . ucfirst($transaksi['status']) . '</span>';
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <div class="item-meta">
                                        <div class="item-price"><?php echo function_exists('formatRupiah') ? formatRupiah($transaksi['total_harga']) : 'Rp ' . number_format($transaksi['total_harga'], 0, ',', '.'); ?></div>
                                        <div class="item-date">
                                            <?php echo date('d/m/Y H:i', strtotime($transaksi['created_at'])); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php endwhile; ?>
                <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon"></div>
                            <h3>Belum Ada Pembelian</h3>
                            <p>Anda belum melakukan pembelian apapun. Yuk mulai berbelanja produk pertanian berkualitas!</p>
                            <a href="<?php echo $base_url; ?>/produk/" class="btn-shop">Mulai Belanja</a>
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
                                            <?php
                                            if (function_exists('getStatusBadge') && function_exists('getStatusSewaByDate')) {
                                                echo getStatusBadge(getStatusSewaByDate($sewa['status'], $sewa['tanggal_mulai'], $sewa['tanggal_selesai']));
                                            } else {
                                                // Fallback jika function tidak ada
                                                $status_class = 'status-' . $sewa['status'];
                                                echo '<span class="status-badge ' . $status_class . '">' . ucfirst($sewa['status']) . '</span>';
                                            }
                                            ?>
                                        </p>

                                        <div class="rental-info">
                                            <div class="rental-dates">
                                                📅 <?php echo function_exists('formatTanggal') ? formatTanggal($sewa['tanggal_mulai']) : date('d/m/Y', strtotime($sewa['tanggal_mulai'])); ?> -
                                                <?php echo function_exists('formatTanggal') ? formatTanggal($sewa['tanggal_selesai']) : date('d/m/Y', strtotime($sewa['tanggal_selesai'])); ?>
                                            </div>
                                            <div class="rental-duration">
                                                Biaya: Rp 200.000/hari × <?php echo $sewa['durasi_hari']; ?> hari
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-meta">
                                        <div class="item-price"><?php echo function_exists('formatRupiah') ? formatRupiah($sewa['total_harga']) : 'Rp ' . number_format($sewa['total_harga'], 0, ',', '.'); ?></div>
                                        <div class="item-date">
                                            📋 Dipesan: <?php echo date('d/m/Y H:i', strtotime($sewa['created_at'])); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php endwhile; ?>
                <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon"></div>
                            <h3>Belum Ada Sewa Drone</h3>
                            <p>Anda belum pernah menyewa drone. Coba sewa drone pertanian untuk efisiensi kerja yang maksimal!
                            </p>
                            <a href="<?php echo $base_url; ?>pages/produk/?kategori=drone" class="btn-shop">Lihat Drone</a>
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

        // Add loading animation when switching tabs
        function showTabWithLoading(tabName) {
            const targetTab = document.getElementById(tabName + '-tab');
            const historyList = targetTab.querySelector('.history-list');
            
            // Add loading state
            historyList.style.opacity = '0.5';
            
            setTimeout(() => {
                showTab(tabName);
                historyList.style.opacity = '1';
            }, 200);
        }

        // Enhanced tab switching with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabName = this.onclick.toString().match(/showTab\('(.+?)'\)/)[1];
                    showTabWithLoading(tabName);
                });
            });
        });
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html>