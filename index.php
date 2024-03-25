<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Nhân Viên</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            margin-right: 5px;
        }

        .pagination a:hover {
            background-color: #f2f2f2;
        }

        .pagination .active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .login-button {
            position: absolute;
            top: 20px;
            right: 20px;
            margin-top: 10px;
            margin-right: 10px;
        }

        .login-button a {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            text-decoration: none;
        }

        .login-button a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>THÔNG TIN NHÂN VIÊN</h2>
    <table>
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới Tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
        </tr>
        <?php
        // Thông tin kết nối đến cơ sở dữ liệu
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ql_nhansu";

        // Tạo kết nối đến cơ sở dữ liệu
        $conn = new mysqli($servername, $username, $password, $database);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        // Số lượng nhân viên trên mỗi trang
        $employees_per_page = 5;

        // Truy vấn SQL để đếm tổng số nhân viên
        $sql_count = "SELECT COUNT(*) AS total FROM NhanVien";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $total_employees = $row_count['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_employees / $employees_per_page);

        // Xác định trang hiện tại
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính vị trí bắt đầu của dữ liệu trên trang hiện tại
        $start = ($current_page - 1) * $employees_per_page;

        // Truy vấn SQL để lấy dữ liệu từ bảng nhân viên
        $sql = "SELECT * FROM NhanVien LIMIT $start, $employees_per_page";
        $result = $conn->query($sql);

        // Hiển thị dữ liệu trên trang web
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["Ma_NV"]."</td>";
                echo "<td>".$row["Ten_NV"]."</td>";
                $gender_icon = ($row["Phai"] == "NAM") ? "man.jpg" : "woman.jpg";
                echo "<td><img class='gender-icon' src='image/".$gender_icon."' alt='".$row["Phai"]."'></td>";
                echo "<td>".$row["Noi_Sinh"]."</td>";
                echo "<td>".$row["Ma_Phong"]."</td>";
                echo "<td>".$row["Luong"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <!-- Hiển thị các liên kết phân trang -->
    <div class="pagination">
        <?php
        // Hiển thị các liên kết phân trang
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo "<a class='active' href='?page=$i'>$i</a> ";
            } else {
                echo "<a href='?page=$i'>$i</a> ";
            }
        }
        ?>
    </div>
    <!-- Nút Đăng nhập -->
    <div class="login-button">
        <a href="login.php">Đăng nhập</a>
    </div>
    
</body>
</html>
