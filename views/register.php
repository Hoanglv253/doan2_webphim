<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký - YanHH3D</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
    <?php include 'views/header.php'; ?>

    <div class="login-wrapper">
        <div class="login-box" style="margin-top: 50px;"> <div class="login-header">
                <i class="fas fa-user-plus"></i> 
                <h2>Đăng Ký</h2>
            </div>

            <form action="index.php?page=register" method="POST">
                
                <?php if (!empty($error)): ?>
                    <p class="error-msg" style="color: red; text-align: center;"><?php echo $error; ?></p>
                <?php endif; ?>

                <div class="input-group">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" required placeholder="Nhập họ tên hiển thị">
                </div>

                <div class="input-group">
                    <label>Tài khoản (Username)</label>
                    <input type="text" name="username" required placeholder="Viết liền không dấu">
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Nhập email">
                </div>

                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required placeholder="">
                </div>

                <div class="input-group">
                    <label>Nhập lại mật khẩu</label>
                    <input type="password" name="confirm_password" required placeholder="">
                </div>

                <div class="actions">
                    <button type="submit" class="btn-submit">ĐĂNG KÝ NGAY</button>
                </div>
            </form>

            <div class="register-section">
                <span>Đã có tài khoản? </span>
                <a href="index.php?page=login" class="btn-register">ĐĂNG NHẬP</a>
            </div>
        </div>
                <div class="login-footer-info">
            <div class="footer-logo">LVHPHIM<span>.VIP</span></div>
            <div class="footer-tags">
                <span class="tag">LVHPHIM.net</span>
                <span class="tag">LVHPHIM.vip</span>
            </div>
            <p class="contact-text">Liên hệ Telegrame: @ftmn2025 | Texlink: @lmss_plusp</p>
        </div>
    </div>
</body>
</html>