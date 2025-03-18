<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Estadísticas del Sistema</h1>
    <a href="/ecommerce/index.php?controller=admin&action=index" class="btn btn-secondary mb-3">Volver al Panel</a>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Cantidad Total de Pedidos</h5>
                    <p class="card-text display-4"><?php echo htmlspecialchars($total_orders); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Productos Más Vendidos</h2>
            <?php if (empty($top_products)): ?>
                <p>No hay productos vendidos aún.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Unidades Vendidas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($top_products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['total_sold']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>