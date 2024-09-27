<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, phone, email, password ,address FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_info'])) {
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $sql_update = "UPDATE users SET username = ?, phone = ?, email = ? , address = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('sssi', $username, $phone, $email,$address, $user_id);

        if ($stmt_update->execute()) {
            echo "<p style='color: green;'>Cập nhật thông tin thành công!</p>";
            $_SESSION['username'] = $username;
        } else {
            echo "<p style='color: red;'>Đã xảy ra lỗi. Vui lòng thử lại.</p>";
        }
    }

    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $sql_pass = "SELECT u.password, s.salt FROM users u JOIN salt_user s ON u.id = s.id WHERE u.id = ?";
        $stmt_pass = $conn->prepare($sql_pass);
        $stmt_pass->bind_param('i',$user_id);
        $stmt_pass->execute();
        $result_pass = $stmt_pass->get_result();
        $user_pass = $result_pass->fetch_assoc();

        $hashed_password_current = hash('sha256', $user_pass['salt'] . $current_password);

        if ($hashed_password_current === $user_pass['password']) {
            if ($new_password === $confirm_password) {
                $hashed_password = hash('sha256', $user_pass['salt'] . $new_password);

                $sql_update_password = "UPDATE users SET password = ? WHERE id = ?";
                $stmt_update_password = $conn->prepare($sql_update_password);
                $stmt_update_password->bind_param('si', $hashed_password, $user_id);

                if ($stmt_update_password->execute()) {
                    echo "<p style='color: green; font-size : 20px ; text-align:center;'>Đổi mật khẩu thành công!</p>";
                } else {
                    echo "<p style='color: red;font-size : 20px ; text-align:center;'>Đã xảy ra lỗi khi đổi mật khẩu. Vui lòng thử lại.</p>";
                }
            } else {
                echo "<p style='color: red;font-size : 20px ; text-align:center;'>Mật khẩu xác nhận không khớp.</p>";
            }
        } else {
            echo "<p style='color: red;font-size : 20px ; text-align:center;'>Mật khẩu hiện tại không chính xác.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="../css/style4.css">
</head>
<body>
    <div class="container">
        <div class = "home_logout">
            <a href = "../index.php">Home</a> | <a href="logout.php">Đăng xuất</a>
        </div>  
        <div class ="left">
            <h2>Thông tin cá nhân</h2>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for = "address">Address:</label>
                    <input type = "text" name = "address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>
                <button type="submit" name="update_info">Cập nhật thông tin</button>
            </form>
        </div>
        
        <div class="right">
            <h2>Đổi mật khẩu</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại:</label>
                    <input type="password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới:</label>
                    <input type="password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <button type="submit" name="change_password">Đổi mật khẩu</button>
            </form>
        </div>  
    </div>
</body>
</html>
