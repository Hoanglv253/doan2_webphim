<?php
class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    // Thêm vào bên trong class UserController


    // --- KHU VỰC BÌNH LUẬN (COMMENTS) ---

    // 1. Lấy danh sách bình luận của 1 phim (Kèm theo tên người dùng)
    public function getComments($movieId)
    {
        // JOIN bảng comments với users để lấy fullname
        $sql = "SELECT c.*, u.fullname, u.username 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.movie_id = ? 
                ORDER BY c.id DESC"; // Mới nhất lên đầu

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $movieId);
        $stmt->execute();

        $result = $stmt->get_result();
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }

    // 2. Thêm bình luận mới
    public function addComment($userId, $movieId, $content)
    {
        $sql = "INSERT INTO comments (user_id, movie_id, content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $userId, $movieId, $content);
        return $stmt->execute();
    }

    // Thêm vào class User
    public function countAllUsers()
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role != 'admin'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Trong models/User.php

    public function register($fullname, $username, $email, $password)
    {
        // 1. Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        // Lưu mật khẩu đã mã hóa vào DB
        $stmt->bind_param("ssss", $fullname, $username, $email, $hashed_password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // 2. Dùng password_verify để kiểm tra khớp mật khẩu
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // --- THÊM VÀO models/User.php ---

    // 1. Lấy danh sách tất cả thành viên
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $result = $this->conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) $users[] = $row;
        }
        return $users;
    }

    // 2. Xóa thành viên (Chặn xóa Admin)
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ? AND role != 'admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
