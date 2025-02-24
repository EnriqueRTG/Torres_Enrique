    <!-- Vista: Perfil del Cliente -->
    <?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

    <!-- Se incluye el partial del Navbar -->
    <?= view("partials/_navbar") ?>

    <!-- Contenido principal: Perfil del Cliente -->
    <main class="container my-3 main-content">
        <!-- Mensajes de sesión: alertas de error o éxito -->
        <div class="alert-info text-center">
            <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
        </div>

        <!-- Breadcrumb de navegación -->
        <nav aria-label="breadcrumb">
            <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
        </nav>

        <!-- Tarjeta de información del perfil -->
        <section class="card mb-4">
            <!-- Cabecera de la tarjeta: título del perfil -->
            <div class="card-header">
                <h2 class="mb-0">Mi Perfil</h2>
            </div>

            <!-- Cuerpo de la tarjeta: datos del cliente -->
            <div class="card-body">
                <div class="row">
                    <!-- Datos básicos del cliente -->
                    <div class="col-md-4">
                        <p><strong>Nombre:</strong> <?= esc($cliente->nombre) ?></p>
                        <p><strong>Apellido:</strong> <?= esc($cliente->apellido) ?></p>
                        <p><strong>Email:</strong> <?= esc($cliente->email) ?></p>
                        <!-- Puedes agregar más campos según sea necesario -->
                    </div>
                    <!-- Direcciones de envío -->
                    <div class="col-md-8">
                        <h5>Direcciones de Envío</h5>
                        <?php if (!empty($direcciones)): ?>
                            <ul class="list-group">
                                <?php foreach ($direcciones as $direccion): ?>
                                    <li class="list-group-item my-3">
                                        <!-- Sección de detalles de la dirección -->
                                        <div>
                                            <p class="mb-1">
                                                <strong>Calle y Número:</strong> <?= esc($direccion->calle) ?>, <?= esc($direccion->numero) ?>
                                            </p>
                                            <p class="mb-1">
                                                <strong>Ciudad - Provincia:</strong> <?= esc($direccion->ciudad) ?> - <?= esc($direccion->provincia) ?>
                                            </p>
                                        </div>
                                        
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        <?php else: ?>
                            <p>No tienes direcciones registradas.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Pie de la tarjeta: botón para editar perfil -->
            <div class="card-footer text-end">
                <a href="<?= site_url('cliente/perfil/editar') ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Editar Perfil
                </a>
            </div>
        </section>
    </main>

    <?= view("layouts/footer-cliente") ?>