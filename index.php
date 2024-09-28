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
    <script>
        function handleAction(action) {
            if (action === 'clear') {
                document.querySelector('input[name="keyword"]').value = '';
                window.location.href = 'index.php'; 
            } else if (action === 'search') {
                document.querySelector('form[name="searchForm"]').submit(); 
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Liver Store</h1>
        <div class="auth-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="icon-bar">
                    <a href="pages/cart.php" class="icon-link"><img src="images/cart.jpg" alt="Giỏ hàng" style="width: 50px; height: auto;"></a>
                    <a href="pages/profile.php" class="icon-link"><img src="images/avatar.jpg" alt="Avatar" style="width: 50px; height: auto;"></a> 
                    <?php if($_SESSION['role'] == 2): ?>
                        <a href="admin/index.php" class="icon-link"><img src="images/admin.jpg" alt="Admin" style="width: 50px; height: auto;"></a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <a href="pages/register.php">Đăng ký</a> | <a href="pages/login.php">Đăng nhập</a>
            <?php endif; ?>
        </div>
        <div class="search-bar">
        <?php 
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
         ?>
            <form method="GET" action="" name="searchForm">
                <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($keyword); ?>">
                <select name="filter">
                    <option value="">Tất cả</option>
                    <option value="name" <?php if ($filter == 'name') echo 'selected'; ?>>Tên sản phẩm</option>
                    <option value="price" <?php if ($filter == 'price') echo 'selected'; ?>>Giá sản phẩm</option>
                    <option value="category" <?php if ($filter == 'category') echo 'selected'; ?>>Loại sản phẩm</option>
                </select>
                <select name="action" onchange="handleAction(this.value)">
                    <option value="">Action</option>
                    <option value="search">Tìm kiếm</option>
                    <option value="clear">Clear</option>
                </select>
            </form>
        </div>

        <?php 
            $products_per_page = 6;
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($current_page - 1) * $products_per_page;

            $sql = "SELECT * FROM products WHERE 1=1 ";

            if (!empty($keyword)) {
                $keyword = strtolower($keyword);
                if ($filter == 'name') {
                    $sql .= " AND LOWER(name) LIKE '%$keyword%'";
                } elseif ($filter == 'price') {
                    $sql .= " AND price LIKE '%$keyword%'";
                } elseif ($filter == 'category') {
                    $sql .= " AND LOWER(type) LIKE '%$keyword%'";
                } else {
                    $sql .= " AND (LOWER(name) LIKE '%$keyword%' OR price LIKE '%$keyword%' OR LOWER(type) LIKE '%$keyword%')";
                }
            }

            $result = $conn->query($sql);
            $total_products = $result->num_rows;

            $total_pages = ceil($total_products / $products_per_page);

            $sql .= " LIMIT $offset, $products_per_page";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                echo "<div class='product-list'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                        echo "<a href='pages/detail.php?id=" . $row['id'] . "'>";
                            echo "<img src='" . $row['path'] . "' alt='" . htmlspecialchars($row['name']) . "'>"; 
                        echo "</a>";
                        echo "<p>".$row['name']."</p>";
                        echo "<p>Giá: ". number_format($row['price'], 0, ',', '.') . " VND</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p style='color:red'>Không tìm thấy sản phẩm nào</p>";
            }
        ?>

        <div class="pagination">
            <?php if ($total_pages > 1): ?>
                <ul>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li>
                            <a href="?keyword=<?php echo htmlspecialchars($keyword); ?>&filter=<?php echo htmlspecialchars($filter); ?>&page=<?php echo $i; ?>" <?php if ($i == $current_page) echo 'style="font-weight: bold;"'; ?>>
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
