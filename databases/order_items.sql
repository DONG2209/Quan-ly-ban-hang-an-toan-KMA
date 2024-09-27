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
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_id` int(20) NOT NULL,
  `product_name` text NOT NULL,
  `quantity` int(20) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 58, 9, 'Home shirt 24-25', 1, 1499000),
(10, 66, 9, 'Home shirt 24-25', 2, 1499000),
(11, 67, 11, 'Scarf 21-22', 1, 299000),
(12, 68, 2, 'Home shirt 22-23', 1, 699000),
(13, 68, 3, 'Home shirt 22-23', 1, 699000),
(14, 69, 5, 'Away shirt 22-23', 2, 699000),
(15, 70, 10, 'Away shirt 24-25', 1, 1499000),
(17, 73, 15, 'Glove 19-20 ', 3, 899000),
(18, 74, 11, 'Scarf 21-22', 4, 299000),
(19, 75, 14, 'ball', 1, 599000),
(20, 76, 9, 'Home shirt 24-25', 1, 1499000),
(21, 77, 5, 'Away shirt 22-23', 2, 699000),
(22, 78, 12, 'Scarf 22-23', 3, 399000),
(23, 79, 16, 'Glove ', 1, 499000),
(24, 79, 19, 'Glove ', 1, 499000),
(25, 80, 7, 'Away shirt 23-24', 4, 799000),
(26, 81, 6, 'Away shirt 22-23-2', 3, 699000),
(27, 82, 10, 'Away shirt 24-25', 4, 1499000),
(28, 83, 20, 'Hat ', 5, 299000),
(29, 84, 11, 'Scarf 21-22', 4, 299000),
(30, 85, 19, 'Wool Hat ', 5, 199000),
(31, 86, 9, 'Home shirt 24-25', 5, 1499000),
(32, 87, 15, 'Glove 19-20 ', 3, 899000),
(33, 88, 24, 'Shoe Nike 2', 2, 2699000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
