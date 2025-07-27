<?php
// admin/kelola_transaksi.php
$base_url = '../';
require_once '../config/koneksi.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Handle update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_transaksi') {
        $transaksi_id = intval($_POST['transaksi_id']);
        $status = $_POST['status'];
        
        $stmt = $koneksi->prepare("UPDATE transaksi SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $transaksi_id);
        
        if ($stmt->execute()) {
            $success = "Status transaksi berhasil diperbarui!";
        } else {
            $error = "Gagal memperbarui status transaksi!";
        }
    } elseif ($_POST['action'] === 'update_sewa') {
        $sewa_id = intval($_POST['sewa_id']);
        $status = $_POST['status'];
        
        $stmt = $koneksi->prepare("UPDATE sewa SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $sewa_id);
        
        if ($stmt->execute()) {
            $success = "Status sewa berhasil diperbarui!";
        } else {
            $error = "Gagal memperbarui status sewa!";
        }
    }
}

// Ambil data transaksi
$transaksi_query = "SELECT t.*, u.username, p.nama as nama_produk, p.gambar, p.kategori 
                    FROM transaksi t 
                    JOIN user u ON t.user_id = u.id 
                    JOIN produk p ON t.produk_id = p.id 
                    ORDER BY t.created_at DESC";
$transaksi_result = $koneksi->query($transaksi_query);

// Ambil data sewa
$sewa_query = "SELECT s.*, u.username, p.nama as nama_produk, p.gambar, p.kategori 
               FROM sewa s 
               JOIN user u ON s.user_id = u.id 
               JOIN produk p ON s.produk_id = p.id 
               ORDER BY s.created_at DESC";
$sewa_result = $koneksi->query($sewa_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi & Sewa - Admin PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <?php echo getStatusBadgeCSS(); ?>
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .page-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
        }
        
        .tab {
            padding: 15px 30px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
            font-weight: bold;
            color: #666;
            border-bottom: 3px solid transparent;
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
        
        .data-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .data-grid {
            display: grid;
            gap: 15px;
            padding: 20px;
        }
        
        .data-item {
            display: grid;
            grid-template-columns: 60px 1fr auto auto auto;
            gap: 15px;
            align-items: center;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .data-item:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: #f5f5f5;
        }
        
        .item-info h4 {
            margin: 0 0 5px 0;
            color: #333;
        }
        
        .item-info p {
            margin: 2px 0;
            color: #666;
            font-size: 14px;
        }
        
        .item-price {
            font-weight: bold;
            color: #4CAF50;
            font-size: 16px;
        }
        
        .status-select {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .btn-update {
            background: #2196F3;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        
        .btn-update:hover {
            background: #1976D2;
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
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
        
        .rental-dates {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .data-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 10px;
            }
            
            .tabs {
                flex-direction: column;
            }
            
            .tab {
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="admin-container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="page-header">
            <div>
                <h2>💳 Kelola Transaksi & Sewa</h2>
                <p>Pantau dan kelola semua transaksi pembelian dan penyewaan</p>
            </div>
        </div>

        <!-- Statistik Summary -->
        <div class="stats-summary">
            <?php
            $stats = getAdminStats($koneksi);
            $pending_transaksi = $koneksi->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'pending'")->fetch_assoc()['total'];
            $active_sewa = $koneksi->query("SELECT COUNT(*) as total FROM sewa WHERE status = 'active'")->fetch_assoc()['total'];
            $pendapatan_sewa = $koneksi->query("SELECT COALESCE(SUM(total_harga), 0) as total FROM sewa WHERE status IN ('active', 'completed')")->fetch_assoc()['total'];
            ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $pending_transaksi; ?></div>
                <div class="stat-label">Transaksi Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $active_sewa; ?></div>
                <div class="stat-label">Sewa Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo formatRupiah($stats['pendapatan_bulan_ini']); ?></div>
                <div class="stat-label">Pendapatan Bulan Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo formatRupiah($pendapatan_sewa); ?></div>
                <div class="stat-label">Total Pendapatan Sewa</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="showTab('transaksi')">
                💰 Transaksi Pembelian (<?php echo $transaksi_result->num_rows; ?>)
            </button>
            <button class="tab" onclick="showTab('sewa')">
                🚁 Sewa Drone (<?php echo $sewa_result->num_rows; ?>)
            </button>
        </div>

        <!-- Tab Transaksi -->
        <div id="transaksi-tab" class="tab-content active">
            <div class="data-table">
                <div class="table-header">
                    <h3>📊 Daftar Transaksi Pembelian</h3>
                </div>
                
                <div class="data-grid">
                    <?php if ($transaksi_result && $transaksi_result->num_rows > 0): ?>
                        <?php while ($transaksi = $transaksi_result->fetch_assoc()): ?>
                            <div class="data-item">
                                <div class="product-image">
                                    <img src="../assets/images/products/<?php echo strtolower($transaksi['kategori']); ?>/<?php echo $transaksi['gambar']; ?>" 
                                         alt="<?php echo htmlspecialchars($transaksi['nama_produk']); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                </div>
                                
                                <div class="item-info">
                                    <h4><?php echo htmlspecialchars($transaksi['nama_produk']); ?></h4>
                                    <p><strong>Customer:</strong> <?php echo htmlspecialchars($transaksi['username']); ?></p>
                                    <p><strong>Jumlah:</strong> <?php echo $transaksi['jumlah']; ?> unit</p>
                                    <p><strong>Metode:</strong> <?php echo htmlspecialchars($transaksi['metode_bayar']); ?></p>
                                    <p><strong>Tanggal:</strong> <?php echo date('d/m/Y H:i', strtotime($transaksi['created_at'])); ?></p>
                                </div>
                                
                                <div class="item-price">
                                    <?php echo formatRupiah($transaksi['total_harga']); ?>
                                </div>
                                
                                <div>
                                    <?php echo getStatusBadge($transaksi['status']); ?>
                                </div>
                                
                                <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="hidden" name="action" value="update_transaksi">
                                    <input type="hidden" name="transaksi_id" value="<?php echo $transaksi['id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="pending" <?php echo $transaksi['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="success" <?php echo $transaksi['status'] == 'success' ? 'selected' : ''; ?>>Success</option>
                                        <option value="failed" <?php echo $transaksi['status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
                                    </select>
                                    <button type="submit" class="btn-update">Update</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; padding: 40px; color: #666;">Belum ada transaksi</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tab Sewa -->
        <div id="sewa-tab" class="tab-content">
            <div class="data-table">
                <div class="table-header">
                    <h3>🚁 Daftar Sewa Drone</h3>
                </div>
                
                <div class="data-grid">
                    <?php if ($sewa_result && $sewa_result->num_rows > 0): ?>
                        <?php while ($sewa = $sewa_result->fetch_assoc()): ?>
                            <div class="data-item">
                                <div class="product-image">
                                    <img src="../assets/images/products/<?php echo strtolower($sewa['kategori']); ?>/<?php echo $sewa['gambar']; ?>" 
                                         alt="<?php echo htmlspecialchars($sewa['nama_produk']); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                </div>
                                
                                <div class="item-info">
                                    <h4><?php echo htmlspecialchars($sewa['nama_produk']); ?></h4>
                                    <p><strong>Customer:</strong> <?php echo htmlspecialchars($sewa['username']); ?></p>
                                    <p><strong>Durasi:</strong> <?php echo $sewa['durasi_hari']; ?> hari</p>
                                    <p><strong>Metode:</strong> <?php echo htmlspecialchars($sewa['metode_bayar']); ?></p>
                                    <div class="rental-dates">
                                        📅 <?php echo formatTanggal($sewa['tanggal_mulai']); ?> - <?php echo formatTanggal($sewa['tanggal_selesai']); ?>
                                    </div>
                                    <p><strong>Dipesan:</strong> <?php echo date('d/m/Y H:i', strtotime($sewa['created_at'])); ?></p>
                                </div>
                                
                                <div class="item-price">
                                    <?php echo formatRupiah($sewa['total_harga']); ?>
                                    <div style="font-size: 12px; color: #666; margin-top: 5px;">
                                        (Rp 200.000/hari)
                                    </div>
                                </div>
                                
                                <div>
                                    <?php echo getStatusBadge(getStatusSewaByDate($sewa['status'], $sewa['tanggal_mulai'], $sewa['tanggal_selesai'])); ?>
                                </div>
                                
                                <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="hidden" name="action" value="update_sewa">
                                    <input type="hidden" name="sewa_id" value="<?php echo $sewa['id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="pending" <?php echo $sewa['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="active" <?php echo $sewa['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="completed" <?php echo $sewa['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="cancelled" <?php echo $sewa['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn-update">Update</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; padding: 40px; color: #666;">Belum ada data sewa</p>
                    <?php endif; ?>
                </div>
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