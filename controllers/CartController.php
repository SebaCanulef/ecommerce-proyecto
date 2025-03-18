<?php
require_once 'models/Product.php';

class CartController {
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function add() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $response = ['success' => false, 'message' => 'Error al agregar el producto'];

        if ($id) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][$id] = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] + 1 : 1;
            $response = ['success' => true, 'message' => '¡Producto añadido al carrito!'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function index() {
        $cartItems = [];
        $total = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $quantity) {
                $product = $this->product->getById($id);
                if ($product) {
                    $cartItems[] = [
                        'id' => $id,
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $quantity,
                        'subtotal' => $product['price'] * $quantity
                    ];
                    $total += $product['price'] * $quantity;
                }
            }
        }

        require_once 'views/cart/index.php';
    }

    public function remove() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id] > 1) {
                $_SESSION['cart'][$id]--;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: /ecommerce/index.php?controller=cart&action=index');
        exit;
    }

    // Método corregido para manejar el array de cantidades
    public function update() {
        if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $id => $quantity) {
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);

                if ($id && $quantity !== null && isset($_SESSION['cart'][$id])) {
                    if ($quantity <= 0) {
                        unset($_SESSION['cart'][$id]); // Eliminar si la cantidad es 0 o negativa
                    } elseif ($quantity > 10) {
                        $_SESSION['cart'][$id] = 10; // Limitar a 10 como máximo
                    } else {
                        $_SESSION['cart'][$id] = $quantity; // Actualizar a la nueva cantidad
                    }
                }
            }
        }

        header('Location: /ecommerce/index.php?controller=cart&action=index');
        exit;
    }
}
?>