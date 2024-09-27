<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $sql = "SELECT oi.quantity, o.status, oi.product_id 
            FROM orders o 
            JOIN order_items oi ON o.id = oi.order_id  
            WHERE o.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    $conn->begin_transaction();

        try {
            $quantity = 0;
            if ($row['status'] == 0) {  
                $quantity = $row['quantity'];
                $product_id = $row['product_id'];

                $sql_products = "SELECT quantity FROM products WHERE id = ?";
                $stmt_products = $conn->prepare($sql_products);
                $stmt_products->bind_param('i', $product_id);
                $stmt_products->execute();
                $product_result = $stmt_products->get_result();
                $row_products = $product_result->fetch_assoc();

                $new_quantity = $row_products['quantity'] + $quantity;

                $sql_update = "UPDATE products SET quantity = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param('ii', $new_quantity, $product_id);
                $stmt_update->execute();
            }

            $sql_delete_order_items = "DELETE FROM order_items WHERE order_id = ?";
            $stmt_order_items = $conn->prepare($sql_delete_order_items);
            $stmt_order_items->bind_param('i', $order_id);
            $stmt_order_items->execute();

            $sql_delete_order = "DELETE FROM orders WHERE id = ?";
            $stmt_order = $conn->prepare($sql_delete_order);
            $stmt_order->bind_param('i', $order_id);
            $stmt_order->execute();

            $conn->commit();

            if ($stmt_order_items->affected_rows > 0 && $stmt_order->affected_rows > 0) {
                echo "Xóa thành công";
            } else {
                echo "Xóa không thành công";
            }

        } catch (Exception $e) {
            $conn->rollback();
            echo "Có lỗi xảy ra khi xóa đơn hàng: " . $e->getMessage();
        }
    
} 
?>
