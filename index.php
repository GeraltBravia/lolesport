<?php
session_start();

// Require các file cần thiết
require_once './app/config/database.php';
require_once './app/helpers/SessionHelper.php';
require_once './app/models/TeamModel.php';
require_once './app/controllers/DefaultController.php';
require_once './app/controllers/TeamController.php';
require_once './app/controllers/TournamentController.php';
require_once './app/controllers/MatchController.php';
require_once './app/controllers/NewsController.php';
require_once './app/controllers/VideoController.php';
require_once './app/controllers/AuthController.php';
require_once './app/controllers/TeamApiController.php';
require_once './app/controllers/TournamentApiController.php';
require_once './app/controllers/MatchApiController.php';
require_once './app/controllers/NewsApiController.php';
require_once './app/controllers/VideoApiController.php';


// Lấy và chuẩn hóa URL
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller và action
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// Xử lý các yêu cầu đặc biệt cho TeamController (ví dụ: thêm/xóa yêu thích đội)
if (isset($url[0]) && $url[0] == 'team') {
    $controllerName = 'TeamController';
    $controller = new TeamController();

    if (isset($url[1]) && $url[1] == 'addFavorite' && isset($url[2])) {
        $controller->addFavorite($url[2]);
        exit;
    } elseif (isset($url[1]) && $url[1] == 'removeFavorite' && isset($url[2])) {
        $controller->removeFavorite($url[2]);
        exit;
    }
}

// Xử lý các yêu cầu API
if (isset($url[0]) && $url[0] === 'api' && isset($url[1])) {
    $apiControllerName = ucfirst($url[1]) . 'ApiController';
    $apiControllerFile = './app/controllers/' . $apiControllerName . '.php';

    if (file_exists($apiControllerFile)) {
        require_once $apiControllerFile;
        $controller = new $apiControllerName();

        $method = $_SERVER['REQUEST_METHOD'];
        $id = $url[2] ?? null;

        switch ($method) {
            case 'GET':
                $action = $id ? 'show' : 'index'; // khớp tên method thật
                break;
            case 'POST':
                $action = $url[1]; // Gọi method đúng tên theo controller: team(), match(), tournament()...
                break;
            case 'PUT':
                $action = $id ? 'update' : null;
                break;
            case 'DELETE':
                $action = $id ? 'destroy' : null;
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }

        if ($action && method_exists($controller, $action)) {
            if ($id) {
                call_user_func_array([$controller, $action], [$id]);
            } else {
                call_user_func_array([$controller, $action], []);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Action not found']);
        }

        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'API Controller not found']);
        exit;
    }
}



// Xử lý các yêu cầu không phải API
$controllerFile = 'app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    // Thử fallback về DefaultController nếu controller không tồn tại
    $controllerName = 'DefaultController';
    $controllerFile = 'app/controllers/DefaultController.php';
    if (!file_exists($controllerFile)) {
        die('Controller not found');
    }
}

require_once $controllerFile;
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    $action = 'index'; // Fallback về action mặc định nếu action không tồn tại
    if (!method_exists($controller, $action)) {
        die('Action not found');
    }
}


// Gọi action với các tham số còn lại trong URL
call_user_func_array([$controller, $action], array_slice($url, 2));
?>