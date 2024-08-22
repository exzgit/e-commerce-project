-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 05:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `micdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindb`
--

CREATE TABLE `admindb` (
  `ADMINID` int(11) NOT NULL,
  `ADMINNAME` varchar(64) NOT NULL,
  `ADMINMAIL` varchar(64) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `ADMINIMG` longblob NOT NULL,
  `IMGTYPE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_produk`
--

CREATE TABLE `cart_produk` (
  `ID` int(11) NOT NULL,
  `PRODUCTNAME` varchar(256) NOT NULL,
  `PRICING` int(11) NOT NULL,
  `IMGPRODUCT` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_users`
--

CREATE TABLE `cart_users` (
  `ID` int(11) NOT NULL,
  `IDPRODUCT` int(11) NOT NULL,
  `USERNAME` varchar(256) NOT NULL,
  `USERMAIL` varchar(256) NOT NULL,
  `TOTALPRICING` int(11) NOT NULL,
  `METHODPENGIRIMAN` varchar(256) NOT NULL,
  `STATUS` varchar(256) NOT NULL,
  `PRODUCTORDER` varchar(256) NOT NULL,
  `IMGPRODUCT` longblob DEFAULT NULL,
  `IDPEMESAN` int(11) NOT NULL,
  `IDPESANAN` int(11) NOT NULL,
  `SUBJECT` tinytext NOT NULL,
  `ADMINMESSAGE` longtext NOT NULL,
  `USERMESSAGE` longtext NOT NULL,
  `BAHANPRINT` text NOT NULL,
  `ALAMAT` mediumtext NOT NULL,
  `PANJANG` int(11) NOT NULL,
  `LEBAR` int(11) NOT NULL,
  `TINGGI` int(11) NOT NULL,
  `FILE` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertb`
--

CREATE TABLE `usertb` (
  `USERID` int(11) NOT NULL,
  `USERNAME` varchar(32) NOT NULL,
  `USERMAIL` varchar(32) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `USERIMG` longblob NOT NULL,
  `IMGTYPE` varchar(32) NOT NULL,
  `REGISTRATION_DATE` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindb`
--
ALTER TABLE `admindb`
  ADD PRIMARY KEY (`ADMINID`);

--
-- Indexes for table `cart_produk`
--
ALTER TABLE `cart_produk`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cart_users`
--
ALTER TABLE `cart_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `usertb`
--
ALTER TABLE `usertb`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admindb`
--
ALTER TABLE `admindb`
  MODIFY `ADMINID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_produk`
--
ALTER TABLE `cart_produk`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_users`
--
ALTER TABLE `cart_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usertb`
--
ALTER TABLE `usertb`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
