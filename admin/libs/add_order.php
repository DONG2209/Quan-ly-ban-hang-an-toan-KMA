<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php';

$message = ''; 

$sql_users = "SELECT id, username FROM users";
$result_users = $conn->query($sql_users);
$users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

$sql_products = "SELECT id ,name FROM products";
$result_products = $conn->query($sql_products);
$products = [];
if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total_price = $quantity * $price;
    $status = $_POST['status']; 

    $conn->begin_transaction();

    try {
        $sql_order = "INSERT INTO orders (user_id, username, phone, email, address, total_price, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param('issssdi', $user_id, $username, $phone, $email, $address, $total_price, $status);
        $stmt_order->execute();

        $order_id = $conn->insert_id;

        $sql_order_item = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt_order_item = $conn->prepare($sql_order_item);
        $stmt_order_item->bind_param('iisid', $order_id, $product_id, $product_name, $quantity, $price);
        $stmt_order_item->execute();

        $sql_update_stock = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $stmt_update_stock = $conn->prepare($sql_update_stock);
        $stmt_update_stock->bind_param('ii', $quantity, $product_id);
        $stmt_update_stock->execute();

        $conn->commit();
        $message = "<div class='alert alert-success' role='alert'>Thêm đơn hàng thành công!</div>";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "<div class='alert alert-danger' role='alert'>Có lỗi xảy ra khi thêm đơn hàng: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Hóa Đơn Mới</title>
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
            width: 40%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Thêm Hóa Đơn Mới</h1>
        <?= $message; ?> 

        <form method="POST" action="">
            <div class="mb-3 form-group">
                <label for="user_id" class="form-label">Mã Khách Hàng</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">Chọn khách hàng</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id']; ?>"><?= $user['id']; ?> - <?= $user['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 form-group">
                <label for="username" class="form-label">Tên Khách Hàng</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3 form-group">
                <label for="phone" class="form-label">Điện Thoại</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3 form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 form-group">
                <label for="address" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3 form-group">
                <label for="product_id" class="form-label">Mã Sản Phẩm</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">Chọn sản phẩm</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id']; ?>"><?= $product['id']; ?> - <?= $product['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 form-group">
                <label for="product_name" class="form-label">Sản Phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name" readonly>
            </div>
            <div class="mb-3 form-group">
                <label for="quantity" class="form-label">Số Lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3 form-group">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" readonly>
            </div>
            <div class="mb-3 form-group">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="0">0</option>
                    <option value="1">1</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Thêm Hóa Đơn</button>
            <a href="../pages/manage_order.php" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>
    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            var userId = this.value;

            if (userId) {
                fetch('get_user_info.php?user_id=' + userId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('username').value = data.username;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('email').value = data.email;
                        document.getElementById('address').value = data.address;
                    });
            } else {
                document.getElementById('username').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('email').value = '';
                document.getElementById('address').value = '';
            }
        });
        document.getElementById('product_id').addEventListener('change', function() {
            var productId = this.value;

            if (productId) {
                fetch('get_product_info.php?product_id=' + productId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('product_name').value = data.name;
                        document.getElementById('price').value = data.price;
                    });
                    
            } else {
                document.getElementById('product_name').value = '';
                document.getElementById('price').value = '';
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
