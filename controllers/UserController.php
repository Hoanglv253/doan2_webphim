<?php
// Gọi file Model
require_once __DIR__ . '/../models/User.php';

// QUAN TRỌNG: Tên class phải Y HỆT tên file
class UserController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login()
    {
        // Code xử lý đăng nhập
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User($this->conn);
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user['id']; // Thêm dòng này vào UserController.php
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];

                $_SESSION['role'] = $user['role']; // <--- QUAN TRỌNG: Lưu role vào session

                // --- ĐOẠN CODE ĐIỀU HƯỚNG MỚI ---
                if ($user['role'] === 'admin') {
                    // Nếu là admin -> Chuyển sang trang Dashboard riêng
                    header("Location: index.php?page=admin_dashboard");
                } else {
                    // Nếu là khách -> Về trang chủ xem phim
                    header("Location: index.php");
                }
                exit();
            } else {
                echo "<script>alert('Sai tài khoản hoặc mật khẩu!');</script>";
            }
        }

        // Gọi View
        if (file_exists(__DIR__ . '/../views/login.php')) {
            include __DIR__ . '/../views/login.php';
        }
    }

    // Thêm vào bên trong class UserController

    public function register()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];

            // Validate cơ bản
            if ($password !== $confirm_password) {
                $error = "Mật khẩu nhập lại không khớp!";
            } else {
                $userModel = new User($this->conn);
                $result = $userModel->register($fullname, $username, $email, $password);

                if ($result === true) {
                    // Đăng ký thành công -> Chuyển hướng về trang đăng nhập
                    echo "<script>
                    alert('Đăng ký thành công! Vui lòng đăng nhập.');
                    window.location.href = 'index.php?page=login';
                </script>";
                    exit();
                } else {
                    $error = "Đăng ký thất bại! Có thể Username hoặc Email đã tồn tại.";
                }
            }
        }

        // Gọi View đăng ký
        if (file_exists(__DIR__ . '/../views/register.php')) {
            include __DIR__ . '/../views/register.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // --- THÊM VÀO controllers/UserController.php ---

    public function adminList() {
        require_once 'config/auth.php';
        requireAdmin();
        
        $userModel = new User($this->conn);
        $users = $userModel->getAllUsers();
        include 'views/admin/user_list.php'; // Sẽ tạo file này sau
    }

    public function delete() {
        require_once 'config/auth.php';
        requireAdmin();
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $userModel = new User($this->conn);
        $userModel->deleteUser($id);
        
        header("Location: index.php?page=admin_users");
    }
}
