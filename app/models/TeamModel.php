<?php
class TeamModel {
    private $conn;
    private $table_name = "Teams";
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $query = "SELECT t.*, tour.Name as TournamentName
                  FROM {$this->table_name} t
                  LEFT JOIN Tournaments tour ON t.TournamentID = tour.TournamentID";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id) {
        $query = "SELECT t.*, tour.Name as TournamentName
                  FROM {$this->table_name} t
                  LEFT JOIN Tournaments tour ON t.TournamentID = tour.TournamentID
                  WHERE t.TeamID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addTeam($name, $region, $logoURL, $tournamentId) {
        $query = "INSERT INTO {$this->table_name} (Name, Region, LogoURL, TournamentID) VALUES (:name, :region, :logoURL, :tournamentId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':logoURL', $logoURL);
        $stmt->bindParam(':tournamentId', $tournamentId);
        return $stmt->execute();
    }
    public function updateTeam($id, $name, $region, $logoURL, $tournamentId) {
        $query = "UPDATE {$this->table_name} SET Name=:name, Region=:region, LogoURL=:logoURL, TournamentID=:tournamentId WHERE TeamID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':logoURL', $logoURL);
        $stmt->bindParam(':tournamentId', $tournamentId);
        return $stmt->execute();
    }
    public function deleteTeam($id) {
        $query = "DELETE FROM {$this->table_name} WHERE TeamID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>