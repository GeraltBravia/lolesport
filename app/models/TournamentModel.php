<?php

class TournamentModel {
    private $conn;
    private $table_name = "Tournaments";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $query = "SELECT * FROM {$this->table_name}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id) {
        $query = "SELECT * FROM {$this->table_name} WHERE TournamentID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addTournament($name, $startDate, $endDate, $slug, $status) {
        $query = "INSERT INTO Tournaments (Name, StartDate, EndDate, Slug, Status) VALUES (:name, :startDate, :endDate, :slug, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
    public function updateTournament($id, $name, $startDate, $endDate, $region, $status) {
        $query = "UPDATE {$this->table_name} SET Name=:name, StartDate=:startDate, EndDate=:endDate, Region=:region, Status=:status WHERE TournamentID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
    public function deleteTournament($id) {
        $query = "DELETE FROM {$this->table_name} WHERE TournamentID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>