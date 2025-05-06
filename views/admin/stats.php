<?php include 'views/layouts/header_admin.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="bi bi-bar-chart-fill me-2"></i>Estadísticas del Sistema</h1>
        <a href="/ecommerce/index.php?controller=admin&action=index" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Cantidad Total de Pedidos</h5>
                    <p class="display-4 fw-bold text-success"><?php echo htmlspecialchars($total_orders); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Productos Más Vendidos</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($top_products)): ?>
                        <p class="text-muted">No hay productos vendidos aún.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Unidades Vendidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($top_products as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                                            <td class="text-center fw-bold"><?php echo htmlspecialchars($product['total_sold']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
