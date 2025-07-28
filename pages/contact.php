<?php
// pages/contact.html
$base_url = '../';
require_once '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main>
        <section class="hero-Contact">
            <h1>Kontak Kami</h1>
            <p><br>Temukan Kami Di</p>
            <div class="Contact-logo">
                <img src="../assets/Images/LOGO.png" alt="Logo" />
                <h1>PetaniGenZ</h1>
            </div>
            <a href="https://wa.me/+6289621104071" class="Contact-Button">Hubungi Kami</a>
        </section>
    </main>

    <footer>
        <div class="Footer-Contact">
            <div class="Footer-Contact-Section">
                <div class="logo-title">
                    <img src="../assets/Images/LOGO.png" alt="logo">
                    <h1>PetaniGenZ</h1>
                </div>
                <h4>KANTOR PUSAT</h4>
                <p><i class="fas fa-map-marker-alt icon"></i>
                    <a href="https://maps.app.goo.gl/XXaMaYLRtggsUYLVA">Jl. Kedungmundu No.18, Kedungmundu, Kec. Tembalang,
                        <br>Kota Semarang, Jawa Tengah 50273</a>
                </p>
                <p><i class="fas fa-envelope icon"></i>
                    <a href="support@PetaniGenZ.co.id">support@PetaniGenZ.co.id</a>
                </p>
                <p><i class="fas fa-phone icon"></i>
                    +62 896 xxxx xxxx</p>
                <p><i class="fa-brands fa-whatsapp"></i>
                    +62 813 xxxx xxxx</p>

            </div>

            <div class="Footer-Contact-Section">
                <div class="Contact-Sosmed">
                    <h4>Social Media</h4>
                    <li><a href="#"><img src="../assets/Images/icon/instagram1.png" alt="Instagram" height="20px" width="20px">@PetaniGenZ</a></li>
                    <li><a href="#"><img src="../assets/Images/icon/yt.png" alt="yt.png" height="20px" width="20px"> @PetaniGenZ</a></li>
                    <li><a href="#"><img src="../assets/Images/icon/fb.png" alt="Facebook" height="20px" width="20px">@PetaniGenZ</a></li>
                </div>
            </div>
        </div>
        <div class="Footer-Contact">
            <p> © 2025 Contact Us Page. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>