<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal del login -->
<main class="container my-5 d-flex justify-content-center align-items-center main-content">
    <section class="card p-4 shadow-sm w-100" style="max-width: 500px;">
        <!-- Formulario de Login -->
        <form action="<?= base_url('login') ?>" method="POST" class="needs-validation" novalidate>
            <!-- Token de seguridad -->
            <?= csrf_field(); ?>

            <!-- Título -->
            <header class="text-center mb-4">
                <h2 class="text-uppercase">Ingresar</h2>
                <p class="text-muted">Comprá más rápido y llevá el control de tus pedidos en un solo lugar.</p>
            </header>

            <!-- Campo: Correo Electrónico -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="Correo electrónico" required>
                <label for="email">Correo Electrónico</label>
                <?php if (session('errors.email')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Campo: Contraseña -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
                <?php if (session('errors.password')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Enlace para registrarse -->
            <div class="text-center my-3">
                <p class="mb-0">¿No tienes una cuenta? <a href="<?= site_url('registro'); ?>" class="text-accent">Regístrate aquí</a></p>
            </div>

            <!-- Botón de Ingreso -->
            <div class="text-center">
                <button type="submit" class="btn btn-custom w-100">Iniciar Sesión</button>
            </div>
        </form>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>