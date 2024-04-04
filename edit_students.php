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

// Xử lý yêu cầu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy biến id từ URL
    $id = $_GET['id'];

    $fullname = $_POST['Fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE students SET Fullname='$fullname', email='$email', password='$password' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: home_page.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Information</title>
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

        form {
            width: 50%;
            margin: auto;
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
    </style>
</head>
<body>
<div class="container">
    <h1>Update Student Information</h1>
        <form action="edit_students.php?id=<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" method="post">
        <label for="Fullname">Full Name:</label>
        <input type="text" id="Fullname" name="Fullname" value="<?php echo isset($student['Fullname']) ? $student['Fullname'] : ''; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($student['email']) ? $student['email'] : ''; ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo isset($student['password']) ? $student['password'] : ''; ?>" required>

        <input type="hidden" id="id" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" required>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
