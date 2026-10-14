<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tập Phim</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f6f9; display: flex; justify-content: center; padding-top: 50px; }
        .form-box { background: white; padding: 30px; border-radius: 8px; width: 600px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; color: white; }
        .btn-save { background: #28a745; }
        .btn-back { background: #6c757d; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

<div class="form-box">
    <h2 style="margin-bottom: 20px; color: #00aaff;">Thêm tập cho phim: <span style="color: #333;"><?php echo $movie['title']; ?></span></h2>
    
    <form action="index.php?page=store_episode" method="POST">
        <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">

        <div class="form-group">
            <label>Tên tập (Ví dụ: Tập 1, Tập 2, OVA...)</label>
            <input type="text" name="episode_name" required placeholder="Nhập tên tập...">
        </div>

        <div class="form-group">
            <label>Link Video (Embed URL / Iframe)</label>
            <input type="text" name="content_url" required placeholder="https://www.youtube.com/embed/...">
        </div>

        <div class="form-group">
            <label style="color: #ff5500;">Cập nhật trạng thái phim (Tùy chọn)</label>
            <input type="text" name="episode_badge" value="<?php echo $movie['episode_badge']; ?>" placeholder="Ví dụ: Tập 10/12...">
            <small style="color: #777;">Nhập vào đây sẽ tự đổi chữ trên ảnh bìa phim luôn.</small>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-save">Lưu & Thêm tiếp</button>
            <a href="index.php?page=admin_movies" class="btn btn-back">Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>