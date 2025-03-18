<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Carrito de Compras</h1>
    <?php if (empty($cartItems)): ?>
        <p>Tu carrito está vacío.</p>
        <a href="/ecommerce/index.php" class="btn btn-primary">Volver al catálogo</a>
    <?php else: ?>
        <form method="POST" action="/ecommerce/index.php?controller=cart&action=update">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" max="10" class="form-control" style="width: 80px;" onchange="this.form.submit()">
                            </td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                            <td>
                                <a href="/ecommerce/index.php?controller=cart&action=remove&id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <a href="/ecommerce/index.php" class="btn btn-secondary">Seguir comprando</a>
        <a href="/ecommerce/index.php?controller=checkout&action=index" class="btn btn-primary">Proceder al pago</a>
    <?php endif; ?>
</div>
<?php include 'views/layouts/footer.php'; ?>