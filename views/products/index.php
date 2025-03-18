<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Catálogo de Productos</h1>
    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <form method="GET" action="/ecommerce/index.php" class="mb-4">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="index">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($search ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-control">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($category_id ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="Precio mín." step="0.01" value="<?php echo htmlspecialchars($min_price ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="Precio máx." step="0.01" value="<?php echo htmlspecialchars($max_price ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php if (empty($products)): ?>
            <p>No se encontraron productos.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <?php
                        // Si la imagen no empieza con http, asumimos que es local y añadimos /ecommerce/uploads/
                        $imageUrl = (strpos($product['image'], 'http') === 0) ? $product['image'] : '/ecommerce/uploads/' . $product['image'];
                        ?>
                        <img src="<?php echo htmlspecialchars($imageUrl); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong>$<?php echo number_format($product['price'], 2); ?></strong></p>
                            <button class="btn btn-success add-to-cart" data-id="<?php echo $product['id']; ?>">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($total_pages > 1): ?>
        <nav aria-label="Paginación" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="/ecommerce/index.php?controller=product&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $page - 1; ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="/ecommerce/index.php?controller=product&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="/ecommerce/index.php?controller=product&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $page + 1; ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.add-to-cart');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            const url = `/ecommerce/index.php?controller=cart&action=add&id=${productId}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const alertContainer = document.getElementById('alert-container');
                    const alert = document.createElement('div');
                    alert.className = `alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show`;
                    alert.role = 'alert';
                    alert.innerHTML = `
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    alertContainer.appendChild(alert);
                    setTimeout(() => {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    const alertContainer = document.getElementById('alert-container');
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-danger alert-dismissible fade show';
                    alert.role = 'alert';
                    alert.innerHTML = `
                        Error al agregar el producto
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    alertContainer.appendChild(alert);
                    setTimeout(() => {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }, 3000);
                });
        });
    });
});
</script>
<?php include 'views/layouts/footer.php'; ?>