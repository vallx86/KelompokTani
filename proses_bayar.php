<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produk_id = intval($_POST['produk_id']);
    $jumlah = intval($_POST['jumlah']);

    $query = "SELECT * FROM produk WHERE id = $produk_id";
    $result = $koneksi->query($query);

    if ($result->num_rows === 1) {
        $produk = $result->fetch_assoc();
        if ($jumlah > $produk['stok']) {
            echo "<script>alert('Jumlah melebihi stok tersedia'); window.history.back();</script>";
            exit;
        }

        $total = $produk['harga'] * $jumlah;

        // Kurangi stok
        $new_stok = $produk['stok'] - $jumlah;
        $update = "UPDATE produk SET stok = $new_stok WHERE id = $produk_id";
        $koneksi->query($update);

        echo "<h2>Pembayaran Berhasil</h2>";
        echo "<p>Produk: " . htmlspecialchars($produk['nama']) . "</p>";
        echo "<p>Jumlah Dibeli: $jumlah</p>";
        echo "<p>Total Harga: Rp " . number_format($total, 0, ',', '.') . "</p>";
        echo "<a href='index.html'>Kembali ke Beranda</a>";
    } else {
        echo "Produk tidak ditemukan.";
    }
} else {
    echo "Akses tidak valid.";
}
?>
