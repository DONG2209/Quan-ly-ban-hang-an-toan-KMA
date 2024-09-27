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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `role` int(3) NOT NULL DEFAULT 1,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `phone`, `email`, `address`, `role`, `status`) VALUES
(6, 'admin', 'd7d11b63aeecb8120f302a56def8428688d65bb9bfa80064fcaaf51d14b1d427', '0339266276', 'nguyenquocdong@gmail.com', 'Thanh Xuân - Hà Nội ', 2, 1),
(8, 'test', 'b7ce90eed2b19749ebb63fae3babe73f17decbb61b81eac083c99ea0ff6f43b8', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 1, 1),
(9, 'xeu', '4d795d47e5e23af4808b56aeb2f3ebf49beb65c853fa1af5a3a91faae385b68e', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 1, 1),
(10, 'Cuu', 'fbe39721fc5f58a54f258a323932e6bcb7ea4cb09f2e2cbe826fd6bcd66170b9', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 1, 1),
(11, 'testtt', '123', '', '', 'dfgvdfv', 1, 0),
(12, 'Le Anh', 'cd5bb56b7d2d744ba1e722add4821eba2c1de0f82ee3d703bca3f781e06a0070', '0339266270', 'leanh@gmail.com', 'Mỹ Đình - Hà Nội ', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
