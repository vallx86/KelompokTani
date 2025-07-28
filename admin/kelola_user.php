<?php
// admin/kelola_user.php
$base_url = '../';
require_once '../config/koneksi.php';
require_once '../includes/functions.php';

// Cek apakah user adalah admin
requireAdmin();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete_user') {
        $user_id = intval($_POST['user_id']);
        
        // Jangan hapus admin
        $stmt = $koneksi->prepare("SELECT username FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        
        if ($user && $user['username'] === 'admin') {
            $error = "Tidak dapat menghapus akun admin!";
        } else {
            // Hapus transaksi dan sewa terkait
            $koneksi->query("DELETE FROM transaksi WHERE user_id = $user_id");
            $koneksi->query("DELETE FROM sewa WHERE user_id = $user_id");
            
            // Hapus user
            $stmt = $koneksi->prepare("DELETE FROM user WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            
            if ($stmt->execute()) {
                $success = "User berhasil dihapus!";
            } else {
                $error = "Gagal menghapus user!";
            }
        }
    }
}

// Ambil data user
$user_query = "SELECT * FROM user ORDER BY created_at DESC";
$user_result = $koneksi->query($user_query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Dashboard</title>
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

        .user-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
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

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-view {
            background: #007bff;
            color: white;
        }

        .btn-view:hover {
            background: #0056b3;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-admin {
            background: #cce5ff;
            color: #004085;
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
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="admin-container">
        <a href="dashboard.php" class="back-btn">← Kembali ke Dashboard</a>

        <div class="page-header">
            <h1>👥 Kelola Pengguna</h1>
            <p>Kelola data pengguna yang terdaftar di platform</p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Statistik User -->
        <div class="stats-cards">
            <?php
            $total_users = $koneksi->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];
            $admin_users = $koneksi->query("SELECT COUNT(*) as total FROM user WHERE username = 'admin'")->fetch_assoc()['total'];
            $regular_users = $total_users - $admin_users;
            $active_users = $koneksi->query("SELECT COUNT(DISTINCT user_id) as total FROM transaksi")->fetch_assoc()['total'];
            ?>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_users; ?></div>
                <div class="stat-label">Total Pengguna</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $regular_users; ?></div>
                <div class="stat-label">Pengguna Regular</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $admin_users; ?></div>
                <div class="stat-label">Admin</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $active_users; ?></div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
        </div>

        <!-- Tabel User -->
        <div class="user-table">
            <div class="table-header">
                <h3>📋 Daftar Pengguna</h3>
            </div>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($user_result && $user_result->num_rows > 0): ?>
                            <?php while ($user = $user_result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <div class="user-avatar">
                                            <?php echo getInitials($user['username']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if ($user['username'] === 'admin'): ?>
                                            <span class="status-badge status-admin">Admin</span>
                                        <?php else: ?>
                                            <span class="status-badge status-active">Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <button class="action-btn btn-view" onclick="viewUserDetails(<?php echo $user['id']; ?>)">
                                            Lihat Detail
                                        </button>
                                        <?php if ($user['username'] !== 'admin'): ?>
                                            <button class="action-btn btn-delete" onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')">
                                                Hapus
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <p>Tidak ada data pengguna</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteUser(userId, username) {
            if (confirm(`Apakah Anda yakin ingin menghapus user "${username}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="${userId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function viewUserDetails(userId) {
            // Bisa ditambahkan modal atau redirect ke halaman detail user
            alert('Fitur detail user akan segera hadir!');
        }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>

</html> 