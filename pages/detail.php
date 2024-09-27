<?php
session_start(); 

$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

include 'connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $product_id AND status = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chi tiết sản phẩm</title>
            <link rel="stylesheet" href="../css/style1.css">
            <script>
                function decreaseQuantity() {
                    var quantity = document.getElementById("quantity").value;
                    if (quantity > 1) {
                        document.getElementById("quantity").value = --quantity;
                    }
                }

                function increaseQuantity() {
                    var quantity = document.getElementById("quantity").value;
                    var maxQuantity = <?php echo $row['quantity']; ?>;
                    if (quantity < maxQuantity) {
                        document.getElementById("quantity").value = ++quantity;
                    } else {
                        alert("Số lượng đặt hàng không được vượt quá số lượng còn lại!");
                    }
                }

                function checkLogin(action) {
                    var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
                    if (!isLoggedIn) {
                        window.location.href = "login.php";
                    } else {
                        if (action === 'add_to_cart') {
                            var quantity = document.getElementById("quantity").value;
                            var product_id = <?php echo $product_id; ?>;
                
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "cart.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    alert("Sản phẩm đã được thêm vào giỏ hàng!");
                                }
                            };

                            xhr.send("id=" + product_id + "&quantity=" + quantity);
                        } else if (action === 'buy_now') {
                            var quantity = document.getElementById("quantity").value;
                            var product_id = <?php echo $product_id; ?>;
                            window.location.href = "buy.php?id=" + product_id + "&quantity=" + quantity;
                        }
                    }
                }
            </script>
        </head>
        <body>
            <div class="home">
                <a href="../index.php">Home</a>
            </div>
            <div class="container">
                <div class = "left">
                    <img src="<?php echo "../".$row['path']; ?>" alt="<?php echo $row['name']; ?>">
                </div>
                <div class = "right">
                    <h1><?php echo $row['name']; ?></h1>
                    <p>Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?> VND</p>
                    <p>Mô tả: <?php echo $row['description']; ?></p>
                    <p>Số lượng còn: <?php echo $row['quantity']; ?></p>
                    <div class="quantity-container">
                        <p>Số lượng:</p>
                        <div class="quantity-box">
                            <button class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="text" id="quantity" value="1" readonly>
                            <button class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <div class="button-group">
                        <button  onclick="checkLogin('add_to_cart')">Thêm vào giỏ hàng</button>
                        <button onclick="checkLogin('buy_now')">Mua hàng</button>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }else{
        echo "<script>alert('Hiện sản phẩm này đã hết hàng !'); window.location.href = '../index.php';</script>";
    }
}
?>
