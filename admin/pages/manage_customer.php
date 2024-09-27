<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: ../../index.php');
    exit; 
}

include '../../pages/connect.php';

$sql = "SELECT id, username, email, phone, address ,role
        FROM users
        Where role = 1 and status = 1 ";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .home {
            left: 60px;
            font-size: 26px;
            position: absolute;
        }

        .home a {
            text-decoration: none;
            color: #007bff;
        }

        .home a:hover {
            text-decoration: underline;
        }

        .action-buttons a {
            margin-right: 5px;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
    <script>
        function deleteUser(userId) {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../libs/delete_user.php?id=" + userId, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = xhr.responseText;
                        if (response.includes("Xóa thành công")) {
                            var row = document.getElementById('user-' + userId);
                            if (row) {
                                row.remove();
                            }
                        } else {
                            alert("Có lỗi xảy ra: " + response);
                        }
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="home">
            <a href="../index.php">Home</a>
        </div>
        <h1>Quản lý người dùng</h1>
        <a href="../libs/add_user.php" class="btn btn-success mb-3">Thêm người dùng mới</a>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Người Dùng</th>
                    <th>Email</th>
                    <th>Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Vai Trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr id="user-<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo  ($row['role'] == 2) ? 'Admin' : 'User'; ?></td>
                            <td class="action-buttons">
                                <a href="../libs/edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $row['id']; ?>)">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Không có người dùng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
