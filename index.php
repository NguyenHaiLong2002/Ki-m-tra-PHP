<?php
// Tạo chức năng phân trang
$conn = mysqli_connect("localhost", "root", "", "ql_nhansu");

// Kiểm tra kết nối
if (!$conn) {
  die("Kết nối không thành công: " . mysqli_connect_error());
}

// Truy vấn để lấy tổng số Nhân viên
$sql = "SELECT COUNT(*) AS total FROM NHANVIEN";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Lỗi truy vấn: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$totalEmployees = $row['total'];
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["username"])) {
    // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    header("Location: login.php");
    exit();
}

// Xử lý yêu cầu đăng xuất
if (isset($_POST["logout"])) {
    // Xóa tất cả các biến phiên làm việc
    session_unset();

    // Huỷ phiên làm việc
    session_destroy();

    // Chuyển hướng về trang đăng nhập sau khi đăng xuất thành công
    header("Location: login.php");
    exit();
}
// Số nhân viên trên mỗi trang
$employeesPerPage = 5;

// Tính số trang cần hiển thị
$totalPages = ceil($totalEmployees / $employeesPerPage);

// Lấy số trang hiện tại từ tham số truyền vào hoặc mặc định là trang đầu tiên
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Chỉ số bắt đầu của bản ghi trên trang hiện tại
$startIndex = ($currentPage - 1) * $employeesPerPage;

// Truy vấn để lấy danh sách Nhân viên trên trang hiện tại
$sql = "SELECT n.*, p.TenPhong FROM NHANVIEN n
        INNER JOIN PHONGBAN p ON n.MaPhong = p.MaPhong
        LIMIT $startIndex, $employeesPerPage";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Lỗi truy vấn: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Danh sách Nhân viên</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h1 {
      text-align: center;
    }

    .employee-list {
      list-style-type: none;
      padding: 0;
    }

    .employee-item {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .employee-item img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
      border-radius: 50%;
    }

    #pagination {
      text-align: center;
      margin-top: 20px;
    }

    #pagination a {
      display: inline-block;
      padding: 5px 10px;
      margin-right: 5px;
      background-color: #f2f2f2;
      color: #333;
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    #pagination a:hover {
      background-color: #ddd;
    }
  </style>
</head>
<body>
  <h1>Danh sách Nhân viên</h1>

  <ul class="index">
    <?php
    // Kiểm tra và hiển thị danh sách Nhân viên
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $imgSrc = $row['Phai'] === 'NU' ? 'images/woman.jpg' : 'images/man.jpg';
        $employeeInfo = $row['MaNV'] . ' - ' . $row['TenNV'] . ' - ' . $row['NoiSinh'] . ' - ' . $row['TenPhong'] . ' - ' . $row['Luong'];

        echo '<li class="employee-item">';
        echo '<img src="' . $imgSrc . '" alt="Avatar">';
        echo '<span>' . $employeeInfo . '</span>';
        echo '</li>';
      }
    } else {
      echo 'Không có Nhân viên.';
    }

    // Đóng kết nối
    mysqli_close($conn);
    ?>
  </ul>

  <div id="pagination">
    <?php
    // Hiển thị các trang
    for ($i = 1; $i <= $totalPages; $i++) {
      echo '<a href="index.php?page=' . $i . '">' . $i . '</a> ';
    }
    ?>
  </div>
  <h1>Xin chào, <?php echo $_SESSION["username"]; ?></h1>

<!-- Form đăng xuất -->
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <button type="submit" name="logout">Đăng xuất</button>
</form>
</form>
</body>
</html>