<?php

require_once 'app/config/database.php';
require_once 'app/models/NewsModel.php';

class NewsController {
    private $newsModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->newsModel = new NewsModel($this->db);
    }

    private function isAdmin() {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách tin tức
    public function index() {
        $news = $this->newsModel->getAll();
        include 'app/views/news/list.php';
    }

    public function list() {
        $news = $this->newsModel->getAll();
        require_once 'app/views/news/list.php';
    }

    // Xem chi tiết tin tức
    public function show($id) {
        $news = $this->newsModel->getById($id);
        if ($news) {
            include 'app/views/news/show.php';
        } else {
            echo "Không thấy tin tức.";
        }
    }

    // Thêm tin tức (chỉ Admin)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include_once 'app/views/news/add.php';
    }

    // Lưu tin tức mới (chỉ Admin)
    public function save() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $publishDate = $_POST['publishDate'] ?? date('Y-m-d');
            $result = $this->newsModel->addNews($title, $content, $publishDate);
            if ($result) {
                header('Location: /project-esports/News');
            } else {
                $errors = ['Lỗi khi thêm tin tức'];
                include 'app/views/news/add.php';
            }
        }
    }

    // Sửa tin tức (chỉ Admin)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $news = $this->newsModel->getById($id);
        if ($news) {
            include 'app/views/news/edit.php';
        } else {
            echo "Không thấy tin tức.";
        }
    }

    // Cập nhật tin tức (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $publishDate = $_POST['publishDate'];
            $edit = $this->newsModel->updateNews($id, $title, $content, $publishDate);
            if ($edit) {
                header('Location: /project-esports/News');
            } else {
                echo "Đã xảy ra lỗi khi lưu tin tức.";
            }
        }
    }

    // Xóa tin tức (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->newsModel->deleteNews($id)) {
            header('Location: /project-esports/News');
        } else {
            echo "Đã xảy ra lỗi khi xóa tin tức.";
        }
    }
}
?>