<?php
require_once 'app/config/database.php';
require_once 'app/models/VideoModel.php';

class VideoApiController {
    private $videoModel;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->videoModel = new VideoModel($db);
    }

    // Lấy danh sách video
    public function index() {
        header('Content-Type: application/json');
        $videos = $this->videoModel->getAll();
        echo json_encode($videos);
    }

    // Lấy video theo ID
    public function show($id) {
        header('Content-Type: application/json');
        $video = $this->videoModel->getById($id);
        if ($video) {
            echo json_encode($video);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Video not found']);
        }
    }

    // Thêm video mới
    public function video() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->videoModel->addVideo(
            $data['title'] ?? '',
            $data['url'] ?? '',
            $data['matchId'] ?? null
        );
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'Video created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Video creation failed']);
        }
    }

    // Cập nhật video
    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->videoModel->updateVideo(
            $id,
            $data['title'] ?? '',
            $data['url'] ?? '',
            $data['matchId'] ?? null
        );
        if ($result) {
            echo json_encode(['message' => 'Video updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Video update failed']);
        }
    }

    // Xóa video
    public function destroy($id) {
        header('Content-Type: application/json');
        $result = $this->videoModel->deleteVideo($id);
        if ($result) {
            echo json_encode(['message' => 'Video deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Video deletion failed']);
        }
    }
}
?>