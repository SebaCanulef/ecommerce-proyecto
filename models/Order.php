<?php
require_once 'config/database.php';

class Order {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Crear un nuevo pedido
    public function create($user_id, $total, $shipping_info) {
        $query = "INSERT INTO orders (user_id, total, shipping_info) 
                  VALUES (:user_id, :total, :shipping_info)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':shipping_info', $shipping_info);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Agregar detalles del pedido
    public function addDetails($order_id, $product_id, $quantity, $price) {
        $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // Obtener un pedido por ID
    public function getById($id) {
        $query = "SELECT o.*, u.username 
                  FROM orders o 
                  LEFT JOIN users u ON o.user_id = u.id 
                  WHERE o.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener detalles de un pedido
    public function getDetails($order_id) {
        $query = "SELECT od.*, p.name 
                  FROM order_details od 
                  LEFT JOIN products p ON od.product_id = p.id 
                  WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>