<?php
require_once 'models/Product.php';
require_once 'models/Category.php';

class AdminController {
    private $product;
    private $category;

    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /ecommerce/index.php?controller=user&action=login');
            exit;
        }
        $this->product = new Product();
        $this->category = new Category();
    }

    public function index() {
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
        $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $min_price = filter_input(INPUT_GET, 'min_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $max_price = filter_input(INPUT_GET, 'max_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) ?: 1;

        $items_per_page = 6;
        $offset = ($page - 1) * $items_per_page;

        $products = $this->product->getFiltered($search, $category_id, $min_price, $max_price, $items_per_page, $offset);
        $total_products = $this->product->getTotalFiltered($search, $category_id, $min_price, $max_price);
        $total_pages = ceil($total_products / $items_per_page);

        $categories = $this->category->getAll();
        require_once 'views/admin/index.php';
    }

    public function create() {
        $this->category = new Category();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL) ?: 'default.jpg';

            if ($this->product->create($name, $description, $price, $stock, $category_id, $image)) {
                header('Location: /ecommerce/index.php?controller=admin&action=index');
                exit;
            } else {
                $error = "Error al crear el producto.";
            }
        }
        $categories = $this->category->getAll();
        require_once 'views/admin/create.php';
    }

    public function edit() {
        $this->category = new Category();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $product = $this->product->getById($id);
        if (!$product) {
            header('Location: /ecommerce/index.php?controller=admin&action=index');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL) ?: 'default.jpg';

            if ($this->product->update($id, $name, $description, $price, $stock, $category_id, $image)) {
                header('Location: /ecommerce/index.php?controller=admin&action=index');
                exit;
            } else {
                $error = "Error al actualizar el producto.";
            }
        }
        $categories = $this->category->getAll();
        require_once 'views/admin/edit.php';
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if ($id && $this->product->delete($id)) {
            header('Location: /ecommerce/index.php?controller=admin&action=index');
            exit;
        } else {
            $error = "Error al eliminar el producto.";
            require_once 'views/admin/index.php';
        }
    }

    // Nueva acción para estadísticas
    public function stats() {
        $total_orders = $this->product->getOrderCount();
        $top_products = $this->product->getTopSellingProducts();
        require_once 'views/admin/stats.php';
    }
}
?>