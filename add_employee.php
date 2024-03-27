<?php
// Kiểm tra vai trò của người dùng
session_start();
if ($_SESSION["role"] !== "admin") {
    // Chuyển hướng đến trang không có quyền truy cập
    header("Location: unauthorized.php");
    exit();
}

// Xử lý khi người dùng gửi biểu mẫu thêm Nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ biểu mẫu
    $name = $_POST["name"];
    $email = $_POST["email"];
    $position = $_POST["position"];

    // Thực hiện lưu Nhân viên vào cơ sở dữ liệu ở đây
    // Đảm bảo xử lý an toàn dữ liệu và truy vấn SQL

    // Sau khi thêm thành công, chuyển hướng đến trang danh sách Nhân viên
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm Nhân viên</title>
</head>
<body>
    <h1>Thêm Nhân viên</h1>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Họ và tên:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="position">Chức vụ:</label>
        <input type="text" id="position" name="position" required><br><br>

        <input type="submit" value="Thêm Nhân viên">
    </form>
</body>
</html>