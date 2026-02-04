-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 02:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_azamuser`
--

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran_azam`
--

CREATE TABLE `kehadiran_azam` (
  `id_kehadiran` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `sakit` int(3) DEFAULT 0,
  `izin` int(3) DEFAULT 0,
  `alpha` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kehadiran_azam`
--

INSERT INTO `kehadiran_azam` (`id_kehadiran`, `nis`, `semester`, `tahun_ajaran`, `sakit`, `izin`, `alpha`) VALUES
(1, '10243301', '1', '2020 - 2021', 2, 1, 3),
(2, '10243302', '1', '2020 - 2021', 4, 0, 0),
(3, '10243300', '1', '2020 - 2021', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mapel_azam`
--

CREATE TABLE `mapel_azam` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel_azam`
--

INSERT INTO `mapel_azam` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Bahasa Indonesia'),
(3, 'Pemrograman'),
(4, 'Basis Data');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_azam`
--

CREATE TABLE `nilai_azam` (
  `id_nilai` varchar(5) NOT NULL,
  `nis` varchar(8) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `nilai_tugas` int(11) NOT NULL,
  `nilai_uts` int(11) NOT NULL,
  `nilai_uas` int(11) NOT NULL,
  `nilai_akhir` int(11) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_azam`
--

INSERT INTO `nilai_azam` (`id_nilai`, `nis`, `id_mapel`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`, `deskripsi`, `semester`, `tahun_ajaran`) VALUES
('NP002', '10243301', 1, 40, 80, 90, 70, 'Tidak Lulus / Remedial', 1, '2020 - 2021'),
('NP003', '10243302', 2, 10, 10, 10, 10, 'Tidak Lulus / Remedial', 1, '2020 - 2021'),
('NP004', '10243301', 2, 70, 70, 70, 70, 'Tidak Lulus / Remedial', 1, '2020 - 2021'),
('NP005', '10243301', 3, 80, 90, 80, 83, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP006', '10243301', 4, 80, 80, 80, 80, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP007', '10243302', 1, 40, 80, 90, 70, 'Tidak Lulus / Remedial', 1, '2020 - 2021'),
('NP008', '10243302', 3, 80, 80, 80, 80, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP009', '10243302', 4, 90, 70, 80, 80, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP010', '10243300', 1, 80, 80, 80, 80, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP011', '10243300', 2, 90, 80, 70, 80, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP012', '10243300', 3, 80, 70, 85, 78, 'Lulus / Tidak Remedial', 1, '2020 - 2021'),
('NP013', '10243300', 4, 80, 80, 55, 72, 'Tidak Lulus / Remedial', 1, '2020 - 2021');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_azam`
--

CREATE TABLE `siswa_azam` (
  `nis` varchar(8) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa_azam`
--

INSERT INTO `siswa_azam` (`nis`, `nama_siswa`, `kelas`) VALUES
('10243300', 'Aditya', 'XI RPL'),
('10243301', 'Budi', 'XI RPL'),
('10243302', 'Citra', 'XI RPL'),
('10243304', 'Dimas', 'XI RPL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kehadiran_azam`
--
ALTER TABLE `kehadiran_azam`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD UNIQUE KEY `unik_siswa_semester` (`nis`,`semester`,`tahun_ajaran`);

--
-- Indexes for table `mapel_azam`
--
ALTER TABLE `mapel_azam`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `nilai_azam`
--
ALTER TABLE `nilai_azam`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `siswa_azam`
--
ALTER TABLE `siswa_azam`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kehadiran_azam`
--
ALTER TABLE `kehadiran_azam`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mapel_azam`
--
ALTER TABLE `mapel_azam`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kehadiran_azam`
--
ALTER TABLE `kehadiran_azam`
  ADD CONSTRAINT `kehadiran_azam_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_azam` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai_azam`
--
ALTER TABLE `nilai_azam`
  ADD CONSTRAINT `nis` FOREIGN KEY (`nis`) REFERENCES `siswa_azam` (`nis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
