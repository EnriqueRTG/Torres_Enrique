<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal del registro -->
<main class="container my-5 d-flex justify-content-center align-items-center main-content">
    <section class="card p-4 shadow-sm w-100" style="max-width: 500px;">
        <!-- Formulario de Registro -->
        <form action="<?= base_url('registro') ?>" method="POST" class="needs-validation" novalidate>
            <!-- Token de seguridad -->
            <?= csrf_field(); ?>

            <!-- Título -->
            <header class="text-center mb-4">
                <h2 class="text-uppercase">Crear Cuenta</h2>
                <p class="text-muted">Comprá más rápido y llevá el control de tus pedidos en un solo lugar.</p>
            </header>

            <!-- Campo: Nombre -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Nombre" required>
                <label for="nombre">Nombre</label>
                <?php if (session('errors.nombre')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.nombre') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Campo: Apellido -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= session('errors.apellido') ? 'is-invalid' : '' ?>" id="apellido" name="apellido" value="<?= old('apellido') ?>" placeholder="Apellido" required>
                <label for="apellido">Apellido</label>
                <?php if (session('errors.apellido')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.apellido') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Campo: Correo Electrónico -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="Correo Electrónico" required>
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

            <!-- Campo: Confirmar Contraseña -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                <label for="confirm_password">Confirmar Contraseña</label>
                <?php if (session('errors.confirm_password')): ?>
                    <div class="invalid-feedback">
                        <?= session('errors.confirm_password') ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Términos y condiciones -->
            <div class="form-check my-3">
                <input type="checkbox" name="terms" class="form-check-input" id="terms" value="1" required>
                <label class="form-check-label" for="terms">Acepto los <a href="<?= site_url('terminos') ?>" target="_blank">términos y condiciones</a></label>
                <?php if (session('errors.terms')): ?>
                    <div class="text-danger small">
                        <?= session('errors.terms') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Enlace para iniciar sesión -->
            <div class="text-center my-3">
                <p class="mb-0">¿Ya tienes una cuenta? <a href="<?= site_url('login'); ?>" class="text-accent">Inicia sesión aquí</a></p>
            </div>

            <!-- Botón de Registro -->
            <div class="text-center">
                <button type="submit" class="btn btn-custom w-100">Registrar</button>
            </div>
        </form>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>