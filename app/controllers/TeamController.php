<?php
require_once('app/config/database.php');
require_once('app/models/TeamModel.php');
require_once('app/models/FavoriteModel.php');

class TeamController {
    private $teamModel;
    private $favoriteModel;
    private $TournamentModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->teamModel = new TeamModel($this->db);
        $this->favoriteModel = new FavoriteModel($this->db);
        $this->TournamentModel = new TournamentModel($this->db);
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
        $tournaments = $this->TournamentModel->getAll(); // Lấy danh sách giải đấu
        include_once 'app/views/teams/add.php';
    }

    // Lưu đội mới (chỉ Admin)
    public function save() {
        $name = $_POST['name'];
        $region = $_POST['region'];
        $tournamentId = $_POST['tournamentId'];

        // Xử lý upload logo
        $logoURL = '';
        if (isset($_FILES['logoURL']) && $_FILES['logoURL']['error'] == 0) {
            $targetDir = "uploads/logos/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $fileName = uniqid() . '_' . basename($_FILES['logoURL']['name']);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES['logoURL']['tmp_name'], $targetFile)) {
                $logoURL = $targetFile;
            }
        }

        $this->teamModel->addTeam($name, $region, $logoURL, $tournamentId);
        header('Location: /project-esports/Team/list');
        exit;
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
            $logoURL = $_POST['logoURL'] ?? '';
            $tournamentId = $_POST['tournamentId'] ?? '';
            $edit = $this->teamModel->updateTeam($id, $name, $region, $logoURL, $tournamentId);
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