<?php

class NewsModel {
    private $conn;
    private $table_name = "News";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $query = "SELECT n.*, t.Name as TournamentName
                  FROM {$this->table_name} n
                  LEFT JOIN Tournaments t ON n.TournamentID = t.TournamentID
                  ORDER BY n.PublishDate DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id) {
        $query = "SELECT n.*, t.Name as TournamentName
                  FROM {$this->table_name} n
                  LEFT JOIN Tournaments t ON n.TournamentID = t.TournamentID
                  WHERE n.NewsID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addNews($title, $content, $author, $tournamentId) {
        $query = "INSERT INTO {$this->table_name} (Title, Content, Author, TournamentID) VALUES (:title, :content, :author, :tournamentId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':tournamentId', $tournamentId);
        return $stmt->execute();
    }
    public function updateNews($id, $title, $content, $author, $tournamentId) {
        $query = "UPDATE {$this->table_name} SET Title=:title, Content=:content, Author=:author, TournamentID=:tournamentId WHERE NewsID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':tournamentId', $tournamentId);
        return $stmt->execute();
    }
    public function deleteNews($id) {
        $query = "DELETE FROM {$this->table_name} WHERE NewsID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>