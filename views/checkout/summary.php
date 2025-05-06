<?php include 'views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="text-center mb-4">
        <h1 class="text-success fw-bold">✅ Compra Completada</h1>
        <div class="alert alert-success mt-3">
            ¡Gracias por tu compra, <strong><?php echo htmlspecialchars($order['username']); ?></strong>!
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">📄 Resumen del Pedido <span class="text-muted">#<?php echo $order['id']; ?></span></h5>
        </div>
        <div class="card-body">
            <p><strong>🗓️ Fecha:</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>💵 Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
            <p><strong>📬 Dirección de Envío:</strong> <?php echo htmlspecialchars($order['shipping_info']); ?></p>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light">
            <h5 class="mb-0">🧾 Detalles de la Compra</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_details as $detail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['name']); ?></td>
                            <td class="text-center"><?php echo $detail['quantity']; ?></td>
                            <td class="text-end">$<?php echo number_format($detail['price'], 2); ?></td>
                            <td class="text-end">$<?php echo number_format($detail['price'] * $detail['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <a href="/ecommerce/index.php" class="btn btn-primary">
            <i class="bi bi-house-door-fill"></i> Volver al Inicio
        </a>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
