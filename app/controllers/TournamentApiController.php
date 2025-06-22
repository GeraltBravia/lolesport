<?php

require_once 'app/config/database.php';
require_once 'app/models/TournamentModel.php';

class TournamentApiController {
    private $tournamentModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->tournamentModel = new TournamentModel($this->db);
    }

    // Lấy danh sách giải đấu
    public function index() {
        header('Content-Type: application/json');
        $tournaments = $this->tournamentModel->getAll();
        echo json_encode($tournaments);
    }

    // Lấy thông tin giải đấu theo ID
    public function show($id) {
        header('Content-Type: application/json');
        $tournament = $this->tournamentModel->getById($id);
        if ($tournament) {
            echo json_encode($tournament);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Tournament not found']);
        }
    }

    // Thêm giải đấu mới
    public function tournament() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $startDate = $data['startDate'] ?? '';
        $endDate = $data['endDate'] ?? '';
        $region = $data['region'] ?? '';
        $status = $data['status'] ?? '';
        $result = $this->tournamentModel->addTournament($name, $startDate, $endDate, $region, $status);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Tournament created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Tournament creation failed']);
        }
    }

    // Cập nhật giải đấu theo ID
    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $startDate = $data['startDate'] ?? '';
        $endDate = $data['endDate'] ?? '';
        $region = $data['region'] ?? '';
        $status = $data['status'] ?? '';
        $result = $this->tournamentModel->updateTournament($id, $name, $startDate, $endDate, $region, $status);
        if ($result) {
            echo json_encode(['message' => 'Tournament updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Tournament update failed']);
        }
    }

    // Xóa giải đấu theo ID
    public function destroy($id) {
        header('Content-Type: application/json');
        $result = $this->tournamentModel->deleteTournament($id);
        if ($result) {
            echo json_encode(['message' => 'Tournament deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Tournament deletion failed']);
        }
    }
}
?>