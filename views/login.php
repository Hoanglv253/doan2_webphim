<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập - YanHH3D</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'views/header.php'; ?>

    <div class="login-wrapper">

        <div class="login-box">
            <div class="login-header">
                <i class="fas fa-user"></i>
                <h2>Đăng nhập</h2>
            </div>

            <form action="index.php?page=login" method="POST">

                <?php if (!empty($error)): ?>
                    <p class="error-msg"><?php echo $error; ?></p>
                <?php endif; ?>

                <div class="input-group">
                    <label>Tên đăng nhập</label> <input type="text" name="username" required placeholder="">
                </div>

                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" required placeholder="">
                </div>

                <div class="options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember"> Ghi nhớ
                    </label>
                </div>

                <div class="actions">
                    <a href="#" onclick="alert('Vui lòng liên hệ Admin qua Telegram: @ftmn2025 để được cấp lại mật khẩu!'); return false;" class="forgot-pass">Quên mật khẩu?</a> <button type="submit" class="btn-submit">ĐĂNG NHẬP</button>
                </div>
            </form>

            <div class="register-section">
                <span>Chưa có tài khoản? </span>

                <a href="index.php?page=register" class="btn-register-orange">ĐĂNG KÝ</a>

                <span> ngay</span>
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