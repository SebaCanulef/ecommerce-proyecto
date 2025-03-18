<?php
require_once 'models/Order.php';
require_once 'models/Product.php';

class CheckoutController {
    private $order;
    private $product;

    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: /ecommerce/index.php?controller=user&action=login');
            exit;
        }
        $this->order = new Order();
        $this->product = new Product();
    }

    public function index() {
        if (empty($_SESSION['cart'])) {
            header('Location: /ecommerce/index.php?controller=cart&action=index');
            exit;
        }

        $cartItems = [];
        $total = 0;
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shipping_info = filter_input(INPUT_POST, 'shipping_info', FILTER_SANITIZE_STRING);
            
            // Verificar stock antes de procesar el pedido
            foreach ($cartItems as $item) {
                $product = $this->product->getById($item['id']);
                if ($product['stock'] < $item['quantity']) {
                    $error = "No hay suficiente stock para " . htmlspecialchars($item['name']) . ". Stock disponible: " . $product['stock'];
                    require_once 'views/checkout/index.php';
                    return;
                }
            }

            // Crear el pedido
            $order_id = $this->order->create($_SESSION['user']['id'], $total, $shipping_info);
            if ($order_id) {
                // Agregar detalles y reducir stock
                foreach ($cartItems as $item) {
                    $this->order->addDetails($order_id, $item['id'], $item['quantity'], $item['price']);
                    $this->product->reduceStock($item['id'], $item['quantity']);
                }
                unset($_SESSION['cart']); // Vaciar el carrito
                header("Location: /ecommerce/index.php?controller=checkout&action=summary&id=$order_id");
                exit;
            } else {
                $error = "Error al procesar el pedido.";
            }
        }

        require_once 'views/checkout/index.php';
    }

    public function summary() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $order = $this->order->getById($id);
        $order_details = $this->order->getDetails($id);
        if (!$order || $order['user_id'] !== $_SESSION['user']['id']) {
            header('Location: /ecommerce/index.php');
            exit;
        }
        require_once 'views/checkout/summary.php';
    }
}
?>