<?php
require_once __DIR__ . '/../models/Movie.php';

class MovieController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function index()
    {
        $movieModel = new Movie($this->conn);

        // 1. Lấy danh sách PHIM HOT riêng
        $hotMovies = $movieModel->getHotMovies();

        // 2. Lấy danh sách phim thường (bên dưới)
        $movies = $movieModel->getAllMovies();

        $hotMovies = $movieModel->getHotMovies();
        $movies = $movieModel->getAllMovies();

        // --- XỬ LÝ PHÂN TRANG ---
        // 1. Lấy trang hiện tại từ URL (nếu không có thì mặc định là 1)
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($page < 1) $page = 1;

        // 2. Cấu hình số lượng phim mỗi trang
        $limit = 18;

        // 3. Tính vị trí bắt đầu lấy (Offset)
        $offset = ($page - 1) * $limit;

        // 4. Lấy tổng số phim để tính tổng số trang
        $totalMovies = $movieModel->countAllMovies();
        $totalPages = ceil($totalMovies / $limit); // Hàm ceil làm tròn lên (vd: 2.1 -> 3)

        // 5. Lấy danh sách phim theo trang
        $newMovies = $movieModel->getNewMovies($limit, $offset);

        //3.bxh
        $rankingMovies = $movieModel->getRankingMovies();

        // --- CODE XỬ LÝ LỊCH CHIẾU (MỚI) ---

        // 1. Xác định hôm nay là thứ mấy (Theo kiểu VN: 2,3,4...8)
        // date('N') trả về 1(Thứ 2) -> 7(CN). Ta cộng thêm 1 để thành 2 -> 8.
        $today = date('N') + 1;

        // 2. Lấy ngày người dùng chọn từ URL (nếu không chọn thì lấy hôm nay)
        $selectedDay = isset($_GET['day']) ? (int)$_GET['day'] : $today;

        // 3. Lấy phim theo ngày đó
        $scheduleMovies = $movieModel->getMoviesBySchedule($selectedDay);


        // 4. Load View (Truyền cả 2 biến $hotMovies và $movies sang home.php)
        include 'views/home.php';
    }

    public function search()
    {
        // Lấy từ khóa từ thanh địa chỉ URL
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        $movieModel = new Movie($this->conn);
        // Gọi hàm tìm kiếm bên Model
        $searchResults = $movieModel->searchMovies($keyword);

        // Load giao diện hiển thị kết quả (Tạo file này ở bước 5)
        include 'views/search.php';
    }


    // Thêm hàm này vào class MovieController
    public function listByGenre()
    {
        $genreId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $movieModel = new Movie($this->conn);

        // 1. Lấy danh sách phim thuộc thể loại này
        $searchResults = $movieModel->getMoviesByGenre($genreId);

        // 2. Lấy tên thể loại để hiển thị tiêu đề
        // (Code nhanh: ta hardcode mảng tên khớp với ID để đỡ query DB)
        $genreNames = [
            1 => 'Huyền Huyễn',
            2 => 'Xuyên Không',
            3 => 'Trùng Sinh',
            4 => 'Tiên Hiệp',
            5 => 'Cổ Trang',
            6 => 'Hài Hước',
            7 => 'Kiếm Hiệp',
            8 => 'Hiện Đại'
        ];
        $keyword = isset($genreNames[$genreId]) ? $genreNames[$genreId] : 'Thể loại khác';

        // 3. Tái sử dụng giao diện Search để hiển thị kết quả
        include 'views/search.php';
    }


    // 1. Hàm hiển thị trang danh sách yêu thích
    public function favorites()
    {
        // Kiểm tra đăng nhập chưa
        if (!isset($_SESSION['user_logged_in'])) {
            echo "<script>alert('Bạn cần đăng nhập để xem tủ phim!'); window.location.href='index.php?page=login';</script>";
            return;
        }

        $userId = $_SESSION['user_id']; // Cần đảm bảo lúc login bạn đã lưu user_id vào session

        // Nếu chưa lưu user_id lúc login thì vào UserController sửa hàm login thêm dòng: $_SESSION['user_id'] = $user['id'];
        // Tạm thời mình giả định bạn đã lưu hoặc mình dùng username để query lại id sau (nhưng tốt nhất là lưu ID lúc login)

        $movieModel = new Movie($this->conn);
        $favoriteMovies = $movieModel->getFavoritesByUser($userId);

        include 'views/favorites.php';
    }

    // 2. Hàm xử lý khi bấm nút "Yêu thích" ở trang chi tiết
    public function addToFavorite()
    {
        if (!isset($_SESSION['user_logged_in'])) {
            echo "<script>alert('Vui lòng đăng nhập để thêm yêu thích!'); window.location.href='index.php?page=login';</script>";
            return;
        }

        $userId = $_SESSION['user_id']; // Lấy ID người dùng đang đăng nhập
        $movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($movieId > 0) {
            $movieModel = new Movie($this->conn);
            $movieModel->addFavorite($userId, $movieId);

            echo "<script>alert('Đã thêm vào danh sách yêu thích!'); window.history.back();</script>";
        }
    }

    // [MỚI] Hàm xử lý trang chi tiết
    public function detail()
    {
        // 1. Lấy ID từ thanh địa chỉ
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $movieModel = new Movie($this->conn);
        $movie = $movieModel->getMovieById($id);
        // --- THÊM DÒNG NÀY: Lấy danh sách bình luận ---
        $listComments = $movieModel->getComments($id);

        // 2. Nếu không có phim thì báo lỗi
        if (!$movie) {
            echo "Phim không tồn tại!";
            exit();
        }

        // 3. Load giao diện
        include 'views/detail.php';
    }

    public function watch()
    {
        // 1. Lấy ID phim và ID tập (nếu có)
        $movieId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $epId = isset($_GET['ep']) ? (int)$_GET['ep'] : 0;

        $movieModel = new Movie($this->conn);

        // Lấy thông tin phim gốc
        $movie = $movieModel->getMovieById($movieId);

        // Lấy danh sách toàn bộ các tập
        $listEpisodes = $movieModel->getEpisodes($movieId);

        if (!$movie) {
            echo "Phim không tồn tại!";
            exit();
        }

        // --- XỬ LÝ LOGIC CHỌN TẬP ---
        $currentEpisode = null;

        if ($epId > 0) {
            // Trường hợp 1: Người dùng chọn tập cụ thể
            $currentEpisode = $movieModel->getEpisodeById($epId);
        } else {
            // Trường hợp 2: Mới vào từ trang Detail -> Mặc định lấy tập 1
            if (!empty($listEpisodes)) {
                $currentEpisode = $listEpisodes[0];
            }
        }

        // Load View xem phim
        include 'views/watch.php';
    }
    public function postComment()
    {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_logged_in'])) {
            echo "<script>alert('Bạn phải đăng nhập để bình luận!'); window.location.href='index.php?page=login';</script>";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movieId = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';
            $userId = $_SESSION['user_id']; // Lấy ID người đang đăng nhập

            if ($movieId > 0 && !empty($content)) {
                $movieModel = new Movie($this->conn);
                $movieModel->addComment($userId, $movieId, $content);
            }

            // Quay lại trang chi tiết phim
            header("Location: index.php?page=detail&id=" . $movieId);
            exit();
        }
    }

    // 1. Hiển thị danh sách phim trong Admin
    public function adminList()
    {
        // Tái sử dụng hàm lấy tất cả phim
        $movieModel = new Movie($this->conn);
        $movies = $movieModel->getAllMovies();
        include 'views/admin/movie_list.php'; // Chúng ta sẽ tạo file này sau
    }

    // 2. Xử lý xóa phim
    public function delete()
    {
        require_once 'config/auth.php';
        requireAdmin(); // Bắt buộc là admin

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $movieModel = new Movie($this->conn);
        $movieModel->deleteMovie($id);

        header("Location: index.php?page=admin_movies"); // Quay lại danh sách
    }



    // 1. Hiện form thêm tập
    public function addEpisode()
    {
        require_once 'config/auth.php';
        requireAdmin();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $movieModel = new Movie($this->conn);
        $movie = $movieModel->getMovieById($id); // Lấy tên phim để hiện lên cho dễ nhìn

        if (!$movie) {
            echo "Phim không tồn tại!";
            exit();
        }

        include 'views/admin/add_episode.php'; // Chúng ta sẽ tạo file này ở Bước 4
    }

    // 2. Lưu tập phim vào Database
    public function storeEpisode()
    {
        require_once 'config/auth.php';
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movieId = (int)$_POST['movie_id'];
            $name = $_POST['episode_name']; // VD: Tập 1
            $url = $_POST['content_url'];   // VD: Link iframe
            $badge = $_POST['episode_badge']; // VD: Cập nhật luôn nhãn "Tập 1" ở ngoài bìa

            $movieModel = new Movie($this->conn);

            // Lưu tập phim
            $movieModel->insertEpisode($movieId, $name, $url);

            // Nếu người dùng có nhập nhãn mới thì cập nhật luôn cho tiện
            if (!empty($badge)) {
                $movieModel->updateBadge($movieId, $badge);
            }

            echo "<script>alert('Thêm tập thành công!'); window.location.href='index.php?page=add_episode&id=$movieId';</script>";
            // Lưu ý: Redirect lại đúng trang thêm tập để nhập tiếp tập sau cho nhanh
        }
    }
    // File: controllers/MovieController.php

    public function store()
    {
        require_once 'config/auth.php';
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $episode_badge = $_POST['episode_badge'];
            $is_hot = isset($_POST['is_hot']) ? 1 : 0;
            $genres = isset($_POST['genres']) ? $_POST['genres'] : [];

            // --- QUAN TRỌNG: Lấy link phim ---
            $movie_link = isset($_POST['movie_link']) ? $_POST['movie_link'] : '';

            // --- MỚI: Lấy lịch chiếu ---
            $schedule_day = isset($_POST['schedule_day']) ? (int)$_POST['schedule_day'] : 0;

            // Xử lý ảnh (Code cũ giữ nguyên)
            $image_url = 'no-image.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/images/phim/";
                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image_url = $file_name;
            }

            $movieModel = new Movie($this->conn);

            // BƯỚC 1: Tạo phim (Chỉ truyền 5 tham số)
            // Truyền thêm $schedule_day vào hàm createMovie
            $newMovieId = $movieModel->createMovie($title, $description, $image_url, $episode_badge, $is_hot, $schedule_day);

            if ($newMovieId) {
                // BƯỚC 2: Lưu thể loại
                if (!empty($genres)) {
                    $movieModel->addMovieGenres($newMovieId, $genres);
                }

                // BƯỚC 3: Lưu Link phim vào bảng episodes
                // (Code này gọi hàm insertEpisode có sẵn trong Movie.php của bạn)
                if (!empty($movie_link)) {
                    $epName = !empty($episode_badge) ? $episode_badge : "Full HD";
                    $movieModel->insertEpisode($newMovieId, $epName, $movie_link);
                }

                echo "<script>alert('Thêm phim thành công!'); window.location.href='index.php?page=admin_movies';</script>";
            } else {
                echo "<script>alert('Lỗi tạo phim!');</script>";
            }
        }
    }

    // Thêm vào MovieController.php

    // 1. Hiển thị Form sửa
    public function edit()
    {
        require_once 'config/auth.php';
        requireAdmin();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $movieModel = new Movie($this->conn);
        $movie = $movieModel->getMovieById($id);

        if (!$movie) {
            echo "Phim không tồn tại!";
            return;
        }
        include 'views/admin/edit_movie.php'; // Tạo file này ở bước sau
    }

    // 2. Lưu dữ liệu sau khi sửa
    public function update()
    {
        require_once 'config/auth.php';
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $episode_badge = $_POST['episode_badge'];
            $is_hot = isset($_POST['is_hot']) ? 1 : 0;

            $schedule_day = isset($_POST['schedule_day']) ? (int)$_POST['schedule_day'] : 0;

            // Xử lý ảnh: Nếu có upload ảnh mới thì lấy, không thì để rỗng
            $image_url = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/images/phim/";
                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $file_name);
                $image_url = $file_name;
            }

            $movieModel = new Movie($this->conn);
            $movieModel->updateMovie($id, $title, $description, $image_url, $episode_badge, $is_hot, $schedule_day);

            echo "<script>alert('Cập nhật phim thành công!'); window.location.href='index.php?page=admin_movies';</script>";
        }
    }

    // --- THÊM VÀO controllers/MovieController.php ---

    public function adminCommentList() {
        require_once 'config/auth.php';
        requireAdmin();
        
        $movieModel = new Movie($this->conn);
        $comments = $movieModel->getAllCommentsAdmin();
        include 'views/admin/comment_list.php'; // Sẽ tạo file này sau
    }

    public function deleteComment() {
        require_once 'config/auth.php';
        requireAdmin();
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $movieModel = new Movie($this->conn);
        $movieModel->deleteComment($id);
        
        header("Location: index.php?page=admin_comments");
    }
}
