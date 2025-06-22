<?php
class FavoriteModel {
    private $conn;
    private $table_name = "UserFavorites";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getFavoritesByUser($userId) {
        $query = "SELECT f.*, t.Name as team_name, m.MatchDate
                  FROM {$this->table_name} f
                  LEFT JOIN Teams t ON f.TeamID = t.TeamID
                  LEFT JOIN Matches m ON f.MatchID = m.MatchID
                  WHERE f.UserID = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function addFavorite($userId, $teamId, $matchId) {
        $query = "INSERT INTO {$this->table_name} (UserID, TeamID, MatchID) VALUES (:userId, :teamId, :matchId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->bindParam(':matchId', $matchId);
        return $stmt->execute();
    }
    public function deleteFavorite($favoriteId) {
        $query = "DELETE FROM {$this->table_name} WHERE FavoriteID = :favoriteId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':favoriteId', $favoriteId);
        return $stmt->execute();
    }
}
?>