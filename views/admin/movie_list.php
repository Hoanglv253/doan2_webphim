<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Phim - LVHPHIM Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* --- 1. CẤU HÌNH CHUNG --- */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f0f2f5; margin: 0; color: #444; }

        /* --- 2. SIDEBAR (MENU TRÁI) - ĐỒNG BỘ DASHBOARD --- */
        .sidebar {
            width: 260px;
            background-color: #343a40; /* Màu tối giống Dashboard */
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .sidebar-header { padding: 25px; text-align: center; border-bottom: 1px solid #4b545c; }
        .sidebar-header h3 { margin: 0; font-size: 20px; letter-spacing: 1px; color: #fff; }
        .sidebar-header span { color: #00aaff; }

        .sidebar-menu { padding-top: 20px; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 15px;
            padding: 15px 25px;
            color: #c2c7d0;
            text-decoration: none;
            transition: 0.3s;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: #494e53;
            color: #fff;
            border-left-color: #00aaff;
        }

        /* --- 3. MAIN CONTENT (NỘI DUNG CHÍNH) --- */
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }

        /* Header của trang */
        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px;
        }
        .page-title { font-size: 24px; font-weight: bold; color: #1e1e2d; }
        
        .btn-add-new {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white; padding: 12px 25px; border-radius: 8px;
            text-decoration: none; font-weight: bold; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
            transition: 0.3s; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-add-new:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4); }

        /* --- 4. BẢNG DỮ LIỆU (DATA TABLE) --- */
        .card-box {
            background: white; border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 20px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }

        thead { background-color: #f8f9fa; border-bottom: 2px solid #eee; }
        th { padding: 15px; text-align: left; font-size: 13px; color: #666; text-transform: uppercase; font-weight: 700; }
        td { padding: 15px; border-bottom: 1px solid #f1f1f1; vertical-align: middle; color: #333; font-size: 14px; }

        tr:hover { background-color: #fafafa; }

        /* Cột Ảnh */
        .movie-thumb {
            width: 50px; height: 70px;
            border-radius: 6px; object-fit: cover;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Cột Tiêu đề */
        .movie-name { font-weight: bold; color: #2d2d2d; font-size: 15px; display: block; margin-bottom: 4px; }
        
        /* Badge trạng thái */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-block; }
        
        .badge-hot { background-color: #ffe2e5; color: #f64e60; } /* Màu đỏ nhạt */
        .badge-normal { background-color: #e1f0ff; color: #3699ff; } /* Màu xanh nhạt */
        .badge-ep { background-color: #eee; color: #555; border: 1px solid #ddd; padding: 2px 8px; border-radius: 4px; font-size: 11px;}
        
        /* Badge Lịch chiếu (Thứ) */
        .badge-day { background-color: #e8fff3; color: #00cc66; border: 1px solid #ccffdd; }
        .badge-no-day { color: #bbb; font-style: italic; font-size: 11px; }

        /* Nút hành động */
        .action-btns { display: flex; gap: 8px; }
        .btn-icon {
            width: 32px; height: 32px; border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: 0.2s; border: none; cursor: pointer;
            font-size: 14px;
        }
        
        .btn-ep { background: #e1f0ff; color: #007bff; }
        .btn-edit { background: #fff4de; color: #ffa800; }
        .btn-del { background: #ffe2e5; color: #f64e60; }

        .btn-icon:hover { transform: scale(1.1); filter: brightness(0.95); }

    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>LVHPHIM<span>.ADMIN</span></h3>
        </div>
        <div class="sidebar-menu">
            <a href="index.php?page=admin_dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Tổng quan</a>
            <a href="index.php?page=admin_movies"><i class="fas fa-film"></i> Quản lý Phim</a>
            <a href="index.php?page=admin_users"><i class="fas fa-users"></i> Quản lý Thành viên</a>
            <a href="index.php?page=admin_comments"><i class="fas fa-comments"></i> Bình luận</a>
            <a href="index.php"><i class="fas fa-home"></i> Xem Trang Chủ</a>
        </div>
        </div>
    </div>

    <div class="main-content">
        
        <div class="page-header">
            <div>
                <div class="page-title">Danh Sách Phim</div>
                <div style="color: #777; font-size: 14px; margin-top: 5px;">Quản lý tất cả phim, tập phim và lịch chiếu</div>
            </div>
            <a href="index.php?page=add_movie" class="btn-add-new">
                <i class="fas fa-plus-circle"></i> Thêm Phim Mới
            </a>
        </div>

        <div class="card-box">
            <table>
                <thead>
                    <tr>
                        <th width="50">#ID</th>
                        <th width="80">Poster</th>
                        <th>Thông tin Phim</th>
                        <th>Trạng thái</th>
                        <th>Lịch chiếu</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Mảng map số sang tên Thứ để hiển thị đẹp
                    $daysLabel = [
                        0 => 'Chưa có', 2 => 'Thứ 2', 3 => 'Thứ 3', 4 => 'Thứ 4',
                        5 => 'Thứ 5', 6 => 'Thứ 6', 7 => 'Thứ 7', 8 => 'Chủ Nhật'
                    ];

                    foreach ($movies as $movie): 
                    ?>
                        <tr>
                            <td>#<?php echo $movie['id']; ?></td>
                            
                            <td>
                                <img src="assets/images/phim/<?php echo $movie['image_url']; ?>" 
                                     onerror="this.src='assets/images/no-image.jpg'" 
                                     class="movie-thumb">
                            </td>
                            
                            <td>
                                <span class="movie-name"><?php echo htmlspecialchars($movie['title']); ?></span>
                                <span class="badge-ep"><?php echo $movie['episode_badge']; ?></span>
                            </td>

                            <td>
                                <?php if ($movie['is_hot'] == 1): ?>
                                    <span class="badge badge-hot">HOT TREND</span>
                                <?php else: ?>
                                    <span class="badge badge-normal">Bình thường</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php 
                                    $dayNum = isset($movie['schedule_day']) ? $movie['schedule_day'] : 0;
                                    if ($dayNum >= 2 && $dayNum <= 8): 
                                ?>
                                    <span class="badge badge-day">
                                        <i class="far fa-calendar-alt"></i> <?php echo $daysLabel[$dayNum]; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge-no-day">--</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="action-btns">
                                    <a href="index.php?page=add_episode&id=<?php echo $movie['id']; ?>" 
                                       class="btn-icon btn-ep" title="Thêm tập mới">
                                        <i class="fas fa-video"></i>
                                    </a>

                                    <a href="index.php?page=edit_movie&id=<?php echo $movie['id']; ?>" 
                                       class="btn-icon btn-edit" title="Sửa phim">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <a href="index.php?page=delete_movie&id=<?php echo $movie['id']; ?>" 
                                       class="btn-icon btn-del" title="Xóa phim"
                                       onclick="return confirm('Cảnh báo: Hành động này sẽ xóa cả các tập phim và bình luận bên trong. Bạn chắc chắn chứ?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php if (empty($movies)): ?>
                <div style="text-align: center; padding: 40px; color: #999;">
                    <i class="fas fa-film" style="font-size: 40px; margin-bottom: 15px; opacity: 0.5;"></i>
                    <p>Chưa có bộ phim nào trong hệ thống.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>