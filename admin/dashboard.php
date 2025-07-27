<?php
// admin/dashboard.php
$base_url = '../';
require_once '../config/koneksi.php';

// Cek apakah user adalah admin
if (!isLoggedIn() || getUsername() !== 'admin') {
    header("Location: ../auth/login.html");
    exit;
}

// Statistik dashboard
$stats_query = "
    SELECT 
        (SELECT COUNT(*) FROM produk) as total_produk,
        (SELECT COUNT(*) FROM user) as total_user,
        (SELECT COUNT(*) FROM transaksi) as total_transaksi,
        (SELECT COUNT(*) FROM sewa) as total_sewa
";
$stats_result = $koneksi->query($stats_query);
$stats = $stats_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 5px solid #4CAF50;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
            font-size: 16px;
        }

        .admin-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .menu-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .menu-icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: #4CAF50;
        }

        .menu-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .menu-desc {
            color: #666;
            margin-bottom: 20px;
        }

        .btn-admin {
            background: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-admin:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .recent-activities {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>🌾 Admin Dashboard PetaniGenZ</h1>
            <p>Kelola seluruh sistem dan pantau aktivitas platform</p>
        </div>

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_produk']; ?></div>
                <div class="stat-label">Total Produk</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_user']; ?></div>
                <div class="stat-label">Total Pengguna</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_transaksi']; ?></div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_sewa']; ?></div>
                <div class="stat-label">Total Sewa</div>
            </div>
        </div>

        <!-- Menu Admin -->
        <div class="admin-menu">
            <div class="menu-card">
                <div class="menu-icon">📦</div>
                <div class="menu-title">Kelola Produk</div>
                <div class="menu-desc">Tambah, edit, dan hapus produk. Atur stok dan harga.</div>
                <a href="kelola_produk.php" class="btn-admin">Kelola Produk</a>
            </div>

            <div class="menu-card">
                <div class="menu-icon">👥</div>
                <div class="menu-title">Kelola Pengguna</div>
                <div class="menu-desc">Lihat dan kelola data pengguna yang terdaftar.</div>
                <a href="kelola_user.php" class="btn-admin">Kelola User</a>
            </div>

            <div class="menu-card">
                <div class="menu-icon">💳</div>
                <div class="menu-title">Kelola Transaksi</div>
                <div class="menu-desc">Pantau dan kelola semua transaksi pembelian.</div>
                <a href="kelola_transaksi.php" class="btn-admin">Kelola Transaksi</a>
            </div>

            <div class="menu-card">
                <div class="menu-icon">🚁</div>
                <div class="menu-title">Kelola Sewa Drone</div>
                <div class="menu-desc">Pantau dan kelola penyewaan drone pertanian.</div>
                <a href="kelola_sewa.php" class="btn-admin">Kelola Sewa</a>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="recent-activities">
            <h3>📊 Aktivitas Terbaru</h3>
            <?php
            $activity_query = "
                SELECT 'transaksi' as type, u.username, p.nama as item, t.created_at 
                FROM transaksi t 
                JOIN user u ON t.user_id = u.id 
                JOIN produk p ON t.produk_id = p.id 
                UNION ALL
                SELECT 'sewa' as type, u.username, p.nama as item, s.created_at
                FROM sewa s 
                JOIN user u ON s.user_id = u.id 
                JOIN produk p ON s.produk_id = p.id
                ORDER BY created_at DESC LIMIT 5
            ";
            $activities = $koneksi->query($activity_query);

            if ($activities && $activities->num_rows > 0):
                while ($activity = $activities->fetch_assoc()):
                    ?>
                    <div class="activity-item">
                        <div>
                            <strong><?php echo htmlspecialchars($activity['username']); ?></strong>
                            <?php echo $activity['type'] == 'transaksi' ? 'membeli' : 'menyewa'; ?>
                            <em><?php echo htmlspecialchars($activity['item']); ?></em>
                        </div>
                        <div style="color: #666; font-size: 14px;">
                            <?php echo date('d/m/Y H:i', strtotime($activity['created_at'])); ?>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <p style="text-align: center; color: #666;">Belum ada aktivitas</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>