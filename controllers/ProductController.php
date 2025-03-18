<?php
require_once 'models/Product.php';
require_once 'models/Category.php';

class ProductController {
    private $product;
    private $category;

    public function __construct() {
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

        // Excluir productos con stock 0 en el catálogo
        $products = $this->product->getFiltered($search, $category_id, $min_price, $max_price, $items_per_page, $offset, true);
        $total_products = $this->product->getTotalFiltered($search, $category_id, $min_price, $max_price, true);
        $total_pages = ceil($total_products / $items_per_page);

        $categories = $this->category->getAll();
        require_once 'views/products/index.php';
    }
}
?>