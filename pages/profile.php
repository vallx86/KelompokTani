<?php
// pages/profile.php
$base_url = '../';
require_once '../config/koneksi.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    header("Location: ../auth/login.html");
    exit;
}

$username = getUsername();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            margin: 0 auto 20px;
            border: 4px solid #e8f5e8;
        }
        
        .profile-info h2 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .profile-info p {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .profile-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-profile {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }
        
        .btn-secondary:hover {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-danger {
            background-color: #f44336;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #da190b;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <div class="profile-container">
            <div class="profile-avatar">
                <?php echo getInitials($username); ?>
            </div>
            
            <div class="profile-info">
                <h2>Halo, <?php echo htmlspecialchars($username); ?>!</h2>
                <p>Selamat datang di PetaniGenZ. Kelola akun Anda dan nikmati pengalaman berbelanja yang menyenangkan.</p>
            </div>
            
            <div class="profile-actions">
                <a href="index.php" class="btn-profile btn-primary">Kembali ke Beranda</a>
                <a href="produk/" class="btn-profile btn-secondary">Lihat Produk</a>
                <a href="../auth/logout.php" class="btn-profile btn-danger">Logout</a>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>
    </main>
</body>
</html>