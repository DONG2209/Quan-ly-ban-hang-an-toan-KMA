<?php
session_start();
include 'connect.php';

if (isset($_POST['login'])) {
    $email_phone = $_POST['email_phone'];
    $password = $_POST['password'];

    $sql = "SELECT u.id, u.username, u.password,u.phone,u.email,u.address,u.role, s.salt FROM users u JOIN salt_user s ON u.id = s.id WHERE u.phone = ? OR u.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email_phone, $email_phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = hash('sha256', $row['salt'] . $password);

        if ($hashed_password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role']; 

            if($row['role'] === 2){
                $redirect_url = '../admin/index.php';
            }else{
                if (isset($_SESSION['redirect_url'])) {
                    $redirect_url = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']);
                } else {
                    $redirect_url = '../index.php';
                }
            }
            header("Location: $redirect_url");
            exit();
        } else {
            $error_message = "Mật khẩu không chính xác!";
        }
    } else {
        $error_message = "Email hoặc Số điện thoại không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email_phone">Email or Phone :</label>
            <input type="text" name="email_phone" required>
        </div>
        <div class="form-group">
            <label for="password">Password :</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" name="login">Đăng nhập</button>
        <p>Chưa có tài khoản? <a href="register.php">Tạo tài khoản</a></p>
    </form>   
</body>
</html>
