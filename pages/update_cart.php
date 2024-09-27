<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

if (isset($_GET['id']) && isset($_GET['quantity']) && isset($_SESSION['user_id'])) {
    $product_id = $_GET['id'];
    $quantity = (int)$_GET['quantity'];
    $user_id = $_SESSION['user_id'];

    if ($quantity > 0) {
        $sql_update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('iii', $quantity, $user_id, $product_id);
        $stmt_update->execute();
    } 
}
?>
