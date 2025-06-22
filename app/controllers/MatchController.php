<?php

require_once('app/config/database.php');
require_once('app/models/MatchModel.php');

class MatchController
{
    private $matchModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->matchModel = new MatchModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin()
    {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách trận đấu
    public function index()
    {
        $matches = $this->matchModel->getAll();
        include 'app/views/matches/list.php';
    }

    public function list()
    {
        $matches = $this->matchModel->getAll();
        require_once 'app/views/matches/list.php';
    }
    public function bracket() {
        $matches = $this->matchModel->getPlayoffMatches();
        require_once 'app/views/matches/bracket.php';
    }
    // Xem chi tiết trận đấu
    public function show($id)
    {
        $match = $this->matchModel->getById($id);
        if ($match) {
            include 'app/views/matches/show.php';
        } else {
            echo "Không thấy trận đấu.";
        }
    }

    // Thêm trận đấu (chỉ Admin)
    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include_once 'app/views/matches/add.php';
    }

    // Lưu trận đấu mới (chỉ Admin)
    public function save()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $result = $this->matchModel->addMatch($data);
            if (is_array($result)) {
                $errors = $result;
                include 'app/views/matches/add.php';
            } else {
                header('Location: /project-esports/Match');
            }
        }
    }

    // Sửa trận đấu (chỉ Admin)
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $match = $this->matchModel->getById($id);
        if ($match) {
            include 'app/views/matches/edit.php';
        } else {
            echo "Không thấy trận đấu.";
        }
    }

    // Cập nhật trận đấu (chỉ Admin)
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = $_POST;
            $edit = $this->matchModel->updateMatch($id, $data);
            if ($edit) {
                header('Location: /project-esports/Match');
            } else {
                echo "Đã xảy ra lỗi khi lưu trận đấu.";
            }
        }
    }

    // Xóa trận đấu (chỉ Admin)
    public function delete($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->matchModel->deleteMatch($id)) {
            header('Location: /project-esports/Match');
        } else {
            echo "Đã xảy ra lỗi khi xóa trận đấu.";
        }
    }
}
?>