<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Panel de Administración - Productos</h1>
    <div class="mb-3">
        <a href="/ecommerce/index.php?controller=admin&action=create" class="btn btn-primary">Agregar Producto</a>
        <a href="/ecommerce/index.php?controller=admin&action=stats" class="btn btn-info">Ver Estadísticas</a>
    </div>

    <form method="GET" action="/ecommerce/index.php" class="mb-4">
        <input type="hidden" name="controller" value="admin">
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

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="7">No hay productos que coincidan con los filtros.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                        <td>
                            <a href="/ecommerce/index.php?controller=admin&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="/ecommerce/index.php?controller=admin&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
        <nav aria-label="Paginación" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="/ecommerce/index.php?controller=admin&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $page - 1; ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="/ecommerce/index.php?controller=admin&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="/ecommerce/index.php?controller=admin&action=index&search=<?php echo urlencode($search ?? ''); ?>&category_id=<?php echo $category_id ?? ''; ?>&min_price=<?php echo $min_price ?? ''; ?>&max_price=<?php echo $max_price ?? ''; ?>&page=<?php echo $page + 1; ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<?php include 'views/layouts/footer.php'; ?>