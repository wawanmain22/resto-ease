-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2024 at 01:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resto_ease_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_menu` int NOT NULL,
  `id_pemesanan` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_menu`, `id_pemesanan`, `jumlah`) VALUES
(40, 30, 5),
(41, 28, 2),
(42, 27, 3),
(42, 28, 5),
(42, 29, 3),
(43, 28, 4),
(43, 29, 2),
(43, 31, 4),
(44, 27, 3),
(46, 29, 3);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `deskripsi` text,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `harga`, `stok`, `deskripsi`, `id_user`) VALUES
(37, 'Nasi Goreng Spesial', '25000.00', 3, 'Nasi goreng dengan tambahan ayam dan telur', 11),
(38, 'Mie Goreng Jawa', '22000.00', 12, 'Mie goreng khas Jawa dengan bumbu tradisional', 11),
(39, 'Ayam Bakar Madu', '30000.00', 12, 'Ayam bakar dengan saus madu', 11),
(40, 'Sate Ayam', '20000.00', 15, 'Sate ayam dengan bumbu kacang', 11),
(41, 'Rendang Daging', '35000.00', 10, 'Daging sapi dengan bumbu rendang khas Padang', 11),
(42, 'Gado-Gado', '18000.00', 19, 'Salad sayuran dengan saus kacang', 11),
(43, 'Soto Ayam', '20000.00', 10, 'Soto ayam dengan kuah bening dan bumbu khas', 11),
(44, 'Bakso Sapi', '22000.00', 15, 'Bakso sapi dengan kuah kaldu', 11),
(45, 'Sup Ayam', '25000.00', 20, 'Sup Ayam Deskripsi', 11),
(46, 'Sup Jamur', '25000.00', 22, 'Sup Jamur Deskripsi', 11),
(47, 'Nasi Uduk', '20000.00', 15, 'Nasi uduk dengan lauk pauk lengkap', 11),
(48, 'Nasi Liwet', '23000.00', 20, 'Nasi liwet khas Solo dengan ayam suwir', 11),
(49, 'Nasi Kuning', '22000.00', 18, 'Nasi kuning dengan lauk pauk lengkap', 11),
(50, 'Ayam Goreng', '25000.00', 10, 'Ayam goreng dengan sambal terasi', 11),
(51, 'Ikan Bakar', '30000.00', 15, 'Ikan bakar dengan bumbu kecap', 11),
(52, 'Gulai Kambing', '35000.00', 8, 'Gulai kambing dengan rempah-rempah khas', 11),
(53, 'Pepes Ikan', '28000.00', 12, 'Pepes ikan dengan bumbu rempah', 11),
(54, 'Tempe Mendoan', '15000.00', 30, 'Tempe mendoan dengan sambal kecap', 11),
(55, 'Tahu Goreng', '12000.00', 25, 'Tahu goreng dengan sambal petis', 11),
(56, 'Sayur Lodeh', '20000.00', 20, 'Sayur lodeh dengan kuah santan', 11),
(57, 'Capcay', '22000.00', 18, 'Capcay dengan sayuran segar dan saus tiram', 11),
(58, 'Kwetiau Goreng', '23000.00', 20, 'Kwetiau goreng dengan udang dan ayam', 11),
(59, 'Bihun Goreng', '22000.00', 22, 'Bihun goreng dengan sayuran dan telur', 11),
(60, 'Nasi Campur', '27000.00', 15, 'Nasi campur dengan lauk pauk beragam', 11),
(61, 'Lontong Sayur', '18000.00', 25, 'Lontong sayur dengan kuah santan', 11),
(62, 'Sate Kambing', '32000.00', 10, 'Sate kambing dengan bumbu kecap', 11),
(63, 'Es Campur', '15000.00', 30, 'Es campur dengan buah segar dan sirup', 11),
(64, 'Es Teler', '16000.00', 25, 'Es teler dengan alpukat dan kelapa muda', 11),
(65, 'Es Doger', '14000.00', 20, 'Es doger dengan tape dan ketan hitam', 11),
(66, 'Cendol', '13000.00', 30, 'Cendol dengan santan dan gula merah', 11),
(67, 'Kolak Pisang', '12000.00', 25, 'Kolak pisang dengan kuah santan', 11);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int NOT NULL,
  `no_pesanan` varchar(255) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `nama_pemesan` varchar(255) NOT NULL,
  `nomor_meja` varchar(255) NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `no_pesanan`, `total_bayar`, `tgl_pesan`, `nama_pemesan`, `nomor_meja`, `id_user`) VALUES
(27, '200724001', '120000.00', '2024-07-20', 'Rifa', '11', 12),
(28, '200724002', '240000.00', '2024-07-20', 'Chiwa', '33', 12),
(29, '200724003', '169000.00', '2024-07-20', 'Faris', '69', 12),
(30, '200724004', '100000.00', '2024-07-20', 'LiaLara', '44', 12),
(31, '200724005', '80000.00', '2024-07-20', 'Chuwu', '9', 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` enum('Owner','Koki','Kasir','Pelayan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `no_hp`, `alamat`, `jabatan`) VALUES
(10, 'Owner Name', 'owner@example.com', 'ownerpassword', '0988123456', 'Owner Address', 'Owner'),
(11, 'Koki Name', 'koki@example.com', 'kokipassword', '0988123457', 'Koki Address', 'Koki'),
(12, 'Kasir Name', 'kasir@example.com', 'kasirpassword', '0988123458', 'Kasir Address', 'Kasir'),
(13, 'Pelayan Name', 'pelayan@example.com', 'pelayanpassword', '0988123459', 'Pelayan Address', 'Pelayan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_menu`,`id_pemesanan`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
