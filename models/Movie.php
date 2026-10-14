<?php
class Movie
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // [CŨ] Hàm lấy tất cả phim (Giữ nguyên)
    public function getAllMovies()
    {
        $sql = "SELECT * FROM movies";
        $result = $this->conn->query($sql);
        $movies = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
        }
        return $movies;
    }

    // [MỚI] Thêm hàm này để lấy PHIM HOT
    public function getHotMovies()
    {
        // Lấy phim có is_hot = 1, giới hạn 10 phim mới nhất
        $sql = "SELECT * FROM movies WHERE is_hot = 1 ORDER BY id DESC LIMIT 10";
        $result = $this->conn->query($sql);

        $hotMovies = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hotMovies[] = $row;
            }
        }
        return $hotMovies;
    }
    // Hàm tìm kiếm phim theo tên (tương đối)
    public function searchMovies($keyword)
    {
        // Dùng LIKE %...% để tìm gần đúng
        $keyword = $this->conn->real_escape_string($keyword); // Chống hack SQL Injection cơ bản
        $sql = "SELECT * FROM movies WHERE title LIKE '%$keyword%' ORDER BY id DESC";

        $result = $this->conn->query($sql);

        $movies = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
        }
        return $movies;
    }

    // 1. Hàm đếm tổng số phim (để biết cần chia bao nhiêu trang)
    public function countAllMovies()
    {
        $sql = "SELECT COUNT(*) as total FROM movies";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // 2. Hàm lấy phim có Phân trang (Limit và Offset)
    public function getNewMovies($limit, $offset)
    {
        $sql = "SELECT * FROM movies ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Hàm lấy Bảng Xếp Hạng (Tạm thời lấy theo ID, nếu có cột 'views' thì đổi thành ORDER BY views DESC)
    public function getRankingMovies()
    {
        $sql = "SELECT * FROM movies LIMIT 10"; // Lấy 5 phim demo
        $result = $this->conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) $data[] = $row;
        }
        return $data;
    }


    // [MỚI] Lấy danh sách phim theo ID thể loại (Hỗ trợ 1 phim nhiều thể loại)
    public function getMoviesByGenre($genreId)
    {
        // Join 3 bảng: movies, movie_genres, genres
        $sql = "SELECT m.* FROM movies m 
                JOIN movie_genres mg ON m.id = mg.movie_id 
                WHERE mg.genre_id = ? 
                ORDER BY m.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $genreId);
        $stmt->execute();

        $result = $stmt->get_result();
        $movies = [];
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        return $movies;
    }

    // [MỚI] Thêm phim vào danh sách yêu thích
    public function addFavorite($userId, $movieId)
    {
        // Dùng INSERT IGNORE để nếu có rồi thì bỏ qua, không báo lỗi
        $sql = "INSERT IGNORE INTO favorites (user_id, movie_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $movieId);
        return $stmt->execute();
    }

    // [MỚI] Lấy danh sách phim yêu thích của 1 user
    public function getFavoritesByUser($userId)
    {
        // Join bảng favorites với bảng movies để lấy thông tin phim
        $sql = "SELECT m.* FROM movies m 
                JOIN favorites f ON m.id = f.movie_id 
                WHERE f.user_id = ? 
                ORDER BY f.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $movies = [];
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        return $movies;
    }


    // [MỚI] Lấy danh sách tất cả các tập của 1 bộ phim
    public function getEpisodes($movieId)
    {
        $sql = "SELECT * FROM episodes WHERE movie_id = ? ORDER BY id ASC"; // Sắp xếp tập 1 -> tập cuối
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $movieId);
        $stmt->execute();

        $result = $stmt->get_result();
        $episodes = [];
        while ($row = $result->fetch_assoc()) {
            $episodes[] = $row;
        }
        return $episodes;
    }

    // [MỚI] Lấy thông tin 1 tập cụ thể (khi người dùng bấm chọn tập)
    public function getEpisodeById($epId)
    {
        $sql = "SELECT * FROM episodes WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $epId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
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

    // Thêm vào class Movie
    public function countAllComments()
    {
        $sql = "SELECT COUNT(*) as total FROM comments";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }




    // 2. Thêm hàm mới: Lưu nhiều thể loại cho 1 phim
    public function addMovieGenres($movieId, $genreIds)
    {
        // $genreIds là một mảng (Ví dụ: [1, 4, 7])
        $sql = "INSERT INTO movie_genres (movie_id, genre_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        foreach ($genreIds as $gId) {
            $gId = (int)$gId;
            $stmt->bind_param("ii", $movieId, $gId);
            $stmt->execute();
        }
    }

    // 3. Cập nhật hàm getMovieById để lấy tên TẤT CẢ thể loại (Hiển thị ra trang chi tiết)
    public function getMovieById($id)
    {
        // Dùng GROUP_CONCAT để nối tên các thể loại lại thành 1 chuỗi (VD: "Tiên Hiệp, Cổ Trang")
        $sql = "SELECT m.*, GROUP_CONCAT(g.name SEPARATOR ', ') as genre_name 
                FROM movies m 
                LEFT JOIN movie_genres mg ON m.id = mg.movie_id 
                LEFT JOIN genres g ON mg.genre_id = g.id 
                WHERE m.id = ?
                GROUP BY m.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Xóa phim
    public function deleteMovie($id)
    {
        $sql = "DELETE FROM movies WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // 1. Hàm thêm tập phim mới vào Database
    public function insertEpisode($movieId, $name, $url)
    {
        $sql = "INSERT INTO episodes (movie_id, episode_name, content_url) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $movieId, $name, $url);
        return $stmt->execute();
    }

    // 2. Hàm cập nhật trạng thái phim (Ví dụ: Từ "Tập 1" -> "Tập 2")
    public function updateBadge($movieId, $newBadge)
    {
        $sql = "UPDATE movies SET episode_badge = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newBadge, $movieId);
        return $stmt->execute();
    }


    // --- THÊM VÀO models/Movie.php ---

    // Lấy danh sách phim theo lịch chiếu (Thứ 2 -> CN)
    public function getMoviesBySchedule($day)
    {
        // Kiểm tra xem biến $day có hợp lệ không (2-8)
        $day = (int)$day; 
        
        $sql = "SELECT * FROM movies WHERE schedule_day = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $day);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $movies = [];
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        return $movies;
    }
    // Trong models/Movie.php

    // 1. Sửa hàm createMovie (Thêm tham số $schedule_day)
    public function createMovie($title, $description, $image_url, $episode_badge, $is_hot, $schedule_day)
    {
        // Thêm schedule_day vào câu lệnh SQL
        $sql = "INSERT INTO movies (title, description, image_url, episode_badge, is_hot, schedule_day) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        // "ssssii" -> i cuối cùng là integer (số nguyên) cho schedule_day
        $stmt->bind_param("ssssii", $title, $description, $image_url, $episode_badge, $is_hot, $schedule_day);

        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    // 2. Sửa hàm updateMovie (Thêm tham số $schedule_day)
    public function updateMovie($id, $title, $description, $image_url, $episode_badge, $is_hot, $schedule_day)
    {
        if (!empty($image_url)) {
            // Có update ảnh
            $sql = "UPDATE movies SET title=?, description=?, image_url=?, episode_badge=?, is_hot=?, schedule_day=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssiii", $title, $description, $image_url, $episode_badge, $is_hot, $schedule_day, $id);
        } else {
            // Không update ảnh
            $sql = "UPDATE movies SET title=?, description=?, episode_badge=?, is_hot=?, schedule_day=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssiii", $title, $description, $episode_badge, $is_hot, $schedule_day, $id);
        }
        return $stmt->execute();
    }

    // --- THÊM VÀO models/Movie.php ---

    // 1. Lấy tất cả bình luận (Kèm tên user và tên phim)
    public function getAllCommentsAdmin() {
        $sql = "SELECT c.*, u.username, m.title as movie_title 
                FROM comments c
                JOIN users u ON c.user_id = u.id
                JOIN movies m ON c.movie_id = m.id
                ORDER BY c.created_at DESC";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        return $data;
    }

    // 2. Xóa bình luận
    public function deleteComment($id) {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
