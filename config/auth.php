<?php
// Kiểm tra đã đăng nhập chưa
function isLogin() {
    return isset($_SESSION['user_logged_in']);
}

// Kiểm tra có phải Admin không
function isAdmin() {
    // Kiểm tra session role có tồn tại và bằng chuỗi 'admin' hay không
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        return true; 
    }
    return false;
}

// Chặn truy cập nếu không phải admin
function requireAdmin() {
    if (!isAdmin()) {
        echo "<script>alert('Bạn không có quyền truy cập trang quản trị!'); window.location.href='index.php';</script>";
        exit();
    }
}
?>