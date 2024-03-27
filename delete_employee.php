<?php
// Kiểm tra vai trò của người dùng
session_start();
if ($_SESSION["role"] !== "admin") {
    // Chuyển hướng đến trang không có quyền truy cập
    header("Location: login.php");
    exit();
}

// Xử lý khi người dùng yêu cầu xóa Nhân viên
if (isset($_GET["id"])) {
    // Lấy ID của Nhân viên từ tham số truy vấn
    $employeeId = $_GET["id"];

    // Thực hiện xóa Nhân viên từ cơ sở dữ liệu ở đây
    // Đảm bảo xử lý an toàn dữ liệu và truy vấn SQL

    // Sau khi xóa thành công, chuyển hướng đến trang danh sách Nhân viên
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xóa Nhân viên</title>
</head>
<body>
    <h1>Xóa Nhân viên</h1>

    <p>Bạn có chắc chắn muốn xóa Nhân viên này?</p>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="employeeId" value="<?php echo $employeeId; ?>">
        <input type="submit" value="Xóa">
    </form>
</body>
</html>