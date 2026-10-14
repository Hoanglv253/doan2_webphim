<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phim Yêu Thích - YanHH3D</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<?php include 'views/header.php'; ?>

<div class="search-container" style="min-height: 80vh;">
    <div class="section-header">
        <h2 class="cat-title" style="color: #ff5500; border-color: #ff5500;">
            <i class="fas fa-heart"></i> Phim Yêu Thích Của Tôi
        </h2>
    </div>

    <?php if (!empty($favoriteMovies)): ?>
        <div class="movie-grid">
            <?php foreach ($favoriteMovies as $movie): ?>
                <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>" class="movie-item">
                    <img src="assets/images/phim/<?php echo $movie['image_url']; ?>" 
                         onerror="this.src='assets/images/no-image.jpg'">
                    
                    <div class="movie-info">
                        <h3><?php echo $movie['title']; ?></h3>
                    </div>
                    
                    <span class="badge-episode" style="position:absolute; top:5px; left:5px; background:#ff5500; color:#fff; padding:2px 6px; font-size:11px; border-radius:4px;">
                        <?php echo $movie['episode_badge']; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; margin-top: 50px; color: #888;">
            <i class="fas fa-heart-broken" style="font-size: 50px; margin-bottom: 20px;"></i>
            <p>Bạn chưa có phim yêu thích nào.</p>
            <a href="index.php" style="color: #00aaff; text-decoration: underline;">Quay lại trang chủ tìm phim ngay</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>