<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Iniciar sesión
    public function login($username, $password) {
        $query = "SELECT * FROM $this->table WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Registrar un nuevo usuario
    public function register($username, $email, $password) {
        $query = "INSERT INTO $this->table (username, email, password) 
                  VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Manejar error de duplicado (username o email ya existen)
            return false;
        }
    }
}
?>