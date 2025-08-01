<?php
// pages/about.html
$base_url = '../';
require_once '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - PetaniGenZ</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <section class="hero-about">
        <div class="hero-content-about">
            <h1>
                Kami adalah mitra terpercaya para petani, yang berdedikasi untuk mendorong perubahan positif dalam
                pertanian Indonesia
            </h1>
            <p>
                PetaniGenZ adalah perusahaan rintisan Teknologi Pertanian di Indonesia, yang menjadi pelopor yang
                terdepan
                dalam menyediakan solusi terpadu dan menyeluruh dengan mengatasi berbagai permasalahan petani kecil.
                Kami hadir untuk memastikan setiap petani menerima dukungan yang mereka butuhkan untuk tumbuh dan
                berkembang.
            </p>
        </div>
    </section>

    <section class="vision-mission-section-about">
        <h2 class="section-title-about">Visi dan Misi Kami</h2>
        <div class="cards-container-about">
            <div class="card-about">
                <div class="card-header-about">VISI</div>
                <div class="card-body-about">
                    <p>
                        Menjadi platform pertanian digital terdepan yang mendukung petani Indonesia,
                        khususnya generasi muda (Gen Z), dalam mengakses teknologi, informasi,
                        dan produk pertanian berkualitas untuk mewujudkan pertanian yang modern, mandiri, dan
                        berkelanjutan.
                    </p>
                </div>
            </div>
            <div class="card-about">
                <div class="card-header-about">MISI</div>
                <div class="card-body-about">
                    <p>
                        1. Menyediakan produk pertanian yang berkualitas<br>
                        2. Memberdayakan petani muda<br>
                        3. Menjadi pusat edukasi pertanian modern<br>
                        4. Memfasilitasi konektivitas antar pelaku pertanian<br>
                        5. Mendukung pertanian berkelanjutan dan ramah lingkungan
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="who1">
        <section class="petaniGenZ-style-section">
            <div class="petaniGenZ-container">
                <div class="petaniGenZ-image">
                    <img src="../assets/Images/rival-removebg-preview.png" alt="Rizky Rivaldy">
                </div>
                <div class="petaniGenZ-text">
                    <p class="quote">
                        <span class="quote-mark">"</span>
                        Rizky Rivaldy saat ini sedang menempuh pendidikan S1 di bidang Informatika di
                        Universitas Muhammadiyah Semarang, Indonesia. Selama masa studi, ia aktif dalam
                        berbagai kegiatan organisasi kemahasiswaan, termasuk Badan Eksekutif Mahasiswa
                        (BEM) dan Himpunan Mahasiswa Informatika (HIMA). Rizky memiliki keahlian khusus
                        di bidang desain antarmuka pengguna (UI Design), dan telah berkontribusi dalam berbagai
                        proyek desain digital baik dalam lingkup akademik maupun organisasi. Minatnya mencakup
                        desain pengalaman pengguna, pengembangan aplikasi berbasis pengguna, serta integrasi
                        estetika dalam solusi teknologi
                        <br><br>
                    <p class="quote-bold">Selalu tampilkan yang terbaik.</p>
                    <p class="author-name">Rizky Rivaldy</p>
                    <p class="author-role">C2C023067</p>
                </div>
            </div>
        </section>

        <section class="petaniGenZ-style-section reverse">
            <div class="petaniGenZ-container">
                <div class="petaniGenZ-text">
                    <p class="quote">
                        <span class="quote-mark">"</span>
                        M.Faiz TsulistiyoZaen, saya mahasiswa Program Studi S1 Informatika di Universitas Muhammadiyah
                        Semarang (Unimus) yang memiliki rasa ingin tahu tentang bagaimana sebuah sistem bekerja maka
                        dari
                        itu saya mengambil jurusan tersebut, disisi lain saya juga aktif sebagai atlit pencak silat
                        tapak
                        suci putera muhammadiyah, bagi saya hal tersebut sudah menjadi bagian dari kehidupan saya karena
                        kepribadian yang suka beraktivitas khususnya dibidang olahraga. Semoga dengan hal-hal yang saya
                        miliki dapat bermanfaat bagi khalayak luas dan terkhusus bagi diri saya sendiri Aamiin.
                        <br><br>
                    <p class="quote-bold">Percaya pada diri sendiri.</p>
                    <p class="author-name">M.Faiz Tsulistiyo Z</p>
                    <p class="author-role">C2C023045</p>
                </div>
                <div class="petaniGenZ-image">
                    <img src="../assets/Images/faiz-removebg-preview.png" alt="M.Faiz Tsulistiyo Z">
                </div>
            </div>
        </section>

        <section class="petaniGenZ-style-section">
            <div class="petaniGenZ-container">
                <div class="petaniGenZ-image">
                    <img src="../assets/Images/rizal-removebg-preview.png" alt="M.Syahrizal Ibnu K">
                </div>
                <div class="petaniGenZ-text">
                    <p class="quote">
                        <span class="quote-mark">"</span>
                        Muhammad Shahrizal Ibnu Khoiryan, saya mahasiswa program studi S1 Informatika di Universitas
                        Muhammadiyah Semarang (UNIMUS) yang memiliki minat terhadap dunia teknologi dan cyber security.
                        Selama masa perkuliahan saya telah mempelajari berbagai hal tentang jaringan dan pembuatan web,
                        saya juga tertarik pada penggunaan teknologi untuk memberikan dampak positif dalam masyarakat.
                        Semangat saya dalam bidang teknologi tidak hanya bertujuan untuk pengembangan diri, tetapi juga
                        untuk berkontribusi dalam menciptakan solusi inovatif yang dapat membantu masyarakat
                        <br><br>
                    <p class="quote-bold">Kerja ikhlas pasti tuntas.</p>
                    <p class="author-name">M.Shahrizal Ibnu K</p>
                    <p class="author-role">C2C023059</p>
                </div>
            </div>
        </section>
    </section>

    <?php include '../includes/footer.php'; ?>
</body>

</html>