<?php
require_once 'config/database.php';

class Product {
    private $conn;
    private $table = 'products';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getFiltered($search = '', $category_id = '', $min_price = '', $max_price = '', $limit = 6, $offset = 0, $excludeZeroStock = false) {
        $query = "SELECT p.*, c.name AS category_name 
                  FROM $this->table p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE 1=1";

        $params = [];

        if ($excludeZeroStock) {
            $query .= " AND p.stock > 0";
        }

        if (!empty($search)) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if (!empty($category_id)) {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        if (!empty($min_price)) {
            $query .= " AND p.price >= :min_price";
            $params[':min_price'] = $min_price;
        }

        if (!empty($max_price)) {
            $query .= " AND p.price <= :max_price";
            $params[':max_price'] = $max_price;
        }

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalFiltered($search = '', $category_id = '', $min_price = '', $max_price = '', $excludeZeroStock = false) {
        $query = "SELECT COUNT(*) as total 
                  FROM $this->table p 
                  WHERE 1=1";

        $params = [];

        if ($excludeZeroStock) {
            $query .= " AND p.stock > 0";
        }

        if (!empty($search)) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if (!empty($category_id)) {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        if (!empty($min_price)) {
            $query .= " AND p.price >= :min_price";
            $params[':min_price'] = $min_price;
        }

        if (!empty($max_price)) {
            $query .= " AND p.price <= :max_price";
            $params[':max_price'] = $max_price;
        }

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $price, $stock, $category_id, $image) {
        $query = "INSERT INTO $this->table (name, description, price, stock, category_id, image) 
                  VALUES (:name, :description, :price, :stock, :category_id, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function update($id, $name, $description, $price, $stock, $category_id, $image) {
        $query = "UPDATE $this->table 
                  SET name = :name, description = :description, price = :price, 
                      stock = :stock, category_id = :category_id, image = :image 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function reduceStock($id, $quantity) {
        $query = "UPDATE $this->table SET stock = stock - :quantity WHERE id = :id AND stock >= :quantity";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Nueva función para contar pedidos
    public function getOrderCount() {
        $query = "SELECT COUNT(*) as total_orders FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];
    }

    // Nueva función para obtener productos más vendidos
    public function getTopSellingProducts($limit = 5) {
        $query = "SELECT p.id, p.name, SUM(od.quantity) as total_sold
                  FROM $this->table p
                  JOIN order_details od ON p.id = od.product_id
                  JOIN orders o ON od.order_id = o.id
                  GROUP BY p.id, p.name
                  ORDER BY total_sold DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>