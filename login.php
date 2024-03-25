<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "user";
$password = "123";
$database = "ql_nhansu";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        echo "Đăng nhập thành công!";
    } else {
        // Đăng nhập thất bại
        echo "Thông tin đăng nhập không chính xác!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required><br>

        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>
