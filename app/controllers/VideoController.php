<?php

require_once 'app/config/database.php';
require_once 'app/models/VideoModel.php';

class VideoController {
    private $videoModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->videoModel = new VideoModel($this->db);
    }

    private function isAdmin() {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách video
    public function index() {
        $videos = $this->videoModel->getAll();
        include 'app/views/videos/list.php';
    }

    public function list() {
        $videos = $this->videoModel->getAll();
        require_once 'app/views/videos/list.php';
    }
    
    // Xem chi tiết video
    public function show($id) {
        $video = $this->videoModel->getById($id);
        if ($video) {
            include 'app/views/videos/show.php';
        } else {
            echo "Không thấy video.";
        }
    }

    // Thêm video (chỉ Admin)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include_once 'app/views/videos/add.php';
    }

    // Lưu video mới (chỉ Admin)
    public function save() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $url = $_POST['url'] ?? '';
            $publishDate = $_POST['publishDate'] ?? date('Y-m-d');
            $result = $this->videoModel->addVideo($title, $url, $publishDate);
            if ($result) {
                header('Location: /project-esports/Video');
            } else {
                $errors = ['Lỗi khi thêm video'];
                include 'app/views/videos/add.php';
            }
        }
    }

    // Sửa video (chỉ Admin)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $video = $this->videoModel->getById($id);
        if ($video) {
            include 'app/views/videos/edit.php';
        } else {
            echo "Không thấy video.";
        }
    }

    // Cập nhật video (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $url = $_POST['url'];
            $publishDate = $_POST['publishDate'];
            $edit = $this->videoModel->updateVideo($id, $title, $url, $publishDate);
            if ($edit) {
                header('Location: /project-esports/Video');
            } else {
                echo "Đã xảy ra lỗi khi lưu video.";
            }
        }
    }

    // Xóa video (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->videoModel->deleteVideo($id)) {
            header('Location: /project-esports/Video');
        } else {
            echo "Đã xảy ra lỗi khi xóa video.";
        }
    }
}
?>