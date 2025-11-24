SET FOREIGN_KEY_CHECKS = 0;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2025 at 04:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bellhouse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id` varchar(7) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_tlp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`id`, `nama`, `email`, `no_tlp`, `password`, `alamat`) VALUES
('USR15ED', 'Muhammad Yasin', 'necro@gmail.com', '08124153555', '$2y$10$S0w85.14QKwBGFj0US7aTuOZTuPpa1sY1wmAD54gTVZI6NP6ke0MG', ''),
('USR2279', 'Jayden Dwi naufal', 'dwinaufaljayden@gmail.com', '082114738801', '$2y$10$Nnw6gQ4SEFXmS03WDUftXeHZ731JdaMRCZmQ6R6iwTYk2bLVDwKlK', 'Jl. Aminah Syukur'),
('USRABBA', 'Yudhistira Dwi Putra Ambat', 'ynhaein@gmail.com', '08123135245', '$2y$10$H/X1PQY/O6FeQz52zDBoc.C3jdggS2ymECh8GJmnoqkt/w/iSAlza', 'JL SEJATI  GG KASAH 1');

-- --------------------------------------------------------

--
-- Table structure for table `destinasi`
--

CREATE TABLE `destinasi` (
  `id` varchar(7) NOT NULL,
  `nama_destinasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `id_kota` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `harga` int(10) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinasi`
--

INSERT INTO `destinasi` (`id`, `nama_destinasi`, `deskripsi`, `id_kota`, `id_kategori`, `harga`, `foto`) VALUES
('DST0001', 'Gunung Jamur', 'Gunung ini terkenal dengan batu-batu besar berbentuk unik menyerupai jamur. Berada di Desa Bhakti Mulya, Kec. Bengkayang, tempat ini cukup populer di kalangan pendaki lokal karena jalurnya tidak terlalu berat dan sangat cocok untuk pemula. Pemandangan alamnya hijau dan masih sangat alami, dengan hutan yang terjaga. Menurut catatan Dinas Pariwisata, Bukit Jamur (sebutan wisata alamnya) mulai beroperasi sejak tahun 2018.', 2, 4, 999999, '6922e3bd6b183.jpg'),
('DST0002', 'Gunung Kelam', 'Ikon Kabupaten Sintang yang sudah dikenal sejak lama. Gunung Kelam memiliki tebing granit raksasa (monolit) yang sangat menantang dan dramatis, jadi banyak pendaki serius datang ke sini. Lokasinya di Merpak, Kelam Permai. Panorama dari puncaknya sangat memukau, meskipun jalur pendakiannya tergolong curam dan menuntut fisik. Karena keunikannya, gunung ini cukup populer di antara komunitas pendaki di Kalbar.', 3, 4, 999999, '6922ede972fde.jpeg'),
('DST0003', 'Gunung Bawang', 'Terletak di Desa Tiga Berkat, Gunung Bawang cukup populer sebagai tempat hiking ringan dan camping. Banyak pengunjung datang untuk menikmati pemandangan sunrise yang cantik dari puncaknya. Suasananya sangat damai — cocok bagi mereka yang ingin sejenak lepas dari hiruk pikuk dan dekat dengan alam.', 3, 4, 999999, '6922ee22ab407.jpg'),
('DST0004', 'Pantai Batu Burung', 'Terletak di Sedau, pantai ini cukup populer sejak lama karena batu besar di pinggir pantai yang jadi ikon unik. Ombaknya relatif tenang dan fasilitas lokal cukup memadai, jadi sering dikunjungi keluarga untuk piknik atau santai sore.', 5, 1, 999999, '6922ee588469c.jpeg'),
('DST0005', 'Pantai Gosong', 'Pantai dengan hamparan pasir luas dan ombak yang tenang. Lokasinya di daerah Sungai Raya Kepulauan membuat suasananya cukup sejuk dan damai. Karena tenangnya, pantai ini cukup digemari keluarga dan pengunjung yang ingin beristirahat dari kehidupan kota', 2, 1, 999999, '6922ee8c6fdf4.jpg'),
('DST0006', 'Museum Kalimantan Barat', '', 1, 2, 999999, '6922eed40758c.jpeg'),
('DST0007', 'Taman Khatulistiwa', 'Menjadi landmark wisata di Pontianak karena monumen garis khatulistiwa yang sangat ikonik. Tempat ini sudah cukup populer sejak lama untuk wisata edukatif dan berfoto.', 1, 2, 999999, '6922efca53511.jpg'),
('DST0008', 'Kampung Raja', 'Restoran bernuansa kayu dengan menu seafood dan masakan khas Pontianak. Tempat ini populer di kalangan keluarga karena suasananya hangat dan tradisional.', 1, 3, 999999, '6922eff8bcffb.jpg'),
('DST0009', 'Oukie Bakmie Kepiting', 'Salah satu bakmi paling legendaris di Pontianak. Rumah makan ini sudah sangat ikonik dan cukup populer sejak lama di kalangan warga lokal maupun wisatawan kuliner.\r\nPendirinya adalah Gow Hak Lie, dan usaha ini sudah memasuki generasi ketiga, menunjukkan betapa kuatnya tradisi keluarga di balik restoran ini.', 1, 3, 999999, '6922f0338e2cd.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'Pantai'),
(2, 'Sejarah'),
(3, 'Kuliner'),
(4, 'Pegunungan');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id` int(11) NOT NULL,
  `kota` varchar(255) NOT NULL,
  `id_provinsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id`, `kota`, `id_provinsi`) VALUES
(1, 'Pontianak', 1),
(2, 'Bengkayang', 1),
(3, 'Sintang', 1),
(4, 'Landak', 1),
(5, 'Singkawang', 1),
(6, 'Sambas', 1),
(7, 'Kayong Utara', 1),
(8, 'Ketapang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` varchar(7) NOT NULL,
  `id_data_user` varchar(7) NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `destinasi` varchar(7) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `tanggal_keberangkatan` date NOT NULL,
  `tanggal_kepulangan` date NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_peserta`
--

CREATE TABLE `pesanan_peserta` (
  `id` int(11) NOT NULL,
  `id_pesanan` varchar(7) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(2) NOT NULL,
  `no_identitas` varchar(255) NOT NULL,
  `tipe_peserta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(11) NOT NULL,
  `provinsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id`, `provinsi`) VALUES
(1, 'Kalimantan Barat');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_destinasi` varchar(50) NOT NULL,
  `tanggal_ditambahkan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinasi`
--
ALTER TABLE `destinasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kota` (`id_kota`,`id_kategori`),
  ADD KEY `kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_data_user` (`id_data_user`,`destinasi`),
  ADD KEY `destinasi` (`destinasi`);

--
-- Indexes for table `pesanan_peserta`
--
ALTER TABLE `pesanan_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET FOREIGN_KEY_CHECKS = 1;