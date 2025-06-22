<?php

class VideoModel {
    private $conn;
    private $table_name = "Videos";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $query = "SELECT v.*, m.MatchDate, t1.Name AS Team1Name, t2.Name AS Team2Name
                  FROM {$this->table_name} v
                  LEFT JOIN Matches m ON v.MatchID = m.MatchID
                  LEFT JOIN Teams t1 ON m.Team1ID = t1.TeamID
                  LEFT JOIN Teams t2 ON m.Team2ID = t2.TeamID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id) {
        $query = "SELECT v.*, m.MatchDate, t1.Name AS Team1Name, t2.Name AS Team2Name
                  FROM {$this->table_name} v
                  LEFT JOIN Matches m ON v.MatchID = m.MatchID
                  LEFT JOIN Teams t1 ON m.Team1ID = t1.TeamID
                  LEFT JOIN Teams t2 ON m.Team2ID = t2.TeamID
                  WHERE v.VideoID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addVideo($title, $url, $matchId) {
        $query = "INSERT INTO {$this->table_name} (Title, URL, MatchID) VALUES (:title, :url, :matchId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':matchId', $matchId);
        return $stmt->execute();
    }
    public function updateVideo($id, $title, $url, $matchId) {
        $query = "UPDATE {$this->table_name} SET Title=:title, URL=:url, MatchID=:matchId WHERE VideoID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':matchId', $matchId);
        return $stmt->execute();
    }
    public function deleteVideo($id) {
        $query = "DELETE FROM {$this->table_name} WHERE VideoID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>