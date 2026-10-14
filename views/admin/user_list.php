<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Thành viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Copy style từ movie_list.php sang đây hoặc để chung 1 file css admin */
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; background: #f0f2f5; margin: 0; min-height: 100vh; }
        .sidebar { width: 260px; background: #343a40; color: #fff; position: fixed; height: 100%; }
        .sidebar-header { padding: 25px; text-align: center; border-bottom: 1px solid #4b545c; } 
        .sidebar-menu a { display: flex; gap: 10px; padding: 15px 25px; color: #c2c7d0; text-decoration: none; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #494e53; color: white; border-left: 4px solid #00aaff; }
        
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .card-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #f8f9fa; padding: 15px; text-align: left; color: #666; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #eee; color: #444; }
        
        .role-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .role-admin { background: #ffe2e5; color: #f64e60; }
        .role-user { background: #e1f0ff; color: #3699ff; }
        
        .btn-del { width: 35px; height: 35px; border-radius: 6px; background: #ffe2e5; color: #f64e60; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-del:hover { background: #ffc9cc; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header"><h3>LVHPHIM ADMIN</h3></div>
        <div class="sidebar-menu">
            <a href="index.php?page=admin_dashboard"><i class="fas fa-tachometer-alt"></i> Tổng quan</a>
            <a href="index.php?page=admin_movies"><i class="fas fa-film"></i> Quản lý Phim</a>
            <a href="index.php?page=admin_users" class="active"><i class="fas fa-users"></i> Thành viên</a>
            <a href="index.php?page=admin_comments"><i class="fas fa-comments"></i> Bình luận</a>
            <a href="index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Xem Website</a>
        </div>
    </div>

    <div class="main-content">
        <h2 style="margin-bottom: 20px;">Danh sách Thành viên</h2>
        
        <div class="card-box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td>#<?php echo $u['id']; ?></td>
                        <td style="font-weight: bold;"><?php echo htmlspecialchars($u['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td>
                            <?php if ($u['role'] == 'admin'): ?>
                                <span class="role-badge role-admin">Admin</span>
                            <?php else: ?>
                                <span class="role-badge role-user">Thành viên</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['role'] != 'admin'): ?>
                                <a href="index.php?page=delete_user&id=<?php echo $u['id']; ?>" class="btn-del" onclick="return confirm('Xóa thành viên này?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>