<header>
    <div class="header-left">
        <div class="menu-btn"><i class="fas fa-bars"></i></div>
        <a href="index.php" class="logo">
            LVHPHIM<span>.VIP</span>
        </a>
    </div>

    <form action="index.php" method="GET" class="search-box">
        <input type="hidden" name="page" value="search">

        <input type="text" name="keyword" placeholder="Tìm kiếm phim..." required>

        <button type="submit"><i class="fas fa-search"></i> Tìm </button>
    </form>

    <div class="header-right">
        <a href="#" class="icon-nav">
            <i class="fas fa-history"></i>
            <span>Lịch sử</span>
        </a>
        <a href="index.php?page=favorites" class="icon-nav"> <i class="fas fa-bookmark"></i> <span>Yêu thích</span>
        </a>

        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
            <div class="user-info" style="color: white; font-weight: bold;">
                Hello, <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                <a href="index.php?page=logout" class="btn-login" style="background: #444; margin-left: 10px;">Đăng xuất</a>
            </div>
        <?php else: ?>
            <a href="index.php?page=login" class="btn-login">Đăng Nhập</a>
        <?php endif; ?>
    </div>
</header>