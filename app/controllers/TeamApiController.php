<?php

require_once('app/config/database.php');
require_once('app/models/TeamModel.php');

class TeamApiController {
    private $teamModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->teamModel = new TeamModel($this->db);
    }

    // Lấy danh sách đội
    public function index() {
        header('Content-Type: application/json');
        $teams = $this->teamModel->getAll();
        echo json_encode($teams);
    }

    // Lấy thông tin đội theo ID
    public function show($id) {
        header('Content-Type: application/json');
        $team = $this->teamModel->getById($id);
        if ($team) {
            echo json_encode($team);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Team not found']);
        }
    }

    // Thêm đội mới
    public function team() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $region = $data['region'] ?? '';
        $result = $this->teamModel->addTeam($name, $region);
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Team created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Team creation failed']);
        }
    }

    // Cập nhật đội theo ID
    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'] ?? '';
        $region = $data['region'] ?? '';
        $result = $this->teamModel->updateTeam($id, $name, $region);
        if ($result) {
            echo json_encode(['message' => 'Team updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Team update failed']);
        }
    }

    // Xóa đội theo ID
    public function destroy($id) {
        header('Content-Type: application/json');
        $result = $this->teamModel->deleteTeam($id);
        if ($result) {
            echo json_encode(['message' => 'Team deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Team deletion failed']);
        }
    }
}
?>