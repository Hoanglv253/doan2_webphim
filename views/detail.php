<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?php echo $movie['title']; ?> - YanHH3D</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>

    <?php include 'views/header.php'; ?>

    <div class="detail-backdrop" style="background-image: url('assets/images/phim/<?php echo $movie['image_url']; ?>');">
        <div class="overlay-black"></div>

        <div class="detail-content">

            <div class="detail-left">
                <div class="poster-box">
                    <img src="assets/images/phim/<?php echo $movie['image_url']; ?>"
                        onerror="this.src='assets/images/no-image.jpg'" alt="<?php echo $movie['title']; ?>">
                </div>

                <a href="index.php?page=add_favorite&id=<?php echo $movie['id']; ?>" class="btn-fav-large">
                    <i class="fas fa-plus"></i> Yêu thích
                </a>
            </div>

            <div class="detail-right">

                <div class="bread-crumb">
                    <a href="index.php">Trang chủ</a> <i class="fas fa-angle-right"></i> <span><?php echo $movie['title']; ?></span>
                </div>

                <h1 class="d-title"><?php echo $movie['title']; ?></h1>

                <div class="d-actions">
                    <a href="index.php?page=watch&id=<?php echo $movie['id']; ?>" class="btn-play blue">
                        <i class="fas fa-play"></i> Xem Thuyết Minh
                    </a>
                    <a href="index.php?page=watch&id=<?php echo $movie['id']; ?>" class="btn-play cyan">
                        <i class="fas fa-play"></i> Xem Vietsub
                    </a>
                </div>

                <div class="info-grid">

                    <div class="info-desc">
                        <div class="warning-box">
                            ✨ <?php echo $movie['episode_badge']; ?>
                        </div>

                        <p class="desc-text">
                            <?php
                            // Kiểm tra nếu có dữ liệu description thì hiển thị, nếu không thì hiện thông báo
                            if (!empty($movie['description'])) {
                                // Hàm nl2br giúp chuyển các dấu xuống dòng trong Database thành thẻ <br> của HTML
                                echo nl2br($movie['description']);
                            } else {
                                echo '<span style="color: #777; font-style: italic;">Nội dung phim đang được cập nhật...</span>';
                            }
                            ?>

                        </p>


                    </div>
                    <div class="info-meta-box">
                        <ul>
                            <li><span class="meta-label">Thời lượng:</span> 20 phút/tập [4K]</li>
                            <li><span class="meta-label">Trạng thái:</span> <span class="status-on">Đang Chiếu</span></li>
                            <li>
                                <span class="meta-label">Lịch chiếu:</span>
                                <?php
                                // 1. Tạo mảng đối chiếu số -> chữ
                                $daysLabel = [
                                    0 => 'Đang cập nhật',
                                    2 => 'Thứ 2 hàng tuần',
                                    3 => 'Thứ 3 hàng tuần',
                                    4 => 'Thứ 4 hàng tuần',
                                    5 => 'Thứ 5 hàng tuần',
                                    6 => 'Thứ 6 hàng tuần',
                                    7 => 'Thứ 7 hàng tuần',
                                    8 => 'Chủ Nhật hàng tuần'
                                ];

                                // 2. Lấy số từ database (Nếu không có thì mặc định là 0)
                                $dayVal = isset($movie['schedule_day']) ? (int)$movie['schedule_day'] : 0;

                                // 3. Hiển thị chữ tương ứng, tô màu xanh cho nổi bật
                                $color = ($dayVal > 0) ? '#00ffaa' : '#ccc';
                                echo '<span style="color: ' . $color . '; font-weight: bold;">' . $daysLabel[$dayVal] . '</span>';
                                ?>
                            </li>
                            <li>
                                <span class="meta-label">Tập mới nhất:</span>
                                <span class="badge-ep"><?php echo $movie['episode_badge']; ?></span>
                            </li>
                            <li class="wrap-li">
                                <span class="meta-label">Thể loại:</span>
                                <div class="meta-tags">
                                    <span class="tag" style="border: 1px solid #00aaff; color: #00aaff;">
                                        <?php echo isset($movie['genre_name']) ? $movie['genre_name'] : 'Khác'; ?>
                                    </span>
                                </div>
                            </li>
                            <li><span class="meta-label">Năm:</span> 2025</li>
                        </ul>

                        <a href="#comment-section" class="btn-comment-preview" style="display:block; text-decoration:none; color:#fff;">
                            <i class="fas fa-comment"></i>
                            Bình luận (<?php echo isset($listComments) ? count($listComments) : 0; ?>)
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="bottom-container" style="display: flex; gap: 30px; padding: 40px; background: #121212;">
        <div style="flex: 3;" id="comment-section">
            <h3 style="color:white; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px;">
                <i class="fas fa-comments"></i> Bình luận (<?php echo isset($listComments) ? count($listComments) : 0; ?>)
            </h3>

            <div class="comment-form-box" style="margin-bottom: 30px;">
                <?php if (isset($_SESSION['user_logged_in'])): ?>
                    <form action="index.php?page=post_comment" method="POST" style="display: flex; gap: 15px;">
                        <div class="user-avatar" style="width: 50px; height: 50px; background: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; font-size: 20px;">
                            <?php echo isset($_SESSION['fullname']) ? strtoupper(substr($_SESSION['fullname'], 0, 1)) : 'U'; ?>
                        </div>

                        <div style="flex: 1;">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                            <textarea name="content" rows="2" placeholder="Viết bình luận của bạn..." required
                                style="width: 100%; background: #1f2023; border: 1px solid #333; color: #fff; padding: 10px; border-radius: 4px; outline: none;"></textarea>

                            <div style="text-align: right; margin-top: 10px;">
                                <button type="submit" style="background: #00aaff; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">Gửi bình luận</button>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <div style="background: #1f2023; padding: 20px; text-align: center; border-radius: 6px; color: #888;">
                        Bạn cần <a href="index.php?page=login" style="color: #00aaff; font-weight: bold;">Đăng nhập</a> để tham gia bình luận.
                    </div>
                <?php endif; ?>
            </div>

            <div class="comment-list">
                <?php if (!empty($listComments)): ?>
                    <?php foreach ($listComments as $cmt): ?>
                        <div class="cmt-item" style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid #222; padding-bottom: 20px;">
                            <div class="cmt-avatar" style="width: 40px; height: 40px; background: #444; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ccc; font-weight: bold;">
                                <?php echo strtoupper(substr($cmt['fullname'], 0, 1)); ?>
                            </div>

                            <div class="cmt-content">
                                <div style="margin-bottom: 5px;">
                                    <span style="color: #00aaff; font-weight: bold; font-size: 14px; margin-right: 10px;">
                                        <?php echo htmlspecialchars($cmt['fullname']); ?>
                                    </span>
                                    <span style="color: #555; font-size: 12px;">
                                        <i class="far fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($cmt['created_at'])); ?>
                                    </span>
                                </div>
                                <p style="color: #ddd; font-size: 14px; line-height: 1.5;">
                                    <?php echo nl2br(htmlspecialchars($cmt['content'])); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; font-style: italic;">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                <?php endif; ?>
            </div>
        </div>

        <div style="flex: 1;"></div>
    </div>

</body>

</html>

</body>

</html>