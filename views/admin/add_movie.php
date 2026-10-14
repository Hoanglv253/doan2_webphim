<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Phim Mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* --- COPY CSS CHUẨN TỪ MOVIE_LIST SANG --- */
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f0f2f5; margin: 0; color: #444; }

        /* SIDEBAR */
        .sidebar { width: 260px; background-color: #343a40; color: #fff; display: flex; flex-direction: column; position: fixed; height: 100%; z-index: 100; }
        .sidebar-header { padding: 25px; text-align: center; border-bottom: 1px solid #4b545c; }
        .sidebar-header h3 { margin: 0; font-size: 20px; letter-spacing: 1px; color: #fff; }
        .sidebar-header span { color: #00aaff; }
        .sidebar-menu { padding-top: 20px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 15px; padding: 15px 25px; color: #c2c7d0; text-decoration: none; transition: 0.3s; border-left: 3px solid transparent; font-weight: 500; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: #494e53; color: #fff; border-left-color: #00aaff; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }

        /* FORM STYLE */
        .card-box { background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 30px; max-width: 900px; margin: 0 auto; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .page-title { font-size: 22px; font-weight: bold; color: #1e1e2d; }

        .form-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .form-col { flex: 1; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
        
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; transition: 0.3s; }
        .form-control:focus { border-color: #00aaff; outline: none; box-shadow: 0 0 5px rgba(0, 170, 255, 0.2); }
        
        textarea.form-control { resize: vertical; min-height: 100px; }

        /* Checkbox box */
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 15px; padding: 15px; border: 1px solid #eee; border-radius: 6px; background: #f9f9f9; }
        .checkbox-item { display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; width: 140px; }
        .checkbox-item input { accent-color: #00aaff; transform: scale(1.2); }

        /* Buttons */
        .btn-submit { background: linear-gradient(45deg, #007bff, #0056b3); color: white; border: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 15px; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,123,255,0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,123,255,0.4); }
        
        .btn-cancel { text-decoration: none; color: #666; padding: 12px 20px; margin-right: 10px; font-weight: 500; }
        .btn-cancel:hover { color: #333; }

        .preview-img { width: 100px; height: 140px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; display: none; margin-top: 10px; }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>LVHPHIM<span>.ADMIN</span></h3>
        </div>
        <div class="sidebar-menu">
            <a href="index.php?page=admin_dashboard"><i class="fas fa-tachometer-alt"></i> Tổng quan</a>
            <a href="index.php?page=admin_movies" class="active"><i class="fas fa-film"></i> Quản lý Phim</a>
            <a href="index.php?page=admin_users"><i class="fas fa-users"></i> Thành viên</a>
            <a href="index.php?page=admin_comments"><i class="fas fa-comments"></i> Bình luận</a>
            <a href="index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Xem Website</a>
        </div>
    </div>

    <div class="main-content">
        
        <div class="card-box">
            <div class="page-header">
                <div class="page-title"><i class="fas fa-plus-circle"></i> Thêm Phim Mới</div>
                <a href="index.php?page=admin_movies" class="btn-cancel"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>

            <form action="index.php?page=store_movie" method="POST" enctype="multipart/form-data">
                
                <div class="form-row">
                    <div class="form-col" style="flex: 2;">
                        <div class="form-group">
                            <label>Tên phim <span style="color:red">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="Nhập tên phim...">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Trạng thái (Badge)</label>
                            <input type="text" name="episode_badge" class="form-control" placeholder="VD: Tập 10, Full HD...">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mô tả nội dung</label>
                    <textarea name="description" class="form-control" placeholder="Tóm tắt nội dung phim..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Lịch Chiếu</label>
                            <select name="schedule_day" class="form-control">
                                <option value="0">-- Không có lịch --</option>
                                <option value="2">Thứ 2 (Monday)</option>
                                <option value="3">Thứ 3 (Tuesday)</option>
                                <option value="4">Thứ 4 (Wednesday)</option>
                                <option value="5">Thứ 5 (Thursday)</option>
                                <option value="6">Thứ 6 (Friday)</option>
                                <option value="7">Thứ 7 (Saturday)</option>
                                <option value="8">Chủ Nhật (Sunday)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Ảnh Poster <span style="color:red">*</span></label>
                            <input type="file" name="image" class="form-control" required onchange="previewImage(this)">
                            <img id="imgPreview" class="preview-img">
                        </div>
                        
                        <div class="form-group">
                            <label style="cursor:pointer; display:flex; align-items:center; gap:10px;">
                                <input type="checkbox" name="is_hot" value="1" style="transform: scale(1.5);"> 
                                <strong>Đặt làm Phim HOT (Hiện Slider trang chủ)</strong>
                            </label>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label>Thể loại</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="1"> Huyền Huyễn</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="2"> Xuyên Không</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="3"> Trùng Sinh</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="4"> Tiên Hiệp</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="5"> Cổ Trang</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="6"> Hài Hước</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="7"> Kiếm Hiệp</label>
                                <label class="checkbox-item"><input type="checkbox" name="genres[]" value="8"> Hiện Đại</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Lưu Phim Mới</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script xem trước ảnh khi chọn
        function previewImage(input) {
            var preview = document.getElementById('imgPreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>