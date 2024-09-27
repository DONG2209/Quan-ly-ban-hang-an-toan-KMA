<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
if (isset($_POST['done'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $selected_product_ids = $_POST['selected_product_ids']; 
    $product_names = $_POST['product_names'];
    $quantities = $_POST['quantities'];
    $prices = $_POST['prices']; 

    $total_price = 0;
    $cart_items = [];
    for ($i = 0; $i < count($selected_product_ids); $i++) {
        $cart_items[] = [
            'product_id' => $selected_product_ids[$i],
            'product_name'=> $product_names[$i],
            'quantity' => $quantities[$i],
            'price' => $prices[$i],
        ];
        $total_price += $quantities[$i] * $prices[$i];
    }

    $conn->begin_transaction();

    try {
        $sql_order = "INSERT INTO orders (user_id, username, phone, email, address, total_price) 
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param('issssi', $user_id, $name, $phone, $email, $address, $total_price);
        $stmt_order->execute();
        
        $order_id = $stmt_order->insert_id; 
        
        $sql_order_item = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) 
                           VALUES (?, ?, ?, ?, ?)";
        $stmt_order_item = $conn->prepare($sql_order_item);
        
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $stmt_order_item->bind_param('iisii', $order_id, $product_id, $product_name, $quantity, $price);
            $stmt_order_item->execute();
        }

        $sql_update_product = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $stmt_update_product = $conn->prepare($sql_update_product);
        
        foreach ($cart_items as $item) {
            $quantity = $item['quantity'];
            $product_id = $item['product_id'];
        
            $stmt_update_product->bind_param('ii', $quantity, $product_id);
            $stmt_update_product->execute();

            $sql_check = "SELECT quantity FROM products WHERE id = ?";
            $stmt_check_product = $conn->prepare($sql_check);
            $stmt_check_product->bind_param('i', $product_id);
            $stmt_check_product->execute();
            $result = $stmt_check_product->get_result();
            $kq = $result->fetch_assoc();

            if ($kq['quantity'] === 0) {
                $sql_update_status = "UPDATE products SET status = 0 WHERE id = ?";
                $stmt_update_status = $conn->prepare($sql_update_status);
                $stmt_update_status->bind_param('i', $product_id);
                $stmt_update_status->execute();
            }

            $sql_delete_cart = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt_delete_cart = $conn->prepare($sql_delete_cart);
            $stmt_delete_cart->bind_param('ii',$user_id,$product_id);
            $stmt_delete_cart->execute();
        }

        $conn->commit();
        echo "<script>alert('Đặt hàng thành công!'); window.location.href='../index.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại!')</script>";
    }
}
?>
