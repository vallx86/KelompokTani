-- database/petani_genz.sql
-- Database untuk PetaniGenZ

CREATE DATABASE IF NOT EXISTS petani_genz;
USE petani_genz;

-- Tabel User
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kategori ENUM('organik', 'anorganik', 'pestisida', 'drone', 'alat tani', 'traktor') NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Transaksi (untuk tracking pembelian)
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    produk_id INT,
    jumlah INT NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL,
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (produk_id) REFERENCES produk(id)
);

-- Tabel Sewa (khusus untuk drone)
CREATE TABLE IF NOT EXISTS sewa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    produk_id INT,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL,
    status ENUM('pending', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (produk_id) REFERENCES produk(id)
);

-- Insert sample data
INSERT INTO user (username, email, password) VALUES 
('admin', 'admin@petanigenz.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('petani1', 'petani1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample products
INSERT INTO produk (nama, kategori, harga, stok, deskripsi, gambar) VALUES 
('Pupuk Kompos Organik', 'organik', 50000, 100, 'Pupuk kompos organik berkualitas tinggi yang dapat digunakan untuk semua jenis tanaman. Membantu meningkatkan kesuburan tanah secara alami.', 'kompos.jpg'),
('Insektisida Radoc 500 EC', 'pestisida', 35000, 50, 'Insektisida Radoc 500 EC berbentuk cair untuk mengusir tikus, burung, dan serangga pengganggu tanaman.', 'radoc.jpg'),
('Booster Lengkeng', 'organik', 40000, 75, 'Pupuk khusus untuk merangsang munculnya bunga dan bakal buah pada tanaman kelengkeng. Meningkatkan produktivitas buah.', 'booster_lengkeng.jpg'),
('Benih Cover Crop Mucuna', 'organik', 50000, 25, 'Kacang-kacangan Mucuna Bracteata (MB) - 1 kg. Cocok untuk cover crop dan memperbaiki struktur tanah.', 'benih_mucuna.jpg'),
('Drone Agras T25', 'drone', 150000000, 5, 'Drone pertanian canggih untuk penyemprotan pestisida dan pupuk cair. Efisien dan presisi tinggi.', 'agras_t25.png'),
('Traktor Quick Capung', 'traktor', 25000000, 3, 'Traktor hand tractor untuk mengolah lahan sawah. Cocok untuk area rawa dan lahan basah.', 'traktor_quick.png');

-- Create indexes for better performance
CREATE INDEX idx_produk_kategori ON produk(kategori);
CREATE INDEX idx_user_username ON user(username);
CREATE INDEX idx_user_email ON user(email);
CREATE INDEX idx_transaksi_user ON transaksi(user_id);
CREATE INDEX idx_sewa_user ON sewa(user_id);