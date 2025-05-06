<?php include 'views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">📝 Crear Cuenta</h2>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/ecommerce/index.php?controller=user&action=register">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" name="username" id="username" class="form-control" required placeholder="Elige un nombre de usuario">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="ejemplo@correo.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Crea una contraseña segura">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-person-plus-fill"></i> Registrarse
                            </button>
                        </div>
                    </form>

                    <p class="mt-3 text-center">
                        ¿Ya tienes cuenta?
                        <a href="/ecommerce/index.php?controller=user&action=login">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
