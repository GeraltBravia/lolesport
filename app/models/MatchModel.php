<?php
class MatchModel {
    private $conn;
    private $table_name = "Matches";
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT m.*, t1.Name AS Team1Name, t2.Name AS Team2Name, tour.Name AS TournamentName, tour.Slug AS TournamentSlug
                  FROM {$this->table_name} m
                  LEFT JOIN Teams t1 ON m.Team1ID = t1.TeamID
                  LEFT JOIN Teams t2 ON m.Team2ID = t2.TeamID
                  LEFT JOIN Tournaments tour ON m.TournamentID = tour.TournamentID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $query = "SELECT m.*, t1.Name AS Team1Name, t2.Name AS Team2Name, tour.Name AS TournamentName
                  FROM {$this->table_name} m
                  LEFT JOIN Teams t1 ON m.Team1ID = t1.TeamID
                  LEFT JOIN Teams t2 ON m.Team2ID = t2.TeamID
                  LEFT JOIN Tournaments tour ON m.TournamentID = tour.TournamentID
                  WHERE m.MatchID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Thêm kiểu dữ liệu
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addMatch($tournamentId, $team1Id, $team2Id, $matchDate, $status, $winnerId, $score, $bo, $stage) {
        $query = "INSERT INTO Matches (TournamentID, Team1ID, Team2ID, MatchDate, Status, WinnerID, Score, BO, Stage)
                  VALUES (:tournamentId, :team1Id, :team2Id, :matchDate, :status, :winnerId, :score, :bo, :stage)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tournamentId', $tournamentId);
        $stmt->bindParam(':team1Id', $team1Id);
        $stmt->bindParam(':team2Id', $team2Id);
        $stmt->bindParam(':matchDate', $matchDate);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':winnerId', $winnerId);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':bo', $bo);
        $stmt->bindParam(':stage', $stage);
        return $stmt->execute();
    }

    public function updateMatch($id, $tournamentId, $team1Id, $team2Id, $matchDate, $status, $winnerId, $score) {
        $query = "UPDATE {$this->table_name} SET TournamentID=:tournamentId, Team1ID=:team1Id, Team2ID=:team2Id,
                  MatchDate=:matchDate, Status=:status, WinnerID=:winnerId, Score=:score WHERE MatchID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':tournamentId', $tournamentId);
        $stmt->bindParam(':team1Id', $team1Id);
        $stmt->bindParam(':team2Id', $team2Id);
        $stmt->bindParam(':matchDate', $matchDate);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':winnerId', $winnerId);
        $stmt->bindParam(':score', $score);
        return $stmt->execute();
    }

    public function deleteMatch($id) {
        $query = "DELETE FROM {$this->table_name} WHERE MatchID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Lấy danh sách các trận đấu playoff (cần điều chỉnh nếu cột stage không tồn tại)
    public function getPlayoffMatches() {
        // Kiểm tra nếu cột stage không tồn tại, thay bằng logic khác (ví dụ: Status = 'playoff')
        $query = "SELECT * FROM {$this->table_name} WHERE Status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':status', 'playoff', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>