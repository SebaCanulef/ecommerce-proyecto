<?php include 'views/layouts/header_admin.php'; ?>

<div class="container my-5">
    <h1 class="mb-4 text-center">🛠️ Panel de Administración - Productos</h1>

    <!-- Botones de acción -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex gap-3 flex-wrap">
            <a href="/ecommerce/index.php?controller=admin&action=create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agregar Producto
            </a>
            <a href="/ecommerce/index.php?controller=admin&action=stats" class="btn btn-info text-white">
                <i class="bi bi-bar-chart-line"></i> Ver Estadísticas
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="/ecommerce/index.php">
                <input type="hidden" name="controller" value="admin">
                <input type="hidden" name="action" value="index">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="category_id" class="form-select">
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
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Errores -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Tabla de productos -->
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay productos que coincidan con los filtros.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($product['category_name']); ?></span></td>
                            <td class="text-center">
                                <a href="/ecommerce/index.php?controller=admin&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <a href="/ecommerce/index.php?controller=admin&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <?php if ($total_pages > 1): ?>
        <nav class="mt-4">
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