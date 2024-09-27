<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "Update users Set status = 0  WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);

    if ($stmt->execute()) {
        echo "Xóa thành công";
    } else {
        echo "Lỗi khi xóa người dùng";
    }

    $stmt->close();
}

$conn->close();
?>
