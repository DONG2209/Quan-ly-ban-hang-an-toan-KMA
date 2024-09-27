-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 06:05 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `path` text NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `description`, `path`, `price`, `quantity`, `status`) VALUES
(1, 'Home shirt 21-22', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/home-21-22.jpg', 499000, 50, 1),
(2, 'Home shirt 22-23', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/home-22-23.jpg', 699000, 70, 1),
(3, 'Home shirt 23-24', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/home-23-24.jpg', 1299000, 60, 1),
(4, 'Away shirt 21-22', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away-21-22.jpg', 499000, 40, 1),
(5, 'Away shirt 22-23', 'shirt ', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away-22-23.jpg', 699000, 35, 1),
(6, 'Away shirt 22-23-2', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away22-23.jpg', 699000, 40, 1),
(7, 'Away shirt 23-24', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away-23-24.jpg', 799000, 45, 1),
(8, 'Away shirt 23-24-2', 'shirt ', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away23-24.jpg', 799000, 55, 1),
(9, 'Home shirt 24-25', 'shirt', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/home-24-25.jpg', 1499000, 65, 1),
(10, 'Away shirt 24-25', 'shirt ', 'Giới tính: Unisex\r\nLoại hình thể thao: Bóng đá ngoài trời & trong nhà\r\nTrang phục nén: Có\r\nTính năng trang phục: Thấm hút mồ hôi\r\nĐội bóng đá: Liverpool', 'images/away-24-25.jpg', 1499000, 40, 1),
(11, 'Scarf 21-22', 'Souvenirs', 'Khăn nỉ CLB bóng đá: liverpool\r\nCHất liệu: nỉ\r\nKích thước: 150x16cm\r\nSử dụng làm khăn quàng hoặc khăn cổ vũ bóng đá\r\nLogo in nhiệt trực tiếp trên bề mặt vải nên không phai màu khi sử dụng', 'images/scarf.jpg', 299000, 40, 1),
(12, 'Scarf 22-23', 'Souvenirs', 'Khăn nỉ CLB bóng đá: liverpool\r\nCHất liệu: nỉ\r\nKích thước: 150x16cm\r\nSử dụng làm khăn quàng hoặc khăn cổ vũ bóng đá\r\nLogo in nhiệt trực tiếp trên bề mặt vải nên không phai màu khi sử dụng', 'images/scarf2.jpg', 399000, 25, 1),
(13, 'Scarf 23-24', 'Souvenirs', 'Khăn nỉ CLB bóng đá: liverpool\r\nCHất liệu: nỉ\r\nKích thước: 150x16cm\r\nSử dụng làm khăn quàng hoặc khăn cổ vũ bóng đá\r\nLogo in nhiệt trực tiếp trên bề mặt vải nên không phai màu khi sử dụng', 'images/scarf3.jpg', 399000, 29, 1),
(14, 'ball', 'Souvenirs', 'Size bóng: Số 5\r\nChu vi (mm): 680-700\r\nTrọng lượng (gram): 400-450\r\nHàng: Authentic ( có chữ ký clb Liver) ', 'images/ball.jpg', 599000, 30, 1),
(15, 'Glove 19-20 ', 'Souvenirs', 'Chất liệu: Cao su cao cấp, hấp thụ va đập và chống trượt hiệu quả.\r\nThoáng khí: Găng tay thủ môn của chúng tôi có lưới co giãn thoáng khí để giữ cho bàn tay của bạn mát mẻ và nâng cao khả năng vận động của bạn để bạn luôn có thân hình tốt nhất cho trận đấu.\r\n', 'images/glove-19-20.jpg', 899000, 35, 1),
(16, 'Glove ', 'Souvenirs', 'Chất liệu: Cao su cao cấp, hấp thụ va đập và chống trượt hiệu quả.\r\nThoáng khí: Găng tay thủ môn của chúng tôi có lưới co giãn thoáng khí để giữ cho bàn tay của bạn mát mẻ và nâng cao khả năng vận động của bạn để bạn luôn có thân hình tốt nhất cho trận đấu.', 'images/glove.jpg', 499000, 25, 1),
(17, 'Wool Glove ', 'Souvenirs', 'Chất liệu: len \r\nThoáng khí: Găng tay của chúng tôi có lưới co giãn thoáng khí để giữ cho bàn tay của bạn mát mẻ và nâng cao khả năng vận động của bạn để bạn luôn có thân hình tốt nhất cho trận đấu.', 'images/woolGlove.jpg', 399000, 20, 1),
(19, 'Wool Hat ', 'Souvenirs', 'Giới tính: Unisex\r\nKiểu nón: Mũ len\r\nKích thước: 55-59cm\r\nChất liệu: Dệt kim', 'images/hat2.jpg', 199000, 40, 1),
(20, 'Hat ', 'Souvenirs', 'Nón thể thao unisex Lfc Epl Liverpool Fc \r\nĐặc điểm nổi bật: NÓN LƯỠI TRAI LFC EPL LIVERPOOL FC \'47 CLEAN UPCùng sẵn sàng thể hiện sự ủng hộ cho một trong những đội bóng huyền thoại trong lịch sử bóng đá Anh với Nón Lưỡi Trai EPL Liverpool. Sản phẩm thời trang này không chỉ là một phụ kiện, mà còn là cách hoàn hảo để thể hiện tình yêu và niềm tự hào đối với đội bóng.  \r\nHàng chính hãng của Liverpool FC', 'images/hat.jpg', 299000, 25, 1),
(22, 'Shoe NB', 'Shoe', 'Giày sneakers nam New Balance Mens Classic ML574EVG\r\nNew Balance 574 mẫu giày biểu tượng lấy cảm hứng từ phong cách những năm 80 làm nên phong cách old-school đầy sức hút cho outfit của bạn. Mang đến những đường nét gọn gàng với sự kết hợp của những gam màu rực rỡ và đế ngoài chắc chắn, cùng chất liệu da lộn kinh điển sẽ tạo nên sự nổi bật cho trang phục của bạn nhưng vẫn giữ những nét đẹp thời mang hơi thở cổ điển của thập niên 80.', 'images/shoeNB.jpg', 1399000, 20, 1),
(23, 'Shoe Nike', 'Shoe', 'Giày đá bóng nam Nike Phantogx Academy - DD9473-705\r\nGIÀY BÓNG ĐÁ NAM NIKE PHANTOGX ACADEMYHãy tìm kiếm con đường để đưa trò chơi của bạn lên một tầm cao mới - đôi giày đá bóng này sẽ mang đến cho bạn cảm giác chạm bóng chính xác. Nổi bật với thiết kế NikeSkin và vùng tiếp xúc dạng lưới để giúp nâng cao độ chính xác của bạn, đồng thời giúp các chuyển động trên sân trở nên mượt mà cũng như khơi dậy tinh thần thể thao trong bạn', 'images/shoeNike.jpg', 2999000, 35, 1),
(24, 'Shoe Nike 2', 'Shoe ', 'Giày đá bóng nam Nike Phantogx \r\nGIÀY BÓNG ĐÁ NAM NIKE PHANTOGX :Hãy tìm kiếm con đường để đưa trò chơi của bạn lên một tầm cao mới - đôi giày đá bóng này sẽ mang đến cho bạn cảm giác chạm bóng chính xác. Nổi bật với thiết kế NikeSkin và vùng tiếp xúc dạng lưới để giúp nâng cao độ chính xác của bạn, đồng thời giúp các chuyển động trên sân trở nên mượt mà cũng như khơi dậy tinh thần thể thao trong bạn', 'images/shoeNikes.jpg', 2699000, 30, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
