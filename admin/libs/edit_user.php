<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit;
}

include '../../pages/connect.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT id, username, email, phone, address, role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Người dùng không tồn tại.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID người dùng không hợp lệ.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    if (empty($username) || empty($email) || empty($phone)) {
        echo "Vui lòng điền đủ thông tin.";
    } else {
        $sql = "UPDATE users SET username = ?, email = ?, phone = ?, address = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssii', $username, $email, $phone, $address, $role, $user_id);

        if ($stmt->execute()) {
            echo "Cập nhật thông tin người dùng thành công.";
        } else {
            echo "Có lỗi xảy ra khi cập nhật.";
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
    <title>Chỉnh sửa thông tin người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chỉnh sửa thông tin người dùng</h1>

        <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
            <div class="row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Tên người dùng</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-sm-2 col-form-label">Điện thoại</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Địa chỉ</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="role" class="col-sm-2 col-form-label">Vai trò</label>
                <div class="col-sm-10">
                    <select class="form-select" id="role" name="role">
                        <option value="2" <?php if ($user['role'] == 2) echo 'selected'; ?>>Admin</option>
                        <option value="1" <?php if ($user['role'] == 1) echo 'selected'; ?>>User</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="../pages/manage_customer.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
