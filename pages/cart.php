<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['id'];
    $quantity = (int)$_POST['quantity'];

    $sql_check = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('ii', $user_id, $product_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

        $sql_update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('iii', $new_quantity, $user_id, $product_id);
        $stmt_update->execute();
    } else {
        $sql_insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('iii', $user_id, $product_id, $quantity);
        $stmt_insert->execute();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../css/style5.css">
    <script>
        function decreaseQuantity(product_id) {
            var quantity = document.getElementById("quantity_" + product_id).value;
            if (quantity > 1) {
                updateQuantity(product_id, --quantity);
            }
        }

        function increaseQuantity(product_id, maxQuantity) {
            var quantity = document.getElementById("quantity_" + product_id).value;
            quantity = parseInt(quantity); 

            if (quantity < maxQuantity) {
                updateQuantity(product_id, ++quantity);
            } else {
                alert("Số lượng đặt hàng không được vượt quá số lượng còn lại!");
            }         
        }


        function updateQuantity(product_id, quantity) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "update_cart.php?id=" + product_id + "&quantity=" + quantity, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("quantity_" + product_id).value = quantity;
                }
            };
            xhr.send();
        }

        function selectAll(source) {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function validateForm() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            var checked = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checked = true;
                    break;
                }
            }

            if (!checked) {
                alert('Vui lòng chọn ít nhất một sản phẩm.');
                return false; 
            }    
            return true; 
        }
    </script>
</head>
<body>
    <div class="home">
        <a href="../index.php">Home</a> | <a href = "order_items.php">Đơn hàng</a> | <a href = "history_order.php">Lịch sử mua hàng</a>
    </div>
    <div class="container">
        <form method="POST" action="buy.php" onsubmit="return validateForm();">
            <label><input type="checkbox" onclick="selectAll(this)">Tất cả</label>
            <?php
            $sql_cart = "SELECT cart.product_id, cart.quantity, products.name, products.price, products.path,products.quantity AS stock FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ? and products.status = 1";
            $stmt_cart = $conn->prepare($sql_cart);
            $stmt_cart->bind_param('i', $user_id);
            $stmt_cart->execute();
            $result_cart = $stmt_cart->get_result();

            if ($result_cart->num_rows > 0) {
                while ($row_cart = $result_cart->fetch_assoc()) {
                    ?>
                    <div class="product">
                        <label>
                            <input type="checkbox" name="products[]" value="<?php echo $row_cart['product_id']; ?>" class="product-checkbox">
                        </label>
                        <img src="<?php echo "../" . $row_cart['path']; ?>" alt="<?php echo $row_cart['name']; ?>">
                        <div class="product-details">
                            <?php echo $row_cart['name']; ?>
                            <p>Giá: <?php echo number_format($row_cart['price'], 0, ',', '.'); ?> VND</p>
                            <div class="quantity-container">
                                <p>Số lượng:</p>
                                <div class="quantity-box">
                                    <button type="button" class="quantity-btn" onclick="decreaseQuantity(<?php echo $row_cart['product_id']; ?>)">-</button>
                                    <input type="text" id="quantity_<?php echo $row_cart['product_id']; ?>" value="<?php echo $row_cart['quantity']; ?>" class="quantity" readonly>
                                    <button type="button" class="quantity-btn" onclick="increaseQuantity(<?php echo $row_cart['product_id']?>,<?php echo $row_cart['stock']; ?>)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='color:red'>Giỏ hàng rỗng.</p>";
            }
            ?>
            <div class="buttons">
                <button type="submit" name = "submitt">Mua hàng</button>
            </div>
        </form>
    </div>
</body>
</html>
