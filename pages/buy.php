<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT username, phone, email, address FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_info = $result_user->fetch_assoc();

$total_price = 0;

if (isset($_POST['submitt']) && (!empty($_POST['products']))) {
        $selected_products = $_POST['products'];
        
        $product_ids = implode(',', array_map('intval', $selected_products));
    
        $sql_cart = "SELECT cart.product_id, cart.quantity, products.name, products.price 
                     FROM cart 
                     JOIN products ON cart.product_id = products.id 
                     WHERE cart.user_id = ? AND cart.product_id IN ($product_ids)";
        
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param('i', $user_id);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();
}else {
    $result_cart = null;
}

if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['id'];
    $quantity_buy = intval($_GET['quantity']);

    $sql_buy = "SELECT * FROM products WHERE id = ?";
    $stmt_buy = $conn->prepare($sql_buy);
    $stmt_buy->bind_param('i',$product_id );
    $stmt_buy->execute();
    $result_buy = $stmt_buy->get_result();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="../css/style6.css">
</head>
<body>
    <div class="container">
        <h2>Thông tin người nhận</h2>
        <form method="POST" action="order.php">
            <p>
                <label>Tên: <input type="text" name="name" value="<?php echo htmlspecialchars($user_info['username']); ?>" required></label>
            </p>
            <p>
                <label>Số điện thoại: <input type="text" name="phone" value="<?php echo htmlspecialchars($user_info['phone']); ?>" required></label>
            </p>
            <p>
                <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user_info['email']); ?>" required></label>
            </p>
            <p>
                <label>Địa chỉ giao hàng: <textarea name="address" required><?php echo htmlspecialchars($user_info['address']); ?></textarea></label>
            </p>

            <h2>Sản phẩm đã chọn</h2>
            <?php
                if (isset($result_cart) && $result_cart->num_rows > 0) {
                    while ($row_cart = $result_cart->fetch_assoc()) {
                        $subtotal = $row_cart['price'] * $row_cart['quantity']; 
                        $total_price += $subtotal; 
                        ?>
                        <div class="product">
                            <span><?php echo htmlspecialchars($row_cart['name']); ?> (<?php echo number_format($row_cart['price'], 0, ',', '.'); ?> VND) x <input type="number" name="quantities[]" value="<?php echo $row_cart['quantity']; ?>" min="1" readonly></span>
                            <input type="hidden" name="selected_product_ids[]" value="<?php echo $row_cart['product_id']; ?>">
                            <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($row_cart['name']); ?>">
                            <input type="hidden" name="prices[]" value="<?php echo $row_cart['price']; ?>">
                        </div>
                        <?php
                    }
                }elseif (isset($result_buy) && $result_buy->num_rows > 0) {
                    $row_buy = $result_buy->fetch_assoc();
                    $subtotal = $row_buy['price'] * $quantity_buy; 
                    $total_price += $subtotal; 
                    ?>
                    <div class="product">
                        <span><?php echo htmlspecialchars($row_buy['name']); ?> (<?php echo number_format($row_buy['price'], 0, ',', '.'); ?> VND) x <input type="number" name="quantities[]" value="<?php echo $quantity_buy; ?>" min="1" readonly></span>
                        <input type="hidden" name="selected_product_ids[]" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($row_buy['name']); ?>">
                        <input type="hidden" name="prices[]" value="<?php echo $row_buy['price']; ?>">
                    </div>
                    <?php
                } 
            ?>
            <h3>Tổng tiền: <?php echo number_format($total_price, 0, ',', '.'); ?> VND</h3>

            <div class="buttons">
                <button type="button" onclick="window.location.href='cart.php'">Hủy</button>
                <button type="submit" name = "done">Xác nhận mua hàng</button>
            </div>
        </form>
    </div>
</body>
</html>

<!-- <?php
// }
?> -->
