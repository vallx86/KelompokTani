<?php
// includes/functions.php

// Fungsi untuk cek apakah user sudah login
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Fungsi untuk mendapatkan username yang sedang login
function getUsername()
{
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}

// Fungsi untuk mendapatkan user ID yang sedang login
function getUserId()
{
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
}

// Fungsi untuk mendapatkan email user yang sedang login
function getUserEmail()
{
    return isset($_SESSION['email']) ? $_SESSION['email'] : '';
}

// Fungsi untuk mendapatkan inisial nama untuk avatar
function getInitials($name)
{
    $words = explode(' ', trim($name));
    $initials = '';

    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        if (strlen($initials) >= 2)
            break; // Maksimal 2 huruf
    }

    return empty($initials) ? 'U' : $initials;
}

// Fungsi untuk format mata uang Rupiah
function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Fungsi untuk format tanggal Indonesia
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

// Fungsi untuk mendapatkan status badge
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

// Fungsi untuk validasi input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fungsi untuk generate order ID unik
function generateOrderId()
{
    return 'PGZ' . date('Ymd') . rand(1000, 9999);
}

// Fungsi untuk hitung durasi sewa dalam hari
function hitungDurasiSewa($tanggal_mulai, $tanggal_selesai)
{
    $start = new DateTime($tanggal_mulai);
    $end = new DateTime($tanggal_selesai);
    $interval = $start->diff($end);
    return $interval->days + 1; // +1 karena termasuk hari pertama
}

// Fungsi untuk cek apakah user adalah admin
function isAdmin()
{
    return isLoggedIn() && getUsername() === 'admin';
}

// Fungsi untuk redirect jika bukan admin
function requireAdmin()
{
    if (!isAdmin()) {
        header("Location: ../auth/login.html");
        exit;
    }
}

// Fungsi untuk get produk berdasarkan kategori
function getProdukByKategori($koneksi, $kategori, $limit = null)
{
    $query = "SELECT * FROM produk WHERE kategori = ?";
    if ($limit) {
        $query .= " LIMIT " . intval($limit);
    }

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $kategori);
    $stmt->execute();

    return $stmt->get_result();
}

// Fungsi untuk get transaksi user
function getTransaksiUser($koneksi, $user_id)
{
    $query = "SELECT t.*, p.nama as nama_produk, p.gambar, p.kategori 
              FROM transaksi t 
              JOIN produk p ON t.produk_id = p.id 
              WHERE t.user_id = ? 
              ORDER BY t.created_at DESC";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result();
}

// Fungsi untuk get sewa user
function getSewaUser($koneksi, $user_id)
{
    $query = "SELECT s.*, p.nama as nama_produk, p.gambar, p.kategori 
              FROM sewa s 
              JOIN produk p ON s.produk_id = p.id 
              WHERE s.user_id = ? 
              ORDER BY s.created_at DESC";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result();
}

// Fungsi untuk log aktivitas
function logActivity($koneksi, $user_id, $activity, $description = '')
{
    $stmt = $koneksi->prepare("INSERT INTO activity_log (user_id, activity, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $activity, $description);
    $stmt->execute();
}

// Fungsi untuk send notification (placeholder untuk sistem notifikasi)
function sendNotification($user_id, $title, $message, $type = 'info')
{
    // Implementasi sistem notifikasi bisa ditambahkan di sini
    // Misalnya menyimpan ke database, kirim email, atau push notification

    // Untuk sementara hanya log ke file
    $log_message = date('Y-m-d H:i:s') . " - User ID: $user_id - $type: $title - $message\n";
    file_put_contents('../logs/notifications.log', $log_message, FILE_APPEND | LOCK_EX);
}

// Fungsi untuk validasi tanggal sewa
function validateTanggalSewa($tanggal_mulai, $tanggal_selesai)
{
    $start = new DateTime($tanggal_mulai);
    $end = new DateTime($tanggal_selesai);
    $today = new DateTime();

    // Cek apakah tanggal mulai minimal besok
    if ($start <= $today) {
        return "Tanggal mulai sewa harus minimal besok!";
    }

    // Cek apakah tanggal selesai setelah tanggal mulai
    if ($end <= $start) {
        return "Tanggal selesai harus setelah tanggal mulai!";
    }

    // Cek durasi maksimal 30 hari
    $durasi = hitungDurasiSewa($tanggal_mulai, $tanggal_selesai);
    if ($durasi > 30) {
        return "Maksimal durasi sewa adalah 30 hari!";
    }

    return true; // Valid
}

// Fungsi untuk update stok produk
function updateStokProduk($koneksi, $produk_id, $jumlah_kurang)
{
    $stmt = $koneksi->prepare("UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ?");
    $stmt->bind_param("iii", $jumlah_kurang, $produk_id, $jumlah_kurang);

    return $stmt->execute() && $stmt->affected_rows > 0;
}

// Fungsi untuk get statistik dashboard admin
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

// Fungsi untuk cek ketersediaan drone untuk sewa
function cekKetersediaanDrone($koneksi, $produk_id, $tanggal_mulai, $tanggal_selesai)
{
    $query = "SELECT COUNT(*) as conflict FROM sewa 
              WHERE produk_id = ? 
              AND status IN ('pending', 'active') 
              AND (
                  (tanggal_mulai <= ? AND tanggal_selesai >= ?) OR
                  (tanggal_mulai <= ? AND tanggal_selesai >= ?) OR
                  (tanggal_mulai >= ? AND tanggal_selesai <= ?)
              )";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("issssss", $produk_id, $tanggal_mulai, $tanggal_mulai, $tanggal_selesai, $tanggal_selesai, $tanggal_mulai, $tanggal_selesai);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    return $result['conflict'] == 0; // True jika tidak ada konflik
}

// Fungsi untuk format status sewa berdasarkan tanggal
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
        return 'scheduled'; // Dijadwalkan
    } elseif ($today >= $start && $today <= $end) {
        return 'active'; // Sedang aktif
    } elseif ($today > $end) {
        return 'completed'; // Selesai
    }

    return $status;
}

// CSS untuk status badges
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

?>