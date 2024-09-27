<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php'; 

$sql = "
    SELECT 
        SUM(o.total_price) AS total_sales, COUNT(o.id) AS total_orders
    FROM orders o";
$result = $conn->query($sql);
$total_data = $result->fetch_assoc();

$sql_time = "
    SELECT 
        DATE_FORMAT(o.created_at, '%Y-%m') AS order_month, 
        SUM(o.total_price) AS total_sales, 
        COUNT(o.id) AS total_orders
    FROM orders o
    GROUP BY order_month
    ORDER BY order_month DESC";
$result_time = $conn->query($sql_time);

$sql_customers = "
    SELECT 
        username, 
        COUNT(id) AS total_orders, 
        SUM(total_price) AS total_spent
    FROM orders
    GROUP BY user_id
    ORDER BY total_spent DESC";
$result_customers = $conn->query($sql_customers);


$sql_products = "
    SELECT 
        oi.product_name, 
        SUM(oi.quantity) AS total_sold, 
        SUM(oi.price * oi.quantity) AS total_revenue
    FROM order_items oi
    GROUP BY oi.product_name
    ORDER BY total_sold DESC";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê bán hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href="../../css/style8.css">
</head>
<body>
    
    <div class="nav-pills">
        <ul class="list-group">
            <li class="list-group-item" onclick="showSection('sales')">Tổng quan</li>
            <li class="list-group-item" onclick="showSection('time')">Thống kê theo thời gian</li>
            <li class="list-group-item" onclick="showSection('customers')">Thống kê theo khách hàng</li>
            <li class="list-group-item" onclick="showSection('products')">Thống kê theo sản phẩm</li>
        </ul>
    </div>
    <div class="home">
        <a href="../index.php">Home</a>
    </div>
    <div class="container mt-5">
        <h1>Thống kê kết quả bán hàng</h1>

        <div id="sales" class="statistic-section statistic-card">
            <div class="row">
                <div class="col-md-6">
                    <h3>Tổng doanh thu</h3>
                    <p><strong><?php echo number_format($total_data['total_sales'], 0, ',', '.'); ?> VNĐ</strong></p>
                </div>
                <div class="col-md-6">
                    <h3>Tổng số đơn hàng</h3>
                    <p><strong><?php echo $total_data['total_orders']; ?></strong> đơn hàng</p>
                </div>
            </div>
        </div>

        <div id="time" class="statistic-section">
            <div class="statistic-title">Thống kê theo thời gian (tháng)</div>
            <table class="table table-bordered statistic-table">
                <thead class="table-dark">
                    <tr>
                        <th>Tháng</th>
                        <th>Số đơn hàng</th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_time = $result_time->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row_time['order_month']; ?></td>
                            <td><?php echo $row_time['total_orders']; ?></td>
                            <td><?php echo number_format($row_time['total_sales'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="customers" class="statistic-section">
            <div class="statistic-title">Thống kê theo khách hàng</div>
            <table class="table table-bordered statistic-table">
                <thead class="table-dark">
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Số đơn hàng</th>
                        <th>Tổng chi tiêu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_customers = $result_customers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row_customers['username']; ?></td>
                            <td><?php echo $row_customers['total_orders']; ?></td>
                            <td><?php echo number_format($row_customers['total_spent'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="products" class="statistic-section">
            <div class="statistic-title">Thống kê theo sản phẩm</div>
            <table class="table table-bordered statistic-table">
                <thead class="table-dark">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng bán ra</th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row_products = $result_products->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row_products['product_name']; ?></td>
                            <td><?php echo $row_products['total_sold']; ?></td>
                            <td><?php echo number_format($row_products['total_revenue'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            var sections = document.querySelectorAll('.statistic-section');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });

            document.getElementById(sectionId).style.display = 'block';
        }
        showSection('sales');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
