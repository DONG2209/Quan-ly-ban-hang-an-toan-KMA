<?php
session_start();
include 'connect.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (!preg_match('/^0\d{9,10}$/', $phone)) {
        echo "<div class='error'>Số điện thoại không hợp lệ. Vui lòng nhập lại.</div>";
    } else {
        $sql_check = "SELECT * FROM users WHERE phone = ? OR email = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param('ss', $phone, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='error'>Phone hoặc Email đã đăng ký</div>";
        } else {
            $salt = bin2hex(random_bytes(16));
            $hashed_password = hash('sha256', $salt . $password);

            $sql = "INSERT INTO users (username, password, phone, email, address) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $username, $hashed_password, $phone, $email, $address);

            if ($stmt->execute()) {
                $user_id = $conn->insert_id;

                $sql2 = "INSERT INTO salt_user (id, salt) VALUES ('$user_id', '$salt')";
                $stmt = $conn->query($sql2);

                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $user['role'];

                if (isset($_SESSION['redirect_url'])) {
                    $redirect_url = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                } else {
                    $redirect_url = '../index.php';
                }

                header("Location: $redirect_url");
                exit();
            } else {
                echo "<div class='error'>Đã xảy ra lỗi. Vui lòng thử lại.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo tài khoản</title>
    <link rel="stylesheet" href="../css/style2.css">
</head>
<body>
    <h1>Đăng ký tài khoản</h1>
    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Mật khẩu" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" placeholder="Số điện thoại" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" placeholder="Địa chỉ" required>
        </div>
        <button type="submit" name="register">Tạo tài khoản</button>
    </form>
</body>
</html>
