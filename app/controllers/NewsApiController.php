<?php


require_once 'app/config/database.php';
require_once 'app/models/NewsModel.php';

class NewsApiController {
    private $newsModel;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->newsModel = new NewsModel($db);
    }

    // Lấy danh sách tin tức
    public function index() {
        header('Content-Type: application/json');
        $news = $this->newsModel->getAll();
        echo json_encode($news);
    }

    // Lấy tin tức theo ID
    public function show($id) {
        header('Content-Type: application/json');
        $news = $this->newsModel->getById($id);
        if ($news) {
            echo json_encode($news);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'News not found']);
        }
    }

    // Thêm tin tức mới
    public function news() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->newsModel->addNews(
            $data['title'] ?? '',
            $data['content'] ?? '',
            $data['author'] ?? '',
            $data['tournamentId'] ?? null
        );
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => 'News created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'News creation failed']);
        }
    }

    // Cập nhật tin tức
    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->newsModel->updateNews(
            $id,
            $data['title'] ?? '',
            $data['content'] ?? '',
            $data['author'] ?? '',
            $data['tournamentId'] ?? null
        );
        if ($result) {
            echo json_encode(['message' => 'News updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'News update failed']);
        }
    }

    // Xóa tin tức
    public function destroy($id) {
        header('Content-Type: application/json');
        $result = $this->newsModel->deleteNews($id);
        if ($result) {
            echo json_encode(['message' => 'News deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'News deletion failed']);
        }
    }
}
?>