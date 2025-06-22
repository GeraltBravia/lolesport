<?php
require_once('app/config/database.php');
require_once('app/models/MatchModel.php');
require_once('app/models/TournamentModel.php');
require_once('app/models/TeamModel.php');
require_once('app/helpers/AuthHelper.php');

class MatchController {
    private $matchModel;
    private $tournamentModel;
    private $teamModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->matchModel = new MatchModel($this->db);
        $this->tournamentModel = new TournamentModel($this->db);
        $this->teamModel = new TeamModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin() {
        return AuthHelper::isAdmin();
    }

    // Hiển thị danh sách trận đấu
    public function index() {
        $matches = $this->matchModel->getAll();
        include 'app/views/matches/list.php';
    }

    public function list() {
        $matches = $this->matchModel->getAll();
        require_once 'app/views/matches/list.php';
    }

    public function bracket() {
        $matches = $this->matchModel->getPlayoffMatches();
        require_once 'app/views/matches/bracket.php';
    }

    // Xem chi tiết trận đấu
    public function show($id) {
        $match = $this->matchModel->getById($id);
        if ($match) {
            include 'app/views/matches/show.php';
        } else {
            echo "Không thấy trận đấu.";
        }
    }

    // Thêm trận đấu (chỉ Admin)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $tournaments = $this->tournamentModel->getAll();
        $teams = $this->teamModel->getAll();
        include 'app/views/matches/add.php';
    }

    // Lưu trận đấu mới (chỉ Admin)
    public function save() {
    if (!$this->isAdmin()) {
        echo "Bạn không có quyền truy cập chức năng này!";
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tournamentId = $_POST['TournamentID'] ?? null;
        $team1Id = $_POST['Team1ID'] ?? null;
        $team2Id = $_POST['Team2ID'] ?? null;
        $matchDate = $_POST['MatchDate'] ?? null;
        $status = $_POST['Status'] ?? null;
        $winnerId = empty($_POST['WinnerID']) ? null : $_POST['WinnerID'];
        $score = $_POST['Score'] ?? null;
        $bo = $_POST['BO'] ?? null; 
        $stage = $_POST['Stage'] ?? null; 

        // Debug: Log the data being sent
        error_log("Debug: save() - TournamentID=$tournamentId, Team1ID=$team1Id, Team2ID=$team2Id, MatchDate=$matchDate, Status=$status, WinnerID=$winnerId, Score=$score, BO=$bo, Stage=$stage");

        $result = $this->matchModel->addMatch(
            $tournamentId,
            $team1Id,
            $team2Id,
            $matchDate,
            $status,
            $winnerId,
            $score,
            $bo,
            $stage
        );

        if (is_array($result)) {
            $errors = $result;
            $tournaments = $this->tournamentModel->getAll();
            $teams = $this->teamModel->getAll();
            include 'app/views/matches/add.php';
        } else {
            header('Location: /project-esports/Match');
            exit;
        }
    }
}

    // Sửa trận đấu (chỉ Admin)
    public function edit($id = null) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($id === null) {
            echo "MatchID không được cung cấp.";
            exit;
        }
        $match = $this->matchModel->getById($id);
        if ($match) {
            $tournaments = $this->tournamentModel->getAll();
            $teams = $this->teamModel->getAll();
            include 'app/views/matches/edit.php';
        } else {
            echo "Không thấy trận đấu.";
        }
    }

    // Cập nhật trận đấu (chỉ Admin)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matchId =empty($_POST['MatchID'] ?? null); // Sửa thành MatchID để khớp với edit.php
            if ($matchId === null) {
                echo "MatchID không hợp lệ.";
                exit;
            }
            $tournamentId = $_POST['TournamentID'] ?? null;
            $team1Id = $_POST['Team1ID'] ?? null;
            $team2Id = $_POST['Team2ID'] ?? null;
            $matchDate = $_POST['MatchDate'] ?? null;
            $status = $_POST['Status'] ?? null;
            $winnerId = $_POST['WinnerID'] ?? null;
            $score = $_POST['Score'] ?? null;

            $edit = $this->matchModel->updateMatch($matchId, $tournamentId, $team1Id, $team2Id, $matchDate, $status, $winnerId, $score);

            if ($edit) {
                header('Location: /project-esports/Match');
                exit;
            } else {
                echo "Đã xảy ra lỗi khi lưu trận đấu.";
            }
        }
    }

    // Xóa trận đấu (chỉ Admin)
    public function delete($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->matchModel->deleteMatch($id)) {
            header('Location: /project-esports/Match');
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa trận đấu.";
        }
    }
}
?>