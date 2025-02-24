<!-- Vista: Editar Perfil del Cliente -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenido principal: Formulario para editar el perfil -->
<main class="container my-3 main-content">

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta para editar el perfil -->
    <section class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0">Editar Mi Perfil</h2>
        </div>
        <div class="card-body">
            <!-- Formulario para actualizar los datos del perfil -->
            <form action="<?= site_url('cliente/perfil/actualizar') ?>" method="post">
                <?= csrf_field() ?>
                <!-- Campo Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= esc($cliente->nombre) ?>" placeholder="Nombre" required>
                    <?php if (session('errors.nombre')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.nombre') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Campo Apellido -->
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control <?= session('errors.apellido') ? 'is-invalid' : '' ?>" id="apellido" name="apellido" value="<?= esc($cliente->apellido) ?>" placeholder="Apellido" required>
                    <?php if (session('errors.apellido')): ?>
                        <div class="invalid-feedback">
                            <?= session('errors.apellido') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Otros campos de información, si es necesario -->
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar Cambios
                </button>
            </form>
        </div>
    </section>

    <!-- Tarjeta para gestionar direcciones de envío -->
    <section class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0">Mis Direcciones de Envío</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($direcciones)): ?>
                <ul class="list-group mb-3">

                    <?php foreach ($direcciones as $direccion): ?>
                        <li class="list-group-item my-3">
                            <!-- Usamos un contenedor row para dividir en dos columnas en desktop -->
                            <div class="row align-items-center">
                                <!-- Columna de detalles (se extiende en mobile a 12 columnas, en desktop 9) -->
                                <div class="col-12 col-md-10">
                                    <p class="mb-1">
                                        <strong>Nombre Destinatario:</strong> <?= esc($direccion->nombre_destinatario) ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Calle y Número:</strong> <?= esc($direccion->calle) ?>, <?= esc($direccion->numero) ?>
                                        <?php if (!empty($direccion->piso) || !empty($direccion->departamento)): ?>
                                            <br>
                                            <small>
                                                <strong>Piso:</strong> <?= esc($direccion->piso) ?>
                                                <strong>Depto:</strong> <?= esc($direccion->departamento) ?>
                                            </small>
                                        <?php endif; ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Ciudad - Provincia:</strong> <?= esc($direccion->ciudad) ?>, <?= esc($direccion->provincia) ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Código Postal:</strong> <?= esc($direccion->codigo_postal) ?>
                                        <br>
                                        <strong>Teléfono:</strong> <?= esc($direccion->telefono) ?>
                                    </p>
                                </div>
                                <!-- Columna de botones de acción (12 en mobile, 3 en desktop) -->
                                <div class="col-12 col-md-2 mt-3 mt-md-0">
                                    <a href="<?= site_url('cliente/direcciones/editar/' . $direccion->id) ?>" class="btn btn-sm btn-primary me-2" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('cliente/direcciones/eliminar/' . $direccion->id) ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta dirección?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>


                </ul>
            <?php else: ?>
                <p>No tienes direcciones registradas.</p>
            <?php endif; ?>
            <!-- Botón para agregar una nueva dirección -->
            <a href="<?= site_url('cliente/direcciones/crear') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Agregar Nueva Dirección
            </a>
        </div>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>