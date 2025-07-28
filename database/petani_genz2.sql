-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2025 at 11:23 AM
-- Server version: 8.0.16
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petani_genz2`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` enum('organik','anorganik','pestisida','drone','alat tani','traktor') NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  `deskripsi` text,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Pupuk Kompos Organik', 'organik', 50000.00, 100, 'Pupuk kompos organik berkualitas tinggi yang dapat digunakan untuk semua jenis tanaman. Membantu meningkatkan kesuburan tanah secara alami.', 'POP.png', '2025-07-26 01:44:41', '2025-07-27 05:38:49'),
(3, 'Booster Lengkeng', 'organik', 40000.00, 75, 'Pupuk khusus untuk merangsang munculnya bunga dan bakal buah pada tanaman kelengkeng. Meningkatkan produktivitas buah.', 'booster_lengkeng.jpg', '2025-07-26 01:44:41', '2025-07-26 01:44:41'),
(4, 'Benih Cover Crop Mucuna', 'organik', 50000.00, 25, 'Kacang-kacangan Mucuna Bracteata (MB) - 1 kg. Cocok untuk cover crop dan memperbaiki struktur tanah.', 'biji benih.jpg', '2025-07-26 01:44:41', '2025-07-27 05:37:51'),
(7, 'Pupuk Urea 50kg', 'anorganik', 185000.00, 50, 'Pupuk Urea merupakan pupuk nitrogen dengan kandungan N 46% yang sangat efektif untuk pertumbuhan vegetatif tanaman. Cocok untuk semua jenis tanaman pangan, hortikultura, dan perkebunan. Membantu mempercepat pertumbuhan daun dan batang tanaman.', 'pupuk urea.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(8, 'Pupuk NPK Phonska 50kg', 'anorganik', 195000.00, 36, 'Pupuk NPK Phonska dengan kandungan Nitrogen (N) 15%, Fosfor (P) 15%, dan Kalium (K) 15%. Pupuk majemuk yang lengkap untuk memenuhi kebutuhan nutrisi tanaman dari masa tanam hingga panen. Meningkatkan produktivitas dan kualitas hasil panen.', 'pupuk nitrogen.jpg', '2025-07-27 05:47:57', '2025-07-27 07:12:03'),
(9, 'Pupuk SP36 50kg', 'anorganik', 175000.00, 35, 'Pupuk Super Phosphate 36 (SP36) mengandung fosfor (P2O5) 36% yang sangat penting untuk pembentukan akar, bunga, dan buah. Cocok untuk aplikasi pada saat tanam sebagai pupuk dasar. Membantu meningkatkan sistem perakaran tanaman.', 'sp36.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(10, 'Pupuk ZA (Amonium Sulfat) 50kg', 'anorganik', 165000.00, 45, 'Pupuk ZA mengandung Nitrogen 21% dan Sulfur 24%. Cocok untuk tanaman yang membutuhkan sulfur seperti bawang, cabai, dan kedelai. Membantu pembentukan protein dan minyak pada tanaman serta meningkatkan ketahanan terhadap hama penyakit.', 'anorganik cair.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(11, 'Pupuk KCL (Kalium Klorida) 50kg', 'anorganik', 180000.00, 30, 'Pupuk KCL mengandung Kalium (K2O) 60% yang berperan penting dalam pembentukan buah, meningkatkan kualitas hasil, dan ketahanan tanaman terhadap kekeringan. Sangat baik untuk tanaman buah-buahan dan sayuran.', 'pupuk nitrogen.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(12, 'Pupuk TSP 50kg', 'anorganik', 190000.00, 25, 'Pupuk Triple Super Phosphate (TSP) dengan kandungan P2O5 46%. Pupuk fosfor dengan kadar tinggi yang sangat efektif untuk pembentukan akar, bunga, dan buah. Cocok untuk semua jenis tanaman sebagai pupuk dasar.', 'sp36.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(13, 'Pupuk Anorganik Cair 1 Liter', 'anorganik', 45000.00, 60, 'Pupuk anorganik dalam bentuk cair yang mudah diserap tanaman. Mengandung makro dan mikro nutrisi lengkap dengan formula khusus untuk pertumbuhan optimal. Aplikasi praktis melalui penyemprotan atau fertigasi.', 'anorganik cair.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(14, 'Pupuk Majemuk Tablet NPK 16-16-16', 'anorganik', 85000.00, 55, 'Pupuk majemuk dalam bentuk tablet dengan kandungan NPK seimbang 16-16-16. Formula slow release yang memberikan nutrisi bertahap. Cocok untuk tanaman hias, sayuran dalam pot, dan aplikasi presisi.', 'pupuk urea.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(15, 'Kapur Dolomit 50kg', 'anorganik', 35000.00, 70, 'Kapur dolomit untuk memperbaiki pH tanah asam dan menambah kandungan kalsium serta magnesium. Membantu meningkatkan ketersediaan unsur hara dalam tanah dan memperbaiki struktur tanah.', 'sp36.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(16, 'Pupuk Mikro Lengkap 1kg', 'anorganik', 125000.00, 20, 'Pupuk mikro mengandung unsur hara mikro lengkap seperti Boron (B), Tembaga (Cu), Besi (Fe), Mangan (Mn), Molibdenum (Mo), dan Seng (Zn). Mencegah defisiensi unsur mikro dan meningkatkan kualitas hasil panen.', 'anorganik cair.jpg', '2025-07-27 05:47:57', '2025-07-27 05:47:57'),
(17, 'Arit', 'alat tani', 15000.00, 100, 'Arit digunakan untuk memotong rumput atau tanaman kecil. Alat ini praktis dan ringan.', 'arit.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(18, 'Cangkul', 'alat tani', 35000.00, 80, 'Cangkul adalah alat utama untuk menggemburkan tanah dan membuat bedengan.', 'cangkul.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(19, 'Garu Tanah', 'alat tani', 28000.00, 60, 'Garu tanah digunakan untuk meratakan tanah setelah dicangkul agar siap ditanami.', 'garu tanah.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(20, 'Gebotan', 'alat tani', 40000.00, 40, 'Gebotan adalah alat untuk merontokkan gabah dari batang padi secara manual.', 'gebotan.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(21, 'Gosrok Gulma', 'alat tani', 25000.00, 70, 'Gosrok digunakan untuk membersihkan gulma di sela-sela tanaman.', 'gosrok.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(22, 'Alat Penanam Benih', 'alat tani', 45000.00, 50, 'Alat ini membantu petani menanam benih dengan lebih cepat dan rapi.', 'penanam.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(23, 'Alat Penyiram Otomatis', 'alat tani', 55000.00, 30, 'Digunakan untuk menyiram tanaman secara merata dengan tekanan air tertentu.', 'penyiram.jpg', '2025-07-27 05:52:19', '2025-07-27 05:52:19'),
(25, 'Pestisida Neem Oil 100ml', 'pestisida', 25000.00, 50, 'Pestisida organik berbahan dasar minyak nimba, cocok untuk membasmi serangga dan jamur.', '100ml pestisida organik Neem Oil Minyak Mimba dari Biosfer Organik.png', '2025-07-27 06:08:24', '2025-07-27 06:11:45'),
(26, 'Agristick Perekat Pestisida', 'pestisida', 15000.00, 50, 'Pupuk perekat dan perata pestisida untuk meningkatkan efektivitas semprotan.', 'Agristick Buyer - Pupuk Perekat dan Perata Pestisida kemasan 1 liter.png', '2025-07-27 06:08:24', '2025-07-27 06:12:02'),
(27, 'Keiken Insektisida', 'pestisida', 28000.00, 50, 'Insektisida alami untuk mengendalikan hama tanaman seperti ulat dan kutu.', 'Keiken - Insektisida Pembasmi Segala Hama Tanaman - Pestisida - 500 ML.png', '2025-07-27 06:08:24', '2025-07-27 06:12:16'),
(28, 'Drone Pertanian Agras T25', 'drone', 12000000.00, 50, 'Drone penyemprot otomatis untuk lahan pertanian skala menengah hingga besar.', 'agras t25.png', '2025-07-27 06:08:24', '2025-07-27 06:08:24'),
(29, 'DJI Agras T20P', 'drone', 14500000.00, 50, 'Drone DJI terbaru untuk penyemprotan dan pemupukan otomatis.', 'dji agras t20p.png', '2025-07-27 06:08:24', '2025-07-27 06:08:24'),
(30, 'Drone EV416 16L', 'drone', 9000000.00, 50, 'Drone penyemprot dengan kapasitas tangki 16 liter, efisien untuk sawah luas.', 'EV416 16L .png', '2025-07-27 06:08:24', '2025-07-27 06:08:24'),
(31, 'Traktor Krisbow Cultivator', 'traktor', 17500000.00, 50, 'Mesin bajak sawah multifungsi cocok untuk pengolahan lahan pertanian.', 'Alat Bajak Sawah Mesin Tractor Krisbow CULTIVATOR GASOLINE 4.5HP GX160.png', '2025-07-27 06:08:24', '2025-07-27 06:14:27'),
(32, 'Garu Traktor QUICK', 'traktor', 2500000.00, 50, 'Alat tambahan traktor untuk meratakan tanah dan menggemburkan lahan.', 'Garu Traktor  Cultivator QUICK Original.png', '2025-07-27 06:08:24', '2025-07-27 06:14:40'),
(33, 'Traktor Quick Capung ATS', 'traktor', 22000000.00, 50, 'Traktor bajak sawah ringan dengan mesin bertenaga, cocok untuk sawah sempit.', 'Traktor Quick Capung Rawa  Mesin Bajak Sawah  Hand Tractor Best.png', '2025-07-27 06:08:24', '2025-07-27 06:15:16'),
(34, 'Pupuk Urea 50kg', 'anorganik', 185000.00, 50, 'Pupuk Urea merupakan pupuk nitrogen dengan kandungan N 46% yang sangat efektif untuk pertumbuhan vegetatif tanaman. Cocok untuk semua jenis tanaman pangan, hortikultura, dan perkebunan. Membantu mempercepat pertumbuhan daun dan batang tanaman.', 'pupuk urea.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(35, 'Pupuk NPK Phonska 50kg', 'anorganik', 195000.00, 40, 'Pupuk NPK Phonska dengan kandungan Nitrogen (N) 15%, Fosfor (P) 15%, dan Kalium (K) 15%. Pupuk majemuk yang lengkap untuk memenuhi kebutuhan nutrisi tanaman dari masa tanam hingga panen. Meningkatkan produktivitas dan kualitas hasil panen.', 'pupuk nitrogen.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(36, 'Pupuk SP36 50kg', 'anorganik', 175000.00, 35, 'Pupuk Super Phosphate 36 (SP36) mengandung fosfor (P2O5) 36% yang sangat penting untuk pembentukan akar, bunga, dan buah. Cocok untuk aplikasi pada saat tanam sebagai pupuk dasar. Membantu meningkatkan sistem perakaran tanaman.', 'sp36.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(37, 'Pupuk ZA (Amonium Sulfat) 50kg', 'anorganik', 165000.00, 45, 'Pupuk ZA mengandung Nitrogen 21% dan Sulfur 24%. Cocok untuk tanaman yang membutuhkan sulfur seperti bawang, cabai, dan kedelai. Membantu pembentukan protein dan minyak pada tanaman serta meningkatkan ketahanan terhadap hama penyakit.', 'anorganik cair.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(38, 'Pupuk KCL (Kalium Klorida) 50kg', 'anorganik', 180000.00, 30, 'Pupuk KCL mengandung Kalium (K2O) 60% yang berperan penting dalam pembentukan buah, meningkatkan kualitas hasil, dan ketahanan tanaman terhadap kekeringan. Sangat baik untuk tanaman buah-buahan dan sayuran.', 'pupuk nitrogen.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(39, 'Pupuk TSP 50kg', 'anorganik', 190000.00, 25, 'Pupuk Triple Super Phosphate (TSP) dengan kandungan P2O5 46%. Pupuk fosfor dengan kadar tinggi yang sangat efektif untuk pembentukan akar, bunga, dan buah. Cocok untuk semua jenis tanaman sebagai pupuk dasar.', 'sp36.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(40, 'Pupuk Anorganik Cair 1 Liter', 'anorganik', 45000.00, 60, 'Pupuk anorganik dalam bentuk cair yang mudah diserap tanaman. Mengandung makro dan mikro nutrisi lengkap dengan formula khusus untuk pertumbuhan optimal. Aplikasi praktis melalui penyemprotan atau fertigasi.', 'anorganik cair.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(41, 'Pupuk Majemuk Tablet NPK 16-16-16', 'anorganik', 85000.00, 55, 'Pupuk majemuk dalam bentuk tablet dengan kandungan NPK seimbang 16-16-16. Formula slow release yang memberikan nutrisi bertahap. Cocok untuk tanaman hias, sayuran dalam pot, dan aplikasi presisi.', 'pupuk urea.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(42, 'Kapur Dolomit 50kg', 'anorganik', 35000.00, 70, 'Kapur dolomit untuk memperbaiki pH tanah asam dan menambah kandungan kalsium serta magnesium. Membantu meningkatkan ketersediaan unsur hara dalam tanah dan memperbaiki struktur tanah.', 'sp36.jpg', '2025-07-27 06:53:29', '2025-07-27 06:53:29'),
(43, 'Pupuk Mikro Lengkap 1kg', 'anorganik', 125000.00, 19, 'Pupuk mikro mengandung unsur hara mikro lengkap seperti Boron (B), Tembaga (Cu), Besi (Fe), Mangan (Mn), Molibdenum (Mo), dan Seng (Zn). Mencegah defisiensi unsur mikro dan meningkatkan kualitas hasil panen.', 'anorganik cair.jpg', '2025-07-27 06:53:29', '2025-07-27 07:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `durasi_hari` int(11) NOT NULL DEFAULT '1',
  `total_harga` decimal(12,2) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status` enum('pending','active','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id`, `user_id`, `produk_id`, `tanggal_mulai`, `tanggal_selesai`, `durasi_hari`, `total_harga`, `metode_bayar`, `status`, `created_at`) VALUES
(3, 3, 30, '2025-07-29', '2025-08-09', 12, 2400000.00, 'Transfer Mandiri', 'pending', '2025-07-27 07:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `produk_id`, `jumlah`, `total_harga`, `metode_bayar`, `status`, `created_at`) VALUES
(1, 2, 1, 2, 100000.00, 'DANA', 'success', '2025-07-27 06:53:29'),
(2, 2, 3, 1, 40000.00, 'OVO', 'pending', '2025-07-27 06:53:29'),
(3, 2, 1, 2, 100000.00, 'DANA', 'success', '2025-07-27 06:57:42'),
(4, 2, 3, 1, 40000.00, 'OVO', 'pending', '2025-07-27 06:57:42'),
(5, 3, 43, 1, 125000.00, 'DANA', 'pending', '2025-07-27 07:08:16'),
(6, 3, 8, 2, 390000.00, 'DANA', 'pending', '2025-07-27 07:10:39'),
(7, 3, 8, 2, 390000.00, 'DANA', 'pending', '2025-07-27 07:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@petanigenz.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-07-26 01:44:41', '2025-07-26 01:44:41'),
(2, 'petani1', 'petani1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-07-26 01:44:41', '2025-07-26 01:44:41'),
(3, 'rivaldy', 'rival@gmail.com', '$2y$10$XAozkGoClbxIjFxrLPEhSuGAOTHuD50.I117u9WOxXpql79XUcv/C', '2025-07-26 02:10:13', '2025-07-26 02:10:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_produk_kategori` (`kategori`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `idx_sewa_user` (`user_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `idx_transaksi_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_user_username` (`username`),
  ADD KEY `idx_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `sewa_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
