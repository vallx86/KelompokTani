<?php
// config/koneksi.php
session_start();

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'petani_genz2';

// Koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);



// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Set charset
$koneksi->set_charset("utf8");

// Include functions jika file ada
$functions_path = __DIR__ . '/../includes/functions.php';
if (file_exists($functions_path)) {
    require_once $functions_path;
}

// Fungsi backup jika functions.php belum ada
if (!function_exists('isLoggedIn')) {
    function isLoggedIn()
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
}

if (!function_exists('getUsername')) {
    function getUsername()
    {
        return isset($_SESSION['username']) ? $_SESSION['username'] : '';
    }
}

if (!function_exists('getUserId')) {
    function getUserId()
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    }
}

if (!function_exists('getInitials')) {
    function getInitials($name)
    {
        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($initials) >= 2)
                break;
        }

        return empty($initials) ? 'U' : $initials;
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status)
    {
        $badges = [
            'pending' => '<span class="status-badge status-pending">Menunggu</span>',
            'success' => '<span class="status-badge status-success">Berhasil</span>',
            'failed' => '<span class="status-badge status-failed">Gagal</span>',
            'active' => '<span class="status-badge status-active">Aktif</span>',
            'completed' => '<span class="status-badge status-completed">Selesai</span>',
            'cancelled' => '<span class="status-badge status-cancelled">Dibatalkan</span>'
        ];

        return isset($badges[$status]) ? $badges[$status] : '<span class="status-badge">' . ucfirst($status) . '</span>';
    }
}

if (!function_exists('getStatusBadgeCSS')) {
    function getStatusBadgeCSS()
    {
        return '
        <style>
            .status-badge {
                padding: 4px 12px;
                border-radius: 15px;
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
            }
            .status-pending { background: #fff3cd; color: #856404; }
            .status-success { background: #d4edda; color: #155724; }
            .status-failed { background: #f8d7da; color: #721c24; }
            .status-active { background: #cce5ff; color: #004085; }
            .status-completed { background: #d1ecf1; color: #0c5460; }
            .status-cancelled { background: #f8d7da; color: #721c24; }
        </style>';
    }
}

if (!function_exists('requireAdmin')) {
    function requireAdmin()
    {
        if (!isLoggedIn() || getUsername() !== 'admin') {
            header("Location: ../auth/login.html");
            exit;
        }
    }
}

if (!function_exists('getAdminStats')) {
    function getAdminStats($koneksi)
    {
        $stats = [];

        // Total produk
        $result = $koneksi->query("SELECT COUNT(*) as total FROM produk");
        $stats['total_produk'] = $result->fetch_assoc()['total'];

        // Total user
        $result = $koneksi->query("SELECT COUNT(*) as total FROM user");
        $stats['total_user'] = $result->fetch_assoc()['total'];

        // Total transaksi
        $result = $koneksi->query("SELECT COUNT(*) as total FROM transaksi");
        $stats['total_transaksi'] = $result->fetch_assoc()['total'];

        // Total sewa
        $result = $koneksi->query("SELECT COUNT(*) as total FROM sewa");
        $stats['total_sewa'] = $result->fetch_assoc()['total'];

        // Total pendapatan bulan ini
        $result = $koneksi->query("SELECT COALESCE(SUM(total_harga), 0) as total FROM transaksi WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'success'");
        $stats['pendapatan_bulan_ini'] = $result->fetch_assoc()['total'];

        return $stats;
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal)
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $pecah = explode('-', $tanggal);
        if (count($pecah) >= 3) {
            return $pecah[2] . ' ' . $bulan[$pecah[1]] . ' ' . $pecah[0];
        }

        return $tanggal;
    }
}

if (!function_exists('getStatusSewaByDate')) {
    function getStatusSewaByDate($status, $tanggal_mulai, $tanggal_selesai)
    {
        $today = new DateTime();
        $start = new DateTime($tanggal_mulai);
        $end = new DateTime($tanggal_selesai);

        if ($status === 'pending') {
            return 'pending';
        } elseif ($status === 'cancelled') {
            return 'cancelled';
        } elseif ($today < $start) {
            return 'scheduled';
        } elseif ($today >= $start && $today <= $end) {
            return 'active';
        } elseif ($today > $end) {
            return 'completed';
        }

        return $status;
    }
}

?>