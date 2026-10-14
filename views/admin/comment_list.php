<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Bình luận</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Style tương tự file trên */
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
        td { padding: 15px; border-bottom: 1px solid #eee; color: #444; font-size: 14px; vertical-align: top;}
        
        .movie-link { color: #00aaff; font-weight: bold; text-decoration: none; }
        .user-name { font-weight: bold; color: #333; }
        .cmt-time { font-size: 12px; color: #888; display: block; margin-top: 5px; }
        
        .btn-del { width: 32px; height: 32px; border-radius: 6px; background: #ffe2e5; color: #f64e60; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-del:hover { background: #ffc9cc; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header"><h3>LVHPHIM ADMIN</h3></div>
        <div class="sidebar-menu">
            <a href="index.php?page=admin_dashboard"><i class="fas fa-tachometer-alt"></i> Tổng quan</a>
            <a href="index.php?page=admin_movies"><i class="fas fa-film"></i> Quản lý Phim</a>
            <a href="index.php?page=admin_users"><i class="fas fa-users"></i> Thành viên</a>
            <a href="index.php?page=admin_comments" class="active"><i class="fas fa-comments"></i> Bình luận</a>
            <a href="index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Xem Website</a>
        </div>
    </div>

    <div class="main-content">
        <h2 style="margin-bottom: 20px;">Quản lý Bình luận</h2>
        
        <div class="card-box">
            <table>
                <thead>
                    <tr>
                        <th width="50">#ID</th>
                        <th width="150">Người dùng</th>
                        <th>Nội dung bình luận</th>
                        <th width="200">Phim</th>
                        <th width="80">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $cmt): ?>
                    <tr>
                        <td><?php echo $cmt['id']; ?></td>
                        <td>
                            <div class="user-name"><?php echo htmlspecialchars($cmt['username']); ?></div>
                            <span class="cmt-time"><?php echo date('d/m/Y H:i', strtotime($cmt['created_at'])); ?></span>
                        </td>
                        <td><?php echo nl2br(htmlspecialchars($cmt['content'])); ?></td>
                        <td>
                            <a href="index.php?page=detail&id=<?php echo $cmt['movie_id']; ?>" target="_blank" class="movie-link">
                                <?php echo htmlspecialchars($cmt['movie_title']); ?>
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=delete_comment&id=<?php echo $cmt['id']; ?>" class="btn-del" onclick="return confirm('Xóa bình luận này?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if (empty($comments)): ?>
                <p style="text-align: center; padding: 20px; color: #999;">Chưa có bình luận nào.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>