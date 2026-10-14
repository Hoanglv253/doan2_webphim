<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xem phim: <?php echo $movie['title']; ?> - YanHH3D</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .watch-container {
            padding: 30px 5%;
            background: #121212;
            min-height: 100vh;
            color: #fff;
        }

        /* Breadcrumb */
        .watch-crumb {
            margin-bottom: 20px;
            color: #888;
            font-size: 14px;
        }

        .watch-crumb a {
            color: #ccc;
        }

        .watch-crumb span {
            color: #00aaff;
        }

        /* Khung Video 16:9 */
        .video-box {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            background: #000;
            border: 1px solid #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
            border-radius: 6px;
        }

        .video-box iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Thông tin server */
        .server-info {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }

        .sv-btn {
            background: #333;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: #ccc;
            cursor: pointer;
        }

        .sv-btn.active {
            background: #00aaff;
            color: white;
        }

        /* --- DANH SÁCH TẬP --- */
        .list-ep-container {
            margin-top: 25px;
            background: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
        }

        .ep-header {
            font-size: 16px;
            font-weight: bold;
            border-left: 4px solid #ff5500;
            padding-left: 10px;
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #fff;
        }

        .ep-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .ep-item {
            display: inline-block;
            min-width: 60px;
            padding: 8px 10px;
            background: #333;
            color: #bbb;
            text-align: center;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .ep-item:hover {
            background: #555;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Style cho tập đang xem */
        .ep-item.active {
            background: #00aaff;
            color: #fff;
            border-color: #0088cc;
            pointer-events: none;
            /* Không cho bấm lại tập đang xem */
        }

        .no-ep-msg {
            color: #777;
            font-style: italic;
        }
    </style>
</head>

<body>

    <?php include 'views/header.php'; ?>

    <div class="watch-container">

        <div class="watch-crumb">
            <a href="index.php">Trang chủ</a> <i class="fas fa-angle-right"></i>
            <a href="index.php?page=detail&id=<?php echo $movie['id']; ?>"><?php echo $movie['title']; ?></a>
            <?php if ($currentEpisode): ?>
                <i class="fas fa-angle-right"></i> <span><?php echo $currentEpisode['episode_name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="video-box">
            <?php if ($currentEpisode): ?>
                <?php
                // XỬ LÝ LINK TRƯỚC KHI HIỂN THỊ
                $url = $currentEpisode['content_url'];

                // 1. Tự sửa link Google Drive
                if (strpos($url, 'drive.google.com') !== false && strpos($url, '/view') !== false) {
                    $url = str_replace('/view', '/preview', $url);
                    // Xóa các tham số rác phía sau nếu có (như ?usp=sharing)
                    $url = explode('?', $url)[0];
                }

                // 2. Tự sửa link YouTube
                if (strpos($url, 'youtube.com/watch?v=') !== false) {
                    $url = str_replace('watch?v=', 'embed/', $url);
                }
                if (strpos($url, 'youtu.be/') !== false) {
                    $url = str_replace('youtu.be/', 'youtube.com/embed/', $url);
                }
                ?>

                <iframe src="<?php echo $url; ?>" allowfullscreen></iframe>

            <?php else: ?>
                <div style="display:flex; justify-content:center; align-items:center; height:100%; color:#fff; flex-direction:column;">
                    <i class="fas fa-film" style="font-size: 40px; margin-bottom: 10px; color: #555;"></i>
                    <p>Phim này chưa cập nhật tập nào!</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="server-info">
            <h2 style="font-size: 20px; color: #00aaff;"><?php echo $movie['title']; ?></h2>
            <div>
                <span class="sv-btn active"><i class="fas fa-server"></i> Server VIP</span>
                <span class="sv-btn"><i class="fas fa-random"></i> Dự phòng</span>
            </div>
        </div>

        <div class="list-ep-container">
            <div class="ep-header">Danh Sách Tập</div>

            <div class="ep-grid">
                <?php if (!empty($listEpisodes)): ?>
                    <?php foreach ($listEpisodes as $ep): ?>
                        <?php
                        $isActive = ($currentEpisode && $currentEpisode['id'] == $ep['id']) ? 'active' : '';
                        ?>

                        <a href="index.php?page=watch&id=<?php echo $movie['id']; ?>&ep=<?php echo $ep['id']; ?>"
                            class="ep-item <?php echo $isActive; ?>">
                            <?php echo $ep['episode_name']; ?>
                        </a>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-ep-msg">Đang cập nhật danh sách tập...</p>
                <?php endif; ?>
            </div>
        </div>

            <div class="bottom-container" style="display: flex; gap: 30px; padding: 40px; background: #121212;">
        <div style="flex: 3;">
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

    </div>

</body>

</html>