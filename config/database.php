<?php
$servername = "127.0.0.1";   // dùng 127.0.0.1 tránh lỗi socket
$username   = "root";        // tài khoản mặc định của XAMPP
$password   = "";            // mật khẩu trống nếu chưa đổi
$dbname     = "movie_db";   // đổi thành tên database của bạn
$port       = 3307;          // đổi thành cổng của bạn (3306 hoặc 3307)

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
