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
        $result = $this->matchModel->addMatch($data);
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
        $result = $this->matchModel->updateMatch($id, $data);
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