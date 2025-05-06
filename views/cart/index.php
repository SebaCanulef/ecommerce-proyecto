<?php include 'views/layouts/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4 text-center">🛒 Carrito de Compras</h1>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center">
            Tu carrito está vacío.
        </div>
        <div class="text-center">
            <a href="/ecommerce/index.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
        </div>
    <?php else: ?>
        <form method="POST" action="/ecommerce/index.php?controller=cart&action=update">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Precio Unitario</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                </td>
                                <td class="text-center">
                                    $<?php echo number_format($item['price'], 2); ?>
                                </td>
                                <td class="text-center" style="width: 120px;">
                                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" max="10" class="form-control text-center" onchange="this.form.submit()">
                                </td>
                                <td class="text-center">
                                    $<?php echo number_format($item['subtotal'], 2); ?>
                                </td>
                                <td class="text-center">
                                    <a href="/ecommerce/index.php?controller=cart&action=remove&id=<?php echo $item['id']; ?>" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="text-center fw-bold">$<?php echo number_format($total, 2); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>

        <div class="d-flex justify-content-between mt-4">
            <a href="/ecommerce/index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Seguir comprando
            </a>
            <a href="/ecommerce/index.php?controller=checkout&action=index" class="btn btn-success">
                <i class="bi bi-credit-card"></i> Proceder al pago
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/layouts/footer.php'; ?>
