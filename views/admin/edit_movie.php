<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Phim: <?php echo $movie['title']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #f4f6f9;
            color: #333;
        }

        .form-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-submit {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Sửa Phim</h2>
        <form action="index.php?page=update_movie" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">

            <label>Tên phim</label>
            <input type="text" name="title" value="<?php echo $movie['title']; ?>" required>

            <label>Mô tả</label>
            <textarea name="description" rows="5"><?php echo $movie['description']; ?></textarea>

            <label>Trạng thái (Tập x/y)</label>
            <input type="text" name="episode_badge" value="<?php echo $movie['episode_badge']; ?>">

            <label>Ảnh Poster (Chỉ chọn nếu muốn đổi ảnh khác)</label>
            <br>
            <img src="assets/images/phim/<?php echo $movie['image_url']; ?>" width="100" style="margin-bottom: 10px;">
            <input type="file" name="image">

            <label>
                <input type="checkbox" name="is_hot" value="1" <?php echo ($movie['is_hot'] == 1) ? 'checked' : ''; ?> style="width:auto;">
                Phim Hot (Hiển thị Slider)
            </label>
            <br><br>


            <label style="display:block; font-weight:bold; margin-bottom:5px;">Lịch Chiếu:</label>
            <select name="schedule_day" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="0" <?php echo ($movie['schedule_day'] == 0) ? 'selected' : ''; ?>>-- Không có lịch --</option>
                <option value="2" <?php echo ($movie['schedule_day'] == 2) ? 'selected' : ''; ?>>Thứ 2</option>
                <option value="3" <?php echo ($movie['schedule_day'] == 3) ? 'selected' : ''; ?>>Thứ 3</option>
                <option value="4" <?php echo ($movie['schedule_day'] == 4) ? 'selected' : ''; ?>>Thứ 4</option>
                <option value="5" <?php echo ($movie['schedule_day'] == 5) ? 'selected' : ''; ?>>Thứ 5</option>
                <option value="6" <?php echo ($movie['schedule_day'] == 6) ? 'selected' : ''; ?>>Thứ 6</option>
                <option value="7" <?php echo ($movie['schedule_day'] == 7) ? 'selected' : ''; ?>>Thứ 7</option>
                <option value="8" <?php echo ($movie['schedule_day'] == 8) ? 'selected' : ''; ?>>Chủ Nhật</option>
            </select>


            <button type="submit" class="btn-submit">Lưu Thay Đổi</button>
            <a href="index.php?page=admin_movies" style="margin-left: 20px;">Hủy</a>
        </form>
    </div>
</body>

</html>