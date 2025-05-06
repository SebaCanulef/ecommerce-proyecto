<?php include 'views/layouts/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4 text-center">🧾 Finalizar Compra</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Datos de Envío -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📦 Datos de Envío</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/ecommerce/index.php?controller=checkout&action=index">
                        <div class="mb-3">
                            <label for="shipping_info" class="form-label">Dirección de Envío</label>
                            <textarea name="shipping_info" id="shipping_info" class="form-control" rows="4" required placeholder="Ingresa tu dirección completa"></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/ecommerce/index.php?controller=cart&action=index" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Volver al Carrito
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check2-circle"></i> Confirmar Pedido
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Resumen del Carrito -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">🛍️ Resumen del Carrito</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-end">$<?php echo number_format($item['subtotal'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold">$<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
