<?php
class UserModel {
    private $conn;
    private $table_name = "Users";

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
        $query = "SELECT * FROM {$this->table_name} WHERE UserID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getByUsername($username) {
        $query = "SELECT * FROM {$this->table_name} WHERE Username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addUser($username, $passwordHash, $email, $role = 'user') {
        $query = "INSERT INTO {$this->table_name} (Username, PasswordHash, Email, Role) VALUES (:username, :passwordHash, :email, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function updateUser($id, $username, $email, $role) {
        $query = "UPDATE {$this->table_name} SET Username = :username, Email = :email, Role = :role WHERE UserID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM {$this->table_name} WHERE UserID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>