<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit;
}

include '../../pages/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($phone) || empty($_POST['password'])) {
        echo "Vui lòng điền đầy đủ thông tin.";
    } else {
        $salt = bin2hex(random_bytes(16));
        $hashed_password = hash('sha256', $salt . $password);

        $sql = "INSERT INTO users (username, email, phone, address, role, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssis', $username, $email, $phone, $address, $role, $hashed_password);

        if ($stmt->execute()) {
            $user_id = $conn->insert_id;
            $sql2 = "INSERT INTO salt_user (id, salt) VALUES ('$user_id', '$salt')";
            $stmt = $conn->query($sql2);
            echo "Thêm người dùng mới thành công.";
        } else {
            echo "Có lỗi xảy ra khi thêm người dùng.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Thêm người dùng mới</h1>

        <form action="add_user.php" method="POST">
            <div class="row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Tên người dùng</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-sm-2 col-form-label">Điện thoại</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Địa chỉ</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address">
                </div>
            </div>

            <div class="row mb-3">
                <label for="role" class="col-sm-2 col-form-label">Vai trò</label>
                <div class="col-sm-10">
                    <select class="form-select" id="role" name="role">
                        <option value="1">User</option>
                        <option value="2">Admin</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Mật khẩu</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                    <a href="../pages/manage_customer.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
