<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Agregar Producto</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="/ecommerce/index.php?controller=admin&action=create">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">URL de la Imagen</label>
            <input type="url" class="form-control" id="image" name="image" placeholder="https://example.com/image.jpg">
            <small class="form-text text-muted">Deja en blanco para usar la imagen por defecto.</small>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/ecommerce/index.php?controller=admin&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include 'views/layouts/footer.php'; ?>