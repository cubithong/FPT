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

// Hàm để lấy thông tin của tất cả sinh viên từ cơ sở dữ liệu
function getAllStudents() {
    global $conn;
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $students = array();
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    } else {
        return array(); // Trả về một mảng trống nếu không có sinh viên nào
    }
}

// Hàm để thêm sinh viên mới vào cơ sở dữ liệu
function addStudent($fullname, $email, $password) {
    global $conn;
    $sql = "INSERT INTO students (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Lấy thông tin của tất cả sinh viên
$students = getAllStudents();

// Xử lý yêu cầu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $fullname = $_POST['Fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        addStudent($fullname, $email, $password);
        // Sau khi thêm sinh viên, cập nhật lại danh sách sinh viên
        $students = getAllStudents();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Management System</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        width: 80%;
        margin: auto;
        padding-top: 20px;
    }

    h1 {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    form {
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        margin-top: 5px;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Student Management System</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="Fullname">Full Name:</label>
        <input type="text" id="Fullname" name="Fullname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="add" value="Add Student">
    </form>

    <h2>Student List</h2>
    <table>
        <tr>
            <th>id</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        <?php
        // Kiểm tra xem $students có dữ liệu hay không
        if (!empty($students)) {
            // Loop through $students array to display student information
            // Lặp qua danh sách sinh viên và tạo các liên kết để chỉnh sửa
            foreach ($students as $student) {
              echo "<tr>";
              echo "<td>".$student['id']."</td>";
              echo "<td>".$student['Fullname']."</td>";
              echo "<td>".$student['email']."</td>";
              echo "<td>".$student['password']."</td>";
              echo "<td><a href='edit_students.php?id=".$student['id']."'>Edit</a></td>";
              echo "<td><a href='delete_students.php?id=".$student['id']."'>Delete</a></td>";
              echo "</tr>";
            }

        } else {
            // Hiển thị thông báo nếu không có sinh viên nào trong cơ sở dữ liệu
            echo "<tr><td colspan='5'>No students found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

