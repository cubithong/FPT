<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Thay bằng tên người dùng cơ sở dữ liệu của bạn
$password = ""; // Thay bằng mật khẩu cơ sở dữ liệu của bạn
$dbname = "btec-database";

// Tạo kết nối mới
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem có tham số ID được truyền vào không
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Xóa sinh viên từ cơ sở dữ liệu
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: home_page.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
