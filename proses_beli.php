// proses_beli.php
<?php
session_start();
// Simpan ke keranjang atau langsung checkout
$id = $_POST['produk_id'];
// Tambahkan logika sesuai kebutuhan
header("Location: checkout.php?id=$id&aksi=beli");
exit;
?>