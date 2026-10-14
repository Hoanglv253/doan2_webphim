<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm: <?php echo htmlspecialchars($keyword); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

<?php include 'views/header.php'; ?>

<div class="search-container">
    <h2 class="search-title">Kết quả tìm kiếm cho: <span>"<?php echo htmlspecialchars($keyword); ?>"</span></h2>

    <?php if (!empty($searchResults)): ?>
        <div class="movie-grid">
            <?php foreach ($searchResults as $movie): ?>
                <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>" class="movie-item">
                    <img src="assets/images/phim/<?php echo $movie['image_url']; ?>" 
                         onerror="this.src='assets/images/no-image.jpg'">
                    <div class="movie-info">
                        <h3><?php echo $movie['title']; ?></h3>
                    </div>
                    <span class="badge-episode" style="position:absolute; top:5px; left:5px; background:rgba(0,0,0,0.7); color:#fff; padding:2px 6px; font-size:11px; border-radius:4px;">
                        <?php echo $movie['episode_badge']; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="color: #ccc;">Không tìm thấy phim nào phù hợp.</p>
    <?php endif; ?>
</div>

</body>
</html>