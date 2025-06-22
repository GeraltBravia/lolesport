<?php
require_once('app/config/database.php');
require_once('app/models/MatchModel.php');

class MatchApiController
{
    private $matchModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->matchModel = new MatchModel($this->db);
    }

    // Lấy danh sách trận đấu
    public function index()
    {
        header('Content-Type: application/json');
        $matches = $this->matchModel->getAll();
        echo json_encode($matches);
    }

    // Lấy thông tin trận đấu theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $match = $this->matchModel->getById($id);
        if ($match) {
            echo json_encode($match);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Match not found']);
        }
    }

    // Thêm trận đấu mới
    public function match()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        // Lấy từng trường từ $data
        $tournamentId = $data['tournamentId'] ?? null;
        $team1Id = $data['team1Id'] ?? null;
        $team2Id = $data['team2Id'] ?? null;
        $matchDate = $data['matchDate'] ?? null;
        $status = $data['status'] ?? null;
        $winnerId = $data['winnerId'] ?? null;
        $score = $data['score'] ?? null;
        $bo = $_POST['BO'] ?? null;
        $stage = $_POST['Stage'] ?? null; 

       error_log("Debug: save() - TournamentID=$tournamentId, Team1ID=$team1Id, Team2ID=$team2Id, MatchDate=$matchDate, Status=$status, WinnerID=$winnerId, Score=$score, BO=$bo, Stage=$stage");

        $result = $this->matchModel->addMatch($tournamentId, $team1Id, $team2Id, $matchDate, $status, $winnerId, $score, $bo, $stage);

        if (is_array($result)) {
            http_response_code(400);
            echo json_encode(['errors' => $result]);
        } else {
            http_response_code(201);
            echo json_encode(['message' => 'Match created successfully']);
        }
    }

    // Cập nhật trận đấu theo ID
    public function update($id)
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        // Extract fields from $data
        $tournamentId = $data['tournamentId'] ?? null;
        $team1Id = $data['team1Id'] ?? null;
        $team2Id = $data['team2Id'] ?? null;
        $matchDate = $data['matchDate'] ?? null;
        $status = $data['status'] ?? null;
        $winnerId = $data['winnerId'] ?? null;
        $score = $data['score'] ?? null;

        $result = $this->matchModel->updateMatch($id, $tournamentId, $team1Id, $team2Id, $matchDate, $status, $winnerId, $score);
        if ($result) {
            echo json_encode(['message' => 'Match updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Match update failed']);
        }
    }

    // Xóa trận đấu theo ID
    public function destroy($id)
    {
        header('Content-Type: application/json');
        $result = $this->matchModel->deleteMatch($id);
        if ($result) {
            echo json_encode(['message' => 'Match deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Match deletion failed']);
        }
    }
}
?>