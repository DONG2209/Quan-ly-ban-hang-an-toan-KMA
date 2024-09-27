<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $sql = "SELECT o.id AS order_id, o.user_id, o.username, o.phone, o.email, o.address, o.created_at, o.received,
                oi.product_name, oi.quantity, oi.price , o.total_price , o.status
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id
            WHERE o.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Đơn hàng không tồn tại.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $total = $_POST['total'];
        $created = $_POST['created_at'];
        $status = $_POST['status'];
        $received = $_POST['received'];

        $sql_update_orders = "UPDATE orders 
                       SET  username = ?, phone = ?, email = ?, address = ?, total_price= ? , created_at = ? ,status = ?, received = ?
                       WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update_orders);
        $stmt_update->bind_param('ssssisisi',$username, $phone, $email, $address, $total ,$created , $status, $received, $order_id);

        $sql_update_orderItems = "UPDATE order_items SET product_name = ? , quantity=? , price = ? where order_id = ?";
        $stmt_update_orderItems = $conn->prepare($sql_update_orderItems);
        $stmt_update_orderItems->bind_param('siii', $product, $quantity, $price, $order_id);

        if ($stmt_update->execute() && $stmt_update_orderItems->execute()) {
            echo "<div class='alert alert-success'>Cập nhật đơn hàng thành công.</div>";
 
            $order['username'] = $username;
            $order['phone'] = $phone;
            $order['email'] = $email;
            $order['address'] = $address;
            $order['total_price'] = $total;
            $order['created_at'] = $created;
            $order['status'] = $status;
            $order['received'] = $received;
            $order['product_name'] = $product;
            $order['quantity'] = $quantity;
            $order['price'] = $price;
        } else {
            echo "<div class='alert alert-danger'>Có lỗi xảy ra khi cập nhật đơn hàng.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-group {
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 200px; 
            margin-right: 10px;
        }
        .form-group input, .form-group select {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Chỉnh sửa đơn hàng</h1>
        <form method="POST" action="">
            <div class="mb-3 form-group">
                <label for="username" class="form-label">Tên khách hàng</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $order['username']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $order['phone']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $order['email']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $order['address']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="product" class="form-label">Sản phẩm</label>
                <input type="text" class="form-control" id="product" name="product" value="<?php echo $order['product_name']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $order['quantity']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $order['price']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="total" class="form-label">Tổng tiền</label>
                <input type="number" class="form-control" id="total" name="total" value="<?php echo $order['total_price']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="created" class="form-label">Ngày đặt</label>
                <input type="text" class="form-control" id="created_at" name="created_at" value="<?php echo $order['created_at']; ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="0" <?php echo ($order['status'] == 0) ? 'selected' : ''; ?>>0</option>
                    <option value="1" <?php echo ($order['status'] == 1) ? 'selected' : ''; ?>>1</option>
                </select>
            </div>
            <div class="mb-3 form-group">
                <label for="received" class="form-label">Ngày nhận</label>
                <input type="datetime-local" class="form-control" id="received" name="received" value="<?php echo $order['received']; ?>">
                <button type="button" class="btn btn-info ms-2" onclick="setToday()">Today</button>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="../pages/manage_order.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script>
        function setToday() {
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + (month) + "-" + (day) + "T" + now.toTimeString().slice(0,5);
            document.getElementById('received').value = today;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
