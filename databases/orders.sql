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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `username` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `received` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `username`, `phone`, `email`, `address`, `total_price`, `created_at`, `status`, `received`) VALUES
(58, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Mễ Trì - Hà Nội', 1499000, '2024-09-20 16:29:11', 1, '2024-09-26 03:28:00'),
(66, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 2998000, '2024-09-24 17:35:26', 1, '2024-09-26 04:22:00'),
(67, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 299000, '2024-09-24 18:32:59', 1, '2024-09-26 04:22:00'),
(68, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 1998000, '2024-09-25 10:04:24', 1, '2024-09-26 16:06:00'),
(69, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 1398000, '2024-09-25 10:14:54', 1, '2024-09-26 16:27:00'),
(70, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội  ', 1499000, '2024-09-25 14:33:39', 0, NULL),
(73, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 2697000, '2024-09-26 05:46:07', 1, '2024-09-26 16:27:00'),
(74, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 1196000, '2024-09-26 05:48:43', 0, NULL),
(75, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 599000, '2024-09-26 05:52:45', 0, NULL),
(76, 10, 'Cuu', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 1499000, '2024-09-26 16:01:52', 1, '2024-09-26 16:28:00'),
(77, 10, 'Cuu', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 1398000, '2024-09-26 16:15:32', 1, '2024-09-26 16:28:00'),
(78, 10, 'Cuu', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 1197000, '2024-09-26 16:15:55', 1, '2024-09-26 16:28:00'),
(79, 10, 'Cuu', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 1494000, '2024-09-26 16:16:26', 1, '2024-09-27 14:50:00'),
(80, 8, 'test', '0339266278', 'nguyenquocdong13@gmail.com', 'Hà Đông - Hà Nội', 3196000, '2024-09-26 16:19:47', 0, NULL),
(81, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 2097000, '2024-09-26 16:20:25', 1, '2024-09-26 16:27:00'),
(82, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 5996000, '2024-09-26 16:20:36', 1, '2024-09-26 16:28:00'),
(83, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 1495000, '2024-09-26 16:20:45', 0, NULL),
(84, 9, 'xeu', '0339266279', 'nguyenquocdong45@gmail.com', 'Cầu Giấy - Hà Nội ', 1196000, '2024-09-26 16:26:35', 0, NULL),
(85, 10, 'Cuu', '0339266277', 'nguyenquocdong44@gmail.com', 'Mễ Trì - Hà Nội', 995000, '2024-09-27 08:09:26', 0, NULL),
(86, 12, 'Le Anh', '0339266270', 'leanh@gmail.com', 'Mỹ Đình - Hà Nội ', 7495000, '2024-09-27 14:42:34', 0, NULL),
(87, 12, 'Le Anh', '0339266270', 'leanh@gmail.com', 'Mỹ Đình - Hà Nội ', 2697000, '2024-09-27 14:42:43', 1, '2024-09-27 14:49:00'),
(88, 12, 'Le Anh', '0339266270', 'leanh@gmail.com', 'Mỹ Đình - Hà Nội ', 5398000, '2024-09-27 14:45:07', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
