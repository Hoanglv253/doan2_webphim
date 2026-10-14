<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - YanHH3D</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Riêng cho trang Admin */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f9;
            color: #333;
        }

        /* Sidebar bên trái */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #4b545c;
        }

        .sidebar-header h3 {
            color: #00aaff;
            margin: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 20px;
            color: #c2c7d0;
            text-decoration: none;
            transition: 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #494e53;
            color: #fff;
            border-left-color: #00aaff;
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Nội dung chính bên phải */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }

        .top-bar {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .admin-info {
            font-weight: bold;
        }

        .btn-logout {
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }

        /* Các thẻ thống kê (Dashboard Cards) */
        .stats-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #333;
        }

        .stat-info p {
            color: #777;
            font-size: 14px;
        }

        .stat-icon {
            font-size: 40px;
            opacity: 0.2;
        }

        /* Màu sắc icon */
        .c-blue {
            color: #007bff;
        }

        .c-green {
            color: #28a745;
        }

        .c-yellow {
            color: #ffc107;
        }

        .c-red {
            color: #dc3545;
        }

        .welcome-panel {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>YANHH3D ADMIN</h3>
        </div>
        <div class="sidebar-menu">
            <a href="index.php?page=admin_dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Tổng quan</a>
            <a href="index.php?page=admin_movies"><i class="fas fa-film"></i> Quản lý Phim</a>
            <a href="index.php?page=admin_users"><i class="fas fa-users"></i> Quản lý Thành viên</a>
            <a href="index.php?page=admin_comments"><i class="fas fa-comments"></i> Bình luận</a>
            <a href="index.php"><i class="fas fa-home"></i> Xem Trang Chủ</a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2>Dashboard</h2>
            <div class="admin-info">
                Xin chào, <?php echo $_SESSION['fullname']; ?>
                <span style="margin: 0 10px;">|</span>
                <a href="index.php?page=logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo isset($totalMovies) ? $totalMovies : 0; ?></h3>
                    <p>Tổng số phim</p>
                </div>
                <div class="stat-icon c-blue"><i class="fas fa-film"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $totalUsers; ?></h3>
                    <p>Thành viên</p>
                </div>
                <div class="stat-icon c-green"><i class="fas fa-users"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $totalComments; ?></h3>
                    <p>Bình luận mới</p>
                </div>
                <div class="stat-icon c-yellow"><i class="fas fa-comments"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Báo cáo lỗi</p>
                </div>
                <div class="stat-icon c-red"><i class="fas fa-bug"></i></div>
            </div>
        </div>

        <div class="welcome-panel">
            <h2>Chào mừng quay trở lại trang quản trị!</h2>
            <p style="margin-top: 10px; color: #666;">Chọn một chức năng ở menu bên trái để bắt đầu quản lý hệ thống phim.</p>
        </div>
    </div>

</body>

</html>