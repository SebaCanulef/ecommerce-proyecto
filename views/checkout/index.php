<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Finalizar Compra</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <h3>Datos de Envío</h3>
            <form method="POST" action="/ecommerce/index.php?controller=checkout&action=index">
                <div class="mb-3">
                    <label for="shipping_info" class="form-label">Dirección de Envío</label>
                    <textarea name="shipping_info" id="shipping_info" class="form-control" rows="4" required placeholder="Ingresa tu dirección completa"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                <a href="/ecommerce/index.php?controller=cart&action=index" class="btn btn-secondary">Volver al Carrito</a>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Resumen del Carrito</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total:</strong></td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>