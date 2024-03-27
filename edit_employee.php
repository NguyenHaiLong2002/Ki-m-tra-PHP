<?php
// Kiểm tra vai trò của người dùng
session_start();
if ($_SESSION["role"] !== "admin") {
    // Chuyển hướng đến trang không có quyền truy cập
    header("Location: login.php");
    exit();
}

// Xử lý khi người dùng gửi biểu mẫu sửa Nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ biểu mẫu
    $employeeId = $_POST["employeeId"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $position = $_POST["position"];

    // Thực hiện cập nhật thông tin Nhân viên trong cơ sở dữ liệu ở đây
    // Đảm bảo xử lý an toàn dữ liệu và truy vấn SQL

    // Sau khi sửa thành công, chuyển hướng đến trang danh sách Nhân viên
    header("Location: index.php");
    exit();
} elseif (isset($_GET["id"])) {
    // Lấy ID của Nhân viên từ tham số truy vấn
    $employeeId = $_GET["id"];

    // Lấy thông tin Nhân viên từ cơ sở dữ liệu dựa trên ID
    // Đảm bảo xử lý an toàn dữ liệu và truy vấn SQL

    // Kiểm tra xem Nhân viên có tồn tại hay không
    // Nếu không tồn tại, chuyển hướng đến trang thông báo lỗi hoặc danh sách Nhân viên

    // Hiển thị biểu mẫu với thông tin Nhân viên hiện tại
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa Nhân viên</title>
</head>
<body>
    <h1>Sửa Nhân viên</h1>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="employeeId" value="<?php echo $employeeId; ?>">

        <label for="name">Họ và tên:</label>
        <input type="text" id="name" name="name" value="<?php echo $employeeName; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $employeeEmail; ?>" required><br><br>

        <label for="position">Chức vụ:</label>
        <input type="text" id="position" name="position" value="<?php echo $employeePosition; ?>" required><br><br>

        <input type="submit" value="Lưu">
    </form>
</body>
</html>