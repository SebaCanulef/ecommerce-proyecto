<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Compra Completada</h1>
    <div class="alert alert-success">¡Gracias por tu compra, <?php echo htmlspecialchars($order['username']); ?>!</div>
    <h3>Resumen del Pedido #<?php echo $order['id']; ?></h3>
    <p><strong>Fecha:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
    <p><strong>Dirección de Envío:</strong> <?php echo htmlspecialchars($order['shipping_info']); ?></p>
    <h4>Detalles</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_details as $detail): ?>
                <tr>
                    <td><?php echo htmlspecialchars($detail['name']); ?></td>
                    <td><?php echo $detail['quantity']; ?></td>
                    <td>$<?php echo number_format($detail['price'], 2); ?></td>
                    <td>$<?php echo number_format($detail['price'] * $detail['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/ecommerce/index.php" class="btn btn-primary">Volver al Inicio</a>
</div>
<?php include 'views/layouts/footer.php'; ?>