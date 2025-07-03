<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "petani_genz");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = intval($_POST['produk_id']);
$sql = "SELECT * FROM produk WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $produk = $result->fetch_assoc();
    if (strtolower($produk['kategori']) !== 'drone') {
        echo "Produk ini tidak bisa disewa.";
        exit;
    }

    // Lanjut ke halaman checkout sewa
    header("Location: checkout.php?id=$id&aksi=sewa");
    exit;
} else {
    echo "Produk tidak ditemukan.";
    exit;
}
?>
