<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Registrarse</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="/ecommerce/index.php?controller=user&action=register">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
        <p class="mt-2">¿Ya tienes cuenta? <a href="/ecommerce/index.php?controller=user&action=login">Inicia sesión</a></p>
    </form>
</div>
<?php include 'views/layouts/footer.php'; ?>