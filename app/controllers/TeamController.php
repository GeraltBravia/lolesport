<?php
require_once('app/config/database.php');
require_once('app/models/TeamModel.php');
require_once('app/models/FavoriteModel.php');

class TeamController {
    private $teamModel;
    private $favoriteModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->teamModel = new TeamModel($this->db);
        $this->favoriteModel = new FavoriteModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin() {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách đội
    public function index() {
        $teams = $this->teamModel->getAll();
        include 'app/views/teams/list.php';
    }

    public function list() {
        $teams = $this->teamModel->getAll();
        require_once 'app/views/teams/list.php';
    }

    // Xem chi tiết đội
    public function show($id) {
        $team = $this->teamModel->getById($id);
        if ($team) {
            include 'app/views/teams/show.php';
        } else {
            echo "Không thấy đội.";
        }
    }

    // Thêm đội (chỉ Admin)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include_once 'app/views/teams/add.php';
    }

    // Lưu đội mới (chỉ Admin)
    public function save() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $region = $_POST['region'] ?? '';
            $result = $this->teamModel->addTeam($name, $region);
            if ($result) {
                header('Location: /project-esports/Team');
            } else {
                $errors = ['Lỗi khi thêm đội'];
                include 'app/views/teams/add.php';
            }
        }
    }

    // Sửa đội (chỉ Admin)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $team = $this->teamModel->getById($id);
        if ($team) {
            include 'app/views/teams/edit.php';
        } else {
            echo "Không thấy đội.";
        }
    }

    // Cập nhật đội (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $region = $_POST['region'];
            $edit = $this->teamModel->updateTeam($id, $name, $region);
            if ($edit) {
                header('Location: /project-esports/Team');
            } else {
                echo "Đã xảy ra lỗi khi lưu đội.";
            }
        }
    }

    // Xóa đội (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->teamModel->deleteTeam($id)) {
            header('Location: /project-esports/Team');
        } else {
            echo "Đã xảy ra lỗi khi xóa đội.";
        }
    }

    // Thêm đội vào yêu thích
    public function addFavorite($teamId) {
        if (SessionHelper::get('user_id')) {
            $this->favoriteModel->addFavorite(SessionHelper::get('user_id'), $teamId, null);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Please log in']);
        }
        exit;
    }

    // Xóa đội khỏi yêu thích (cần bổ sung logic xóa trong FavoriteModel)
    public function removeFavorite($favoriteId) {
        if (SessionHelper::get('user_id')) {
            $this->favoriteModel->deleteFavorite($favoriteId);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Please log in']);
        }
        exit;
    }
}
?>