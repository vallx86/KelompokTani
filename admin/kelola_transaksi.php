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
    <title>Kelola Transaksi - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .back-btn {
            background: #666;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: #555;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        }

        .transaction-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .section-header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            font-weight: bold;
        }

        .table-content {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-active {
            background: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
        }

        .btn-update {
            background: #007bff;
            color: white;
        }

        .btn-update:hover {
            background: #0056b3;
        }

        .btn-view {
            background: #28a745;
            color: white;
        }

        .btn-view:hover {
            background: #218838;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .tab-buttons {
            display: flex;
            margin-bottom: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .tab-btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: #f8f9fa;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: #4CAF50;
            color: white;
        }

        .tab-btn:hover {
            background: #45a049;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="admin-container">
        <a href="dashboard.php" class="back-btn">← Kembali ke Dashboard</a>

        <div class="page-header">
            <h1>💳 Kelola Transaksi</h1>
            <p>Pantau dan kelola semua transaksi pembelian dan penyewaan</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Statistik Transaksi -->
        <div class="stats-cards">
            <?php
            $total_transaksi = $koneksi->query("SELECT COUNT(*) as total FROM transaksi")->fetch_assoc()['total'];
            $pending_transaksi = $koneksi->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'pending'")->fetch_assoc()['total'];
            $success_transaksi = $koneksi->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'success'")->fetch_assoc()['total'];
            $total_sewa = $koneksi->query("SELECT COUNT(*) as total FROM sewa")->fetch_assoc()['total'];
            $total_pendapatan = $koneksi->query("SELECT COALESCE(SUM(total_harga), 0) as total FROM transaksi WHERE status = 'success'")->fetch_assoc()['total'];
            ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_transaksi; ?></div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $pending_transaksi; ?></div>
                <div class="stat-label">Menunggu Pembayaran</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $success_transaksi; ?></div>
                <div class="stat-label">Transaksi Berhasil</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-buttons">
            <button class="tab-btn active" onclick="showTab('transaksi')">🛒 Transaksi Pembelian</button>
            <button class="tab-btn" onclick="showTab('sewa')">🚁 Transaksi Sewa</button>
        </div>

        <!-- Tab Transaksi Pembelian -->
        <div id="transaksi" class="tab-content active">
            <div class="transaction-section">
                <div class="section-header">
                    <h3>🛒 Transaksi Pembelian</h3>
                </div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Metode Bayar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transaksi_result && $transaksi_result->num_rows > 0): ?>
                                <?php while ($transaksi = $transaksi_result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $transaksi['id']; ?></td>
                                        <td><?php echo htmlspecialchars($transaksi['username']); ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <img src="../assets/Images/<?php echo strtolower($transaksi['kategori']); ?>/<?php echo $transaksi['gambar']; ?>" 
                                                     alt="<?php echo htmlspecialchars($transaksi['nama_produk']); ?>" 
                                                     class="product-img">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($transaksi['nama_produk']); ?></strong>
                                                    <br><small><?php echo ucfirst($transaksi['kategori']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $transaksi['jumlah']; ?></td>
                                        <td>Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($transaksi['metode_bayar']); ?></td>
                                        <td><?php echo getStatusBadge($transaksi['status']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($transaksi['created_at'])); ?></td>
                                        <td>
                                            <button class="action-btn btn-update" onclick="updateStatus('transaksi', <?php echo $transaksi['id']; ?>, '<?php echo $transaksi['status']; ?>')">
                                                Update Status
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px;">
                                        <p>Tidak ada data transaksi</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Transaksi Sewa -->
        <div id="sewa" class="tab-content">
            <div class="transaction-section">
                <div class="section-header">
                    <h3>🚁 Transaksi Sewa</h3>
                </div>
                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Produk</th>
                                <th>Tanggal Sewa</th>
                                <th>Durasi</th>
                                <th>Total Harga</th>
                                <th>Metode Bayar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($sewa_result && $sewa_result->num_rows > 0): ?>
                                <?php while ($sewa = $sewa_result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $sewa['id']; ?></td>
                                        <td><?php echo htmlspecialchars($sewa['username']); ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <img src="../assets/Images/<?php echo strtolower($sewa['kategori']); ?>/<?php echo $sewa['gambar']; ?>" 
                                                     alt="<?php echo htmlspecialchars($sewa['nama_produk']); ?>" 
                                                     class="product-img">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($sewa['nama_produk']); ?></strong>
                                                    <br><small><?php echo ucfirst($sewa['kategori']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y', strtotime($sewa['tanggal_mulai'])); ?> - 
                                            <?php echo date('d/m/Y', strtotime($sewa['tanggal_selesai'])); ?>
                                        </td>
                                        <td><?php echo $sewa['durasi_hari']; ?> hari</td>
                                        <td>Rp <?php echo number_format($sewa['total_harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($sewa['metode_bayar']); ?></td>
                                        <td><?php echo getStatusBadge($sewa['status']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($sewa['created_at'])); ?></td>
                                        <td>
                                            <button class="action-btn btn-update" onclick="updateStatus('sewa', <?php echo $sewa['id']; ?>, '<?php echo $sewa['status']; ?>')">
                                                Update Status
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px;">
                                        <p>Tidak ada data sewa</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        function updateStatus(type, id, currentStatus) {
            let statusOptions = '';
            
            if (type === 'transaksi') {
                statusOptions = `
                    <option value="pending" ${currentStatus === 'pending' ? 'selected' : ''}>Menunggu</option>
                    <option value="success" ${currentStatus === 'success' ? 'selected' : ''}>Berhasil</option>
                    <option value="failed" ${currentStatus === 'failed' ? 'selected' : ''}>Gagal</option>
                `;
            } else {
                statusOptions = `
                    <option value="pending" ${currentStatus === 'pending' ? 'selected' : ''}>Menunggu</option>
                    <option value="active" ${currentStatus === 'active' ? 'selected' : ''}>Aktif</option>
                    <option value="completed" ${currentStatus === 'completed' ? 'selected' : ''}>Selesai</option>
                    <option value="cancelled" ${currentStatus === 'cancelled' ? 'selected' : ''}>Dibatalkan</option>
                `;
            }
            
            const newStatus = prompt(`Update status untuk ${type} #${id}:\n\nPilih status baru:\n${statusOptions}`, currentStatus);
            
            if (newStatus && newStatus !== currentStatus) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="update_${type}">
                    <input type="hidden" name="${type}_id" value="${id}">
                    <input type="hidden" name="status" value="${newStatus}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html> 