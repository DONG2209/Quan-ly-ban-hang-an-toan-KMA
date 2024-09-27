<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$sql = "SELECT o.id AS order_id, o.username, o.phone, o.email, o.address, o.total_price, o.created_at, 
               oi.product_name, oi.quantity, oi.price 
        FROM orders o 
        JOIN order_items oi ON o.id = oi.order_id 
        WHERE o.user_id = ?  and o.status = 0
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Đơn Hàng</title>
    <link rel="stylesheet" href="../css/style7.css"> 
</head>
<body>
<div class="home">
    <a href="../index.php">Home</a> | <a href="cart.php">Previous</a>
</div>

<h1>Đơn Hàng</h1>
<?php 
if ($result-> num_rows >0){ ?>
<table>
    <thead>
        <tr>
            <th>Mã Đơn Hàng</th>
            <th>Tên Khách Hàng</th>
            <th>Điện Thoại</th>
            <th>Email</th>
            <th>Địa Chỉ</th>
            <th>Sản Phẩm</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tổng Giá Trị</th>
            <th>Ngày Đặt</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo $row['created_at']; ?></td>
            <td>Đang vận chuyển</td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php
} else{
    echo "<h3 style = 'text-align :center; color:blue'>Hiện tại không có đơn hàng nào !!!</h3>";
}
?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
