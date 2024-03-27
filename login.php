<?php
session_start();

// Kết nối cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "ql_nhansu");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}
// Kiểm tra vai trò của người dùng
if ($_SESSION["role"] !== "admin") {
    // Chuyển hướng đến trang không có quyền truy cập
    header("Location: login.php");
    exit();
}
// Xử lý yêu cầu đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }

    // Kiểm tra số bản ghi trả về
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Lưu thông tin đăng nhập vào phiên làm việc
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];

        // Chuyển hướng đến trang chính sau khi đăng nhập thành công
        header("Location: index.php");
        exit();
    } else {
        // Đăng nhập không thành công
        $loginError = "Thông tin đăng nhập không chính xác.";
    }
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <style>
        /* CSS cho giao diện */
    </style>
</head>
<body>
    <h1>Đăng nhập</h1>

    <!-- Form đăng nhập -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Đăng nhập</button>
    </form>

    <?php if (isset($loginError)): ?>
        <p><?php echo $loginError; ?></p>
    <?php endif; ?>
</body>
</html>