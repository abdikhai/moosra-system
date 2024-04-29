-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2024 at 11:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmoosra1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbalternatif`
--

CREATE TABLE `tbalternatif` (
  `idalternatif` int NOT NULL,
  `namaalternatif` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `keteranganalternatif` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbalternatif`
--

INSERT INTO `tbalternatif` (`idalternatif`, `namaalternatif`, `keteranganalternatif`) VALUES
(1, 'Indosat', ''),
(2, 'Smartfren', ''),
(3, 'Telkomsel', ''),
(4, 'Tri', ''),
(5, 'XL', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbhitung`
--

CREATE TABLE `tbhitung` (
  `idhitung` int NOT NULL,
  `idalternatif` int NOT NULL,
  `C1` int DEFAULT NULL,
  `C2` int DEFAULT NULL,
  `C3` int DEFAULT NULL,
  `C4` int DEFAULT NULL,
  `C5` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbhitung`
--

INSERT INTO `tbhitung` (`idhitung`, `idalternatif`, `C1`, `C2`, `C3`, `C4`, `C5`) VALUES
(3, 2, 4, 4, 3, 4, 4),
(4, 3, 3, 3, 2, 4, 3),
(5, 4, 3, 3, 4, 4, 3),
(6, 1, 2, 2, 4, 3, 3),
(7, 5, 3, 3, 4, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbkriteria`
--

CREATE TABLE `tbkriteria` (
  `idkriteria` int NOT NULL,
  `namakriteria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jeniskriteria` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `bobot` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbkriteria`
--

INSERT INTO `tbkriteria` (`idkriteria`, `namakriteria`, `jeniskriteria`, `bobot`) VALUES
(1, 'Kecepatan Internet', 'Benefit', 25),
(2, 'Stabilitas Koneksi', 'Benefit', 15),
(3, 'Harga dan Paket Layanan', 'Cost', 20),
(4, 'Layanan Aplikasi Mobile', 'Benefit', 10),
(5, 'Kepuasan Pemakaian', 'Benefit', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbsubkriteria`
--

CREATE TABLE `tbsubkriteria` (
  `idkriteria` int NOT NULL,
  `idsubkriteria` int NOT NULL,
  `namasubkriteria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangansubkriteria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `bobotsubkriteria` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbsubkriteria`
--

INSERT INTO `tbsubkriteria` (`idkriteria`, `idsubkriteria`, `namasubkriteria`, `keterangansubkriteria`, `bobotsubkriteria`) VALUES
(1, 1, 'Sangat Baik', '', 5),
(1, 2, 'Baik', '', 4),
(1, 3, 'Cukup', '', 3),
(1, 4, 'Kurang', '', 2),
(1, 5, 'Buruk', '', 1),
(2, 6, 'Sangat Stabil', '', 5),
(2, 7, 'Stabil', '', 4),
(2, 8, 'Cukup', '', 3),
(2, 9, 'Kurang', '', 2),
(2, 10, 'Tidak Stabil', '', 1),
(3, 11, 'Sangat Murah', '', 5),
(3, 12, 'Murah', '', 4),
(3, 13, 'Cukup', '', 3),
(3, 14, 'Kurang', '', 2),
(3, 15, 'Mahal', '', 1),
(4, 16, 'Sangat Baik', '', 5),
(4, 17, 'Baik', '', 4),
(4, 18, 'Cukup', '', 3),
(4, 19, 'Kurang', '', 2),
(4, 20, 'Buruk', '', 1),
(5, 21, 'Sangat Puas', '', 5),
(5, 22, 'Puas', '', 4),
(5, 23, 'Cukup', '', 3),
(5, 24, 'Kurang', '', 2),
(5, 25, 'Tidak Puas', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE `tbuser` (
  `iduser` int NOT NULL,
  `nim` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(46) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`iduser`, `nim`, `password`) VALUES
(1, '20.50.090', '8d3fa11102ee509ebf012560ce3dd396'),
(2, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbalternatif`
--
ALTER TABLE `tbalternatif`
  ADD PRIMARY KEY (`idalternatif`);

--
-- Indexes for table `tbhitung`
--
ALTER TABLE `tbhitung`
  ADD PRIMARY KEY (`idhitung`);

--
-- Indexes for table `tbkriteria`
--
ALTER TABLE `tbkriteria`
  ADD PRIMARY KEY (`idkriteria`);

--
-- Indexes for table `tbsubkriteria`
--
ALTER TABLE `tbsubkriteria`
  ADD PRIMARY KEY (`idsubkriteria`);

--
-- Indexes for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbalternatif`
--
ALTER TABLE `tbalternatif`
  MODIFY `idalternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbhitung`
--
ALTER TABLE `tbhitung`
  MODIFY `idhitung` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbkriteria`
--
ALTER TABLE `tbkriteria`
  MODIFY `idkriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbsubkriteria`
--
ALTER TABLE `tbsubkriteria`
  MODIFY `idsubkriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `iduser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
