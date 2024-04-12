-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 06:19 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategoritiket`
--

CREATE TABLE `kategoritiket` (
  `kategoriTiket_id` int(11) NOT NULL,
  `nama_kategori` varchar(145) DEFAULT NULL,
  `deskripsi` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategoritiket`
--

INSERT INTO `kategoritiket` (`kategoriTiket_id`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Jaringan', 'Masalah sehubungan dengan jaringan internet'),
(2, 'Hardware', 'Masalah sehubungan dengan perangkat komputer'),
(3, 'Software', 'Masalah sehubungan dengan program SIP'),
(4, 'LKD', 'Masalah sehubungan dengan ATM,KKD');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `komentar_id` int(11) NOT NULL,
  `tiket_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal_komentar` date DEFAULT NULL,
  `isi_komentar` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `tiket_id` int(11) NOT NULL,
  `kategoriTiket_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `prioritas` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `user_salah` varchar(105) DEFAULT NULL,
  `file_name` varchar(45) DEFAULT NULL,
  `img` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `usergroup_id` int(11) DEFAULT NULL,
  `no_hp` varchar(45) DEFAULT NULL,
  `BO_tugas` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `nama_user`, `password`, `usergroup_id`, `no_hp`, `BO_tugas`, `jabatan`) VALUES
(11, 'severinus grata gandi', '123456!!!', 1, '081258909555', 'HO', 'Staf ITD');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `userGroup_id` int(11) NOT NULL,
  `nama_group` varchar(105) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`userGroup_id`, `nama_group`) VALUES
(1, 'User'),
(2, 'Admin'),
(3, 'Validator'),
(4, 'eksekutor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategoritiket`
--
ALTER TABLE `kategoritiket`
  ADD PRIMARY KEY (`kategoriTiket_id`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `tiket_id` (`tiket_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`tiket_id`),
  ADD KEY `kategoriTiket_id` (`kategoriTiket_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `usergroup_id` (`usergroup_id`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD PRIMARY KEY (`userGroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoritiket`
--
ALTER TABLE `kategoritiket`
  MODIFY `kategoriTiket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `tiket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `userGroup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `tiket_id` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`tiket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `kategoriTiket_id` FOREIGN KEY (`kategoriTiket_id`) REFERENCES `kategoritiket` (`kategoriTiket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `usergroup_id` FOREIGN KEY (`usergroup_id`) REFERENCES `usergroup` (`userGroup_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
