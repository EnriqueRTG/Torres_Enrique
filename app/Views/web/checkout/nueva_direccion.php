<!-- 
    Vista: Agregar Nueva Dirección de Envío
    Ubicación: app/Views/cliente/direccion_crear.php

    Esta vista permite al cliente ingresar los datos necesarios para agregar una dirección de envío.
    Se utilizan componentes de Bootstrap para lograr responsividad y una estructura semántica correcta.
-->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: se muestran alertas de error o éxito -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta para el formulario de agregar dirección -->
    <section class="card">
        <header class="card-header">
            <h2 class="mb-0">Agregar Nueva Dirección</h2>
        </header>
        <div class="card-body">
            <!-- Formulario para registrar una nueva dirección -->
            <form action="<?= site_url('checkout/crearNuevaDireccion') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <!-- Nombre del destinatario -->
                    <div class="col-12">
                        <label for="nombre_destinatario" class="form-label">Nombre del Destinatario</label>
                        <input type="text" class="form-control" id="nombre_destinatario" name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario" required>
                    </div>

                    <!-- Calle y Número -->
                    <div class="col-md-8">
                        <label for="calle" class="form-label">Calle</label>
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la calle" required>
                    </div>
                    <div class="col-md-4">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" required>
                    </div>

                    <!-- Piso y Departamento (opcional) -->
                    <div class="col-md-6">
                        <label for="piso" class="form-label">Piso <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" id="piso" name="piso" placeholder="Piso">
                    </div>
                    <div class="col-md-6">
                        <label for="departamento" class="form-label">Departamento <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento">
                    </div>

                    <!-- Ciudad y Provincia -->
                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" required>
                    </div>
                    <div class="col-md-6">
                        <label for="provincia" class="form-label">Provincia</label>
                        <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" required>
                    </div>

                    <!-- Código Postal y Teléfono -->
                    <div class="col-md-6">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                    </div>
                </div>
                <!-- Botones de acción -->
                <div class="d-flex justify-content-end mt-4">
                    <!-- Botón para cancelar y regresar al perfil -->
                    <a href="<?= site_url('cliente/perfil') ?>" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <!-- Botón para guardar la nueva dirección -->
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Dirección
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>