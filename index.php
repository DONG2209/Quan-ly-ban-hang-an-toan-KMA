<?php
session_start(); 
include 'pages/connect.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liver Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Liver Store</h1>
        <div class="auth-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="pages/cart.php" class="icon-link"><img src="images/cart.jpg" alt="Giỏ hàng" style="width: 50px; height: auto;"></a>
                <a href="pages/profile.php" class="icon-link"><img src="images/avatar.jpg" alt="Avatar" style="width: 50px; height: auto;"></a> 
            <?php else: ?>
                <a href="pages/register.php">Đăng ký</a> | <a href="pages/login.php">Đăng nhập</a>
            <?php endif; ?>
        </div>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm...">
                <select name="filter">
                    <option value="">Tất cả</option>
                    <option value="name">Tên sản phẩm</option>
                    <option value="price">Giá sản phẩm</option>
                    <option value="category">Loại sản phẩm</option>
                </select>
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
        <?php 
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

            $sql = "SELECT * FROM products Where 1=1 ";

            if (!empty($keyword)) {
                $keyword = strtolower($keyword);
                if ($filter == 'name') {
                    $sql .= " AND LOWER(name) LIKE '%$keyword%'";
                } elseif ($filter == 'price') {
                    $sql .= " AND price LIKE '%$keyword%'";
                } elseif ($filter == 'category') {
                    $sql .= " AND LOWER(type) LIKE '%$keyword%'";
                } else{
                    $sql .= " AND (LOWER(name) LIKE '%$keyword%' OR price LIKE '%$keyword%' OR LOWER(type) LIKE '%$keyword%')";
                }
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='product-list'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                        echo "<a href='pages/detail.php?id=" . $row['id'] . "'>";
                            echo "<img src='" . $row['path'] . "' alt='" . $row['name'] . "'>"; 
                        echo "</a>";
                        echo "<p>".$row['name']."</p>";
                        echo "<p>Giá: ". number_format($row['price'], 0, ',', '.') . " VND</p>";
                    echo "</div>";
                }
                echo "</div>";
            }else {
                echo "<p style = 'color:red'>No Items found</p>";
            }
        ?>
    </div>
</body>
</html>
