<!-- Vista: Editar Dirección de Envío -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session')
        ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta que contiene el formulario para editar la dirección -->
    <section class="card mb-4">
        <!-- Cabecera de la tarjeta -->
        <header class="card-header">
            <h2 class="mb-0">Editar Dirección de Envío</h2>
        </header>

        <!-- Cuerpo de la tarjeta: Formulario de edición -->
        <div class="card-body">
            <form action="<?= site_url('cliente/direcciones/actualizar/' . $direccion->id) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <!-- Nombre del destinatario -->
                    <div class="col-12">
                        <label for="nombre_destinatario" class="form-label">Nombre del Destinatario</label>
                        <input type="text" class="form-control" id="nombre_destinatario" name="nombre_destinatario" placeholder="Ingresa el nombre del destinatario" value="<?= esc($direccion->nombre_destinatario) ?>" required>
                    </div>

                    <!-- Calle y Número -->
                    <div class="col-md-8">
                        <label for="calle" class="form-label">Calle</label>
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la calle" value="<?= esc($direccion->calle) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= esc($direccion->numero) ?>" required>
                    </div>

                    <!-- Piso y Departamento (opcional) -->
                    <div class="col-md-6">
                        <label for="piso" class="form-label">Piso <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" id="piso" name="piso" placeholder="Piso" value="<?= esc($direccion->piso) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="departamento" class="form-label">Departamento <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" value="<?= esc($direccion->departamento) ?>">
                    </div>

                    <!-- Ciudad y Provincia -->
                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" value="<?= esc($direccion->ciudad) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="provincia" class="form-label">Provincia</label>
                        <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" value="<?= esc($direccion->provincia) ?>" required>
                    </div>

                    <!-- Código Postal y Teléfono -->
                    <div class="col-md-6">
                        <label for="codigo_postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" value="<?= esc($direccion->codigo_postal) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?= esc($direccion->telefono) ?>" required>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex justify-content-end mt-4">
                    <!-- Botón para cancelar y volver al perfil -->
                    <a href="<?= site_url('cliente/perfil') ?>" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                    <!-- Botón para guardar los cambios -->
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>