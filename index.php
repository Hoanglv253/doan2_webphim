<?php
session_start();
// --- BỔ SUNG 2 DÒNG NÀY LÊN ĐẦU ĐỂ TRÁNH LỖI Ở DASHBOARD ---
require_once 'models/User.php';
require_once 'models/Movie.php'; 
// -----------------------------------------------------------
require_once 'config/database.php';
require_once 'config/auth.php';
require_once 'controllers/UserController.php';
require_once 'controllers/MovieController.php';

// -----------------------------------------

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
// ... code phía dưới giữ nguyên

switch ($page) {
    // --- TRANG ĐĂNG NHẬP ---
    case 'login':
        $userController = new UserController($conn);
        $userController->login();
        break;
    // --- BỔ SUNG: TRANG ĐĂNG KÝ ---
    case 'register':
        $userController = new UserController($conn);
        $userController->register(); // Gọi hàm register trong Controller
        break;

    // --- CHỨC NĂNG ĐĂNG XUẤT ---
    case 'logout':
        $userController = new UserController($conn);
        $userController->logout();
        break;


    // --- THÊM CASE TÌM KIẾM VÀO ĐÂY ---
    case 'search':
        $movieController = new MovieController($conn);
        $movieController->search(); // Gọi hàm tìm kiếm
        break;

    // ... case logout, home ...

    case 'genre':
        $movieController = new MovieController($conn);
        $movieController->listByGenre();
        break;

    // ... các case khác

    case 'favorites':
        $movieController = new MovieController($conn);
        $movieController->favorites();
        break;

    case 'add_favorite':
        $movieController = new MovieController($conn);
        $movieController->addToFavorite();
        break;

    // ...

    case 'detail':
        require_once 'controllers/MovieController.php';
        $movieController = new MovieController($conn);
        $movieController->detail(); // Gọi hàm detail trong Controller
        break;

    // --- THÊM ĐOẠN NÀY VÀO index.php ---
    case 'watch':
        $movieController = new MovieController($conn);
        $movieController->watch(); // Gọi hàm watch() để xử lý xem phim
        break;
    // ------------------------------------

    // --- TRANG QUẢN TRỊ ADMIN (MỚI) ---
    case 'admin_dashboard':
        require_once 'config/auth.php';
        requireAdmin();

        $movieModel = new Movie($conn);
        $userModel = new User($conn); // Khởi tạo User Model

        // Lấy số liệu thống kê thực tế
        $totalMovies = $movieModel->countAllMovies();
        $totalComments = $movieModel->countAllComments();
        $totalUsers = $userModel->countAllUsers();

        include 'views/admin/dashboard.php';
        break;

    case 'post_comment':
        $movieController = new MovieController($conn);
        $movieController->postComment();
        break;

    // ...


    // --- TRANG CHỦ (MẶC ĐỊNH) ---
    case 'home':
    default:
        $movieController = new MovieController($conn);
        $movieController->index();
        break;

    // --- QUẢN LÝ PHIM (ADMIN) ---
    case 'admin_movies':
        requireAdmin(); 
        $movieController = new MovieController($conn);
        $movieController->adminList();
        break;

    case 'add_movie':
        requireAdmin();
        include 'views/admin/add_movie.php';
        break;

    case 'store_movie':
        requireAdmin();
        $movieController = new MovieController($conn);
        $movieController->store();
        break;

    case 'delete_movie':
        requireAdmin();
        $movieController = new MovieController($conn);
        $movieController->delete();
        break;
    
    // --- THÊM TẬP PHIM ---
    case 'add_episode':
        requireAdmin();
        $movieController = new MovieController($conn);
        $movieController->addEpisode();
        break;

    case 'store_episode':
        requireAdmin();
        $movieController = new MovieController($conn);
        $movieController->storeEpisode();
        break;

    case 'edit_movie':
        $movieController = new MovieController($conn);
        $movieController->edit();
        break;

    case 'update_movie':
        $movieController = new MovieController($conn);
        $movieController->update();
        break;

    // --- THÊM VÀO index.php (Khu vực Admin) ---

    // 1. Quản lý Thành viên
    case 'admin_users':
        $userController = new UserController($conn);
        $userController->adminList();
        break;
    
    case 'delete_user':
        $userController = new UserController($conn);
        $userController->delete();
        break;

    // 2. Quản lý Bình luận
    case 'admin_comments':
        $movieController = new MovieController($conn);
        $movieController->adminCommentList();
        break;

    case 'delete_comment':
        $movieController = new MovieController($conn);
        $movieController->deleteComment();
        break;
}
