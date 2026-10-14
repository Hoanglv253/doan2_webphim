<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LVHPHIM.VIP - Trang Chủ</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>

    <?php include 'views/header.php'; ?>

    <div class="hot-movie-container">
        <div class="section-title">
            <h2>PHIM ĐỀ CỬ</h2>
        </div>

        <div class="relative-wrapper">

            <button class="nav-btn prev" onclick="scrollSlider(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="movie-slider" id="hotMovieSlider">
                <?php if (!empty($hotMovies)): ?>
                    <?php foreach ($hotMovies as $movie): ?>
                        <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>" class="movie-card-hot">
                            <div class="poster-hot">
                                <img src="assets/images/phim/<?php echo $movie['image_url']; ?>"
                                    onerror="this.src='assets/images/no-image.jpg'"
                                    alt="<?php echo $movie['title']; ?>">

                                <span class="badge-episode"><?php echo $movie['episode_badge']; ?></span>

                                <h3 class="title-hot"><?php echo $movie['title']; ?></h3>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #999; padding: 20px;">Chưa có phim đề cử.</p>
                <?php endif; ?>
            </div>

            <button class="nav-btn next" onclick="scrollSlider(1)">
                <i class="fas fa-chevron-right"></i>
            </button>

        </div>
    </div>

    <script src="assets/js/style.js"></script>

    <div class="main-body-container">

        <div class="left-content">
            <div class="section-header">
                <h2 class="cat-title">Mới Cập Nhật</h2>
                <div class="cat-tags">
                    <span class="active">Tất cả</span>
                    <span>3D</span>
                    <span>2D</span>
                    <span>Anime</span>
                </div>
            </div>

            <div class="movie-grid-update">
                <?php if (!empty($newMovies)): ?>
                    <?php foreach ($newMovies as $movie): ?>
                        <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>" class="movie-card-hot movie-item-grid">
                            <div class="poster-hot">
                                <img src="assets/images/phim/<?php echo $movie['image_url']; ?>"
                                    onerror="this.src='assets/images/no-image.jpg'"
                                    alt="<?php echo $movie['title']; ?>">
                                <span class="badge-episode"><?php echo $movie['episode_badge']; ?></span>
                                <h3 class="title-hot"><?php echo $movie['title']; ?></h3>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #ccc; padding: 20px;">Đang cập nhật phim...</p>
                <?php endif; ?>
            </div>

            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="pagination">

                    <?php if (isset($page) && $page > 1): ?>
                        <a href="index.php?page=home&p=<?php echo $page - 1; ?>">&laquo;</a>
                    <?php endif; ?>

                    <?php
                    $range = 1; // Số lượng trang hiển thị xung quanh trang hiện tại (1 trái + 1 phải = 3 trang)

                    for ($i = 1; $i <= $totalPages; $i++) {

                        // Điều kiện hiển thị số trang:
                        // - Là trang 1 hoặc trang cuối cùng (Để người dùng biết điểm đầu cuối)
                        // - Hoặc nằm trong khoảng (Trang hiện tại - 1) đến (Trang hiện tại + 1)
                        if ($i == 1 || $i == $totalPages || ($i >= $page - $range && $i <= $page + $range)) {
                            $active = ($i == $page) ? 'active' : '';
                            echo '<a href="index.php?page=home&p=' . $i . '" class="' . $active . '">' . $i . '</a>';
                        }
                        // Điều kiện hiển thị dấu 3 chấm (...)
                        // Chỉ hiện khi có khoảng cách lớn hơn 1 đơn vị
                        elseif ($i == $page - $range - 1 || $i == $page + $range + 1) {
                            echo '<span class="dots" style="padding: 0 5px; color: #888;">...</span>';
                        }
                    }
                    ?>

                    <?php if (isset($page) && $page < $totalPages): ?>
                        <a href="index.php?page=home&p=<?php echo $page + 1; ?>">&raquo;</a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <style>
                /* 1. Tổng thể khung lịch */
                .schedule-section {
                    background-color: #1a1a1a;
                    /* Nền tối giống mẫu */
                    margin-bottom: 40px;
                    padding-top: 10px;
                }

                /* 2. Header: Tiêu đề + Badge tím */
                .schedule-header-row {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 20px;
                }

                .schedule-title {
                    color: #00ffaa;
                    /* Màu xanh ngọc của chữ Lịch Phim */
                    font-size: 20px;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: 0;
                }

                .today-badge {
                    background-color: #7b2cbf;
                    /* MÀU TÍM GIỐNG HÌNH */
                    color: #fff;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: 600;
                    display: inline-block;
                }

                /* 3. Hàng nút Tab (Thứ 2 -> CN) */
                .schedule-tabs-container {
                    display: flex;
                    justify-content: space-between;
                    gap: 8px;
                    background-color: #222;
                    /* Nền xám của cả hàng */
                    padding: 10px;
                    border-radius: 8px;
                    overflow-x: auto;
                }

                .day-tab {
                    flex: 1;
                    /* Chia đều chiều rộng */
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background-color: #2d2d2d;
                    /* Màu xám mặc định */
                    padding: 10px 5px;
                    border-radius: 6px;
                    text-decoration: none;
                    transition: all 0.3s;
                    min-width: 90px;
                    cursor: pointer;
                }

                /* Chữ bên trong nút */
                .day-vn {
                    color: #fff;
                    font-weight: bold;
                    font-size: 14px;
                    margin-bottom: 3px;
                }

                .day-en {
                    color: #888;
                    font-size: 12px;
                    font-weight: normal;
                }

                /* 4. TRẠNG THÁI ACTIVE (Màu Xanh Dương Sáng như hình) */
                .day-tab.active {
                    background-color: #00b3ff;
                    /* MÀU XANH GIỐNG HÌNH */
                    box-shadow: 0 0 10px rgba(0, 179, 255, 0.4);
                    transform: translateY(-2px);
                }

                /* Khi active thì chữ đổi màu trắng hết */
                .day-tab.active .day-vn,
                .day-tab.active .day-en {
                    color: #fff !important;
                }

                /* Hover nhẹ */
                .day-tab:hover:not(.active) {
                    background-color: #383838;
                }
            </style>

            <div class="schedule-section">

                <div class="schedule-header-row">
                    <h2 class="schedule-title">Lịch Phim</h2>
                    <span class="today-badge">
                        Hôm nay: <?php
                                    $daysMap = [
                                        1 => 'Thứ 2',
                                        2 => 'Thứ 3',
                                        3 => 'Thứ 4',
                                        4 => 'Thứ 5',
                                        5 => 'Thứ 6',
                                        6 => 'Thứ 7',
                                        7 => 'Chủ Nhật'
                                    ];
                                    // date('N') trả về 1 (Thứ 2) -> 7 (CN)
                                    echo $daysMap[date('N')] . ', ngày ' . date('d/m/Y');
                                    ?>
                    </span>
                </div>

                <div class="schedule-tabs-container">
                    <?php
                    // Cấu hình dữ liệu
                    $weekDays = [
                        2 => ['vn' => 'Thứ 2', 'en' => 'Monday'],
                        3 => ['vn' => 'Thứ 3', 'en' => 'Tuesday'],
                        4 => ['vn' => 'Thứ 4', 'en' => 'Wednesday'],
                        5 => ['vn' => 'Thứ 5', 'en' => 'Thursday'],
                        6 => ['vn' => 'Thứ 6', 'en' => 'Friday'],
                        7 => ['vn' => 'Thứ 7', 'en' => 'Saturday'],
                        8 => ['vn' => 'Chủ Nhật', 'en' => 'Sunday']
                    ];

                    // Mặc định nếu không chọn thì lấy hôm nay
                    // Lưu ý: date('N') của PHP là 1->7. Quy ước của bạn là 2->8. Nên cần +1.
                    $todayIndex = date('N') + 1;
                    $currentDay = isset($_GET['day']) ? (int)$_GET['day'] : $todayIndex;

                    foreach ($weekDays as $num => $txt):
                        $isActive = ($num == $currentDay) ? 'active' : '';
                    ?>
                        <a href="index.php?day=<?php echo $num; ?>" class="day-tab <?php echo $isActive; ?>">
                            <span class="day-vn"><?php echo $txt['vn']; ?></span>
                            <span class="day-en"><?php echo $txt['en']; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="movie-grid-update" style="margin-top: 25px;">
                    <?php if (!empty($scheduleMovies)): ?>
                        <?php foreach ($scheduleMovies as $movie): ?>
                            <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>" class="movie-card-hot movie-item-grid">
                                <div class="poster-hot">
                                    <img src="assets/images/phim/<?php echo $movie['image_url']; ?>"
                                        onerror="this.src='assets/images/no-image.jpg'"
                                        alt="<?php echo $movie['title']; ?>">

                                    <span class="badge-episode" style="background: linear-gradient(to right, #ff3300, #ff6600);">
                                        <?php echo $movie['episode_badge']; ?>
                                    </span>

                                    <h3 class="title-hot"><?php echo $movie['title']; ?></h3>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="width: 100%; text-align: center; padding: 40px; background: #222; border-radius: 8px; color: #777; margin-top: 10px;">
                            <p>Chưa có lịch chiếu phim cho <?php echo $weekDays[$currentDay]['vn']; ?>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>



        <div class="right-sidebar">

            <div class="section-header">
                <h2 class="cat-title" style="border-color: #00aaff;">Bảng Xếp Hạng</h2>
            </div>

            <div class="ranking-board">
                <?php if (!empty($rankingMovies)): ?>
                    <?php
                    $rank = 1;
                    foreach ($rankingMovies as $top):
                    ?>
                        <a href="index.php?page=detail&id=<?php echo $top['id']; ?>" class="rank-item">

                            <div class="rank-num rank-<?php echo $rank; ?>">
                                <?php echo $rank; ?>
                            </div>

                            <div class="rank-thumb">
                                <img src="assets/images/phim/<?php echo $top['image_url']; ?>"
                                    onerror="this.src='assets/images/no-image.jpg'"
                                    alt="<?php echo $top['title']; ?>">
                            </div>

                            <div class="rank-info">
                                <h4 class="rank-title"><?php echo $top['title']; ?></h4>
                                <span class="rank-meta"><?php echo $top['episode_badge']; ?></span>
                            </div>
                        </a>
                    <?php
                        $rank++;
                    endforeach;
                    ?>
                <?php endif; ?>
            </div>

            <div class="section-header" style="margin-top: 30px; margin-bottom: 15px;">
                <h2 class="genre-header-text">Thể Loại</h2>
            </div>

            <div class="genre-grid-box">
                <a href="index.php?page=genre&id=1" class="g-item text-yellow">Huyền Huyễn</a>
                <a href="index.php?page=genre&id=2" class="g-item text-yellow">Xuyên Không</a>

                <a href="index.php?page=genre&id=3" class="g-item text-red">Trùng Sinh</a>
                <a href="index.php?page=genre&id=4" class="g-item text-purple">Tiên Hiệp</a>

                <a href="index.php?page=genre&id=5" class="g-item text-cyan">Cổ Trang</a>
                <a href="index.php?page=genre&id=6" class="g-item text-cyan">Hài Hước</a>

                <a href="index.php?page=genre&id=7" class="g-item text-green">Kiếm Hiệp</a>
                <a href="index.php?page=genre&id=8" class="g-item text-green">Hiện Đại</a>
            </div>
        </div>
    </div>
    <?php include 'views/footer.php'; ?>
</body>

</html>