<?php
// includes/header.php
if (!isset($koneksi)) {
    require_once __DIR__ . '/../config/koneksi.php';
}
?>

<header>
    <div class="logo-title">
        <img src="/KelompokTani/assets/Images/LOGO.png" alt="logo">
        <h1>PetaniGenZ</h1>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo $base_url; ?>pages/index.php">Home</a></li>
            <li><a href="<?php echo $base_url; ?>pages/produk/">Produk</a></li>
            <li><a href="<?php echo $base_url; ?>pages/riwayat.php">riwayat</a></li>
            <li><a href="<?php echo $base_url; ?>pages/about.php">About us</a></li>
            <li><a href="<?php echo $base_url; ?>pages/contact.php">Contact</a></li>

            <?php if (isLoggedIn()): ?>
                <!-- Profile dropdown -->
                <li class="profile-dropdown">
                    <div class="profile-circle">
                        <?php echo getInitials(getUsername()); ?>
                    </div>
                    <div class="dropdown-content">
                        <?php if (getUsername() === 'admin'): ?>
                            <a href="<?php echo $base_url; ?>admin/dashboard.php">Dashboard Admin</a>
                        <?php endif; ?>
                        <a href="<?php echo $base_url; ?>pages/profile.php">Profil</a>
                        <a href="<?php echo $base_url; ?>auth/logout.php">Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="<?php echo $base_url; ?>auth/login.html">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<style>
    /* Profile Circle Styles */
    .profile-dropdown {
        position: relative;
        display: inline-block;
    }

    .profile-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #4CAF50;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .profile-circle:hover {
        background-color: #45a049;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        z-index: 1000;
        margin-top: 5px;
    }

    .dropdown-content a {
        color: #333;
        padding: 8px 12px;
        text-decoration: none;
        display: block;
        font-size: 14px;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
        color: #4CAF50;
    }

    .profile-dropdown:hover .dropdown-content {
        display: block;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-circle {
            width: 30px;
            height: 30px;
            font-size: 11px;
        }

        .dropdown-content {
            min-width: 100px;
        }
    }
</style>