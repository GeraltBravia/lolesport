<?php

require_once 'app/config/database.php';
require_once 'app/models/TournamentModel.php';

class TournamentController {
    private $tournamentModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->tournamentModel = new TournamentModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin() {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách giải đấu
    public function index() {
        $tournaments = $this->tournamentModel->getAll();
        include 'app/views/tournaments/list.php';
    }

    public function list() {
        $tournaments = $this->tournamentModel->getAll();
        require_once 'app/views/tournaments/list.php';
    }

    // Xem chi tiết giải đấu
    public function show($id) {
        $tournament = $this->tournamentModel->getById($id);
        if ($tournament) {
            include 'app/views/tournaments/show.php';
        } else {
            echo "Không thấy giải đấu.";
        }
    }

    // Thêm giải đấu (chỉ Admin)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include_once 'app/views/tournaments/add.php';
    }

    // Lưu giải đấu mới (chỉ Admin)
    public function save() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $startDate = $_POST['startDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';
            $region = $_POST['region'] ?? '';
            $status = $_POST['status'] ?? '';
            $result = $this->tournamentModel->addTournament($name, $startDate, $endDate, $region, $status);
            if ($result) {
                header('Location: /project-esports/Tournament');
            } else {
                $errors = ['Lỗi khi thêm giải đấu'];
                include 'app/views/tournaments/add.php';
            }
        }
    }

    // Sửa giải đấu (chỉ Admin)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $tournament = $this->tournamentModel->getById($id);
        if ($tournament) {
            include 'app/views/tournaments/edit.php';
        } else {
            echo "Không thấy giải đấu.";
        }
    }

    // Cập nhật giải đấu (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $region = $_POST['region'];
            $status = $_POST['status'];
            $edit = $this->tournamentModel->updateTournament($id, $name, $startDate, $endDate, $region, $status);
            if ($edit) {
                header('Location: /project-esports/Tournament');
            } else {
                echo "Đã xảy ra lỗi khi lưu giải đấu.";
            }
        }
    }

    // Xóa giải đấu (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->tournamentModel->deleteTournament($id)) {
            header('Location: /project-esports/Tournament');
        } else {
            echo "Đã xảy ra lỗi khi xóa giải đấu.";
        }
    }
}
?>