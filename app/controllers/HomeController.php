<?php
require_once 'app/config/database.php';
require_once 'app/models/MatchModel.php';
require_once 'app/helpers/AuthHelper.php';

class HomeController {
    private $matchModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->matchModel = new MatchModel($this->db);
    }

    public function index() {
        include 'app/views/home.php';
    }

    public function apiMatch() {
        header('Content-Type: application/json');
        $matches = $this->matchModel->getAll();
        echo json_encode($matches);
        exit;
    }
}