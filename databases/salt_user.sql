-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 05:17 PM
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
-- Database: `livershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `salt_user`
--

CREATE TABLE `salt_user` (
  `id` int(10) NOT NULL,
  `salt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salt_user`
--

INSERT INTO `salt_user` (`id`, `salt`) VALUES
(6, '0a1e80800023ee4f726f75e298a299fa'),
(8, '5eec666c1ca6952f7500ac7c597bb22a'),
(9, '4d989ff012d826e51603b59e8bcd084e'),
(10, 'c609f932e4f6c553b94b7af554920d4e'),
(12, 'be8defccdb7b65c2cbf37b01cdfcda44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salt_user`
--
ALTER TABLE `salt_user`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
