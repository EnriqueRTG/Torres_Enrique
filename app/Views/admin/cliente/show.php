<!-- Vista parcial: Header Admin -->
<?= view("layouts/header-admin", ['titulo' => "Perfil del Cliente: " . esc($cliente->nombre)]) ?>

<!-- Barra de navegación Admin -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión (errores o confirmaciones) -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta de información del cliente -->
    <section class="card mb-4">
        <!-- Encabezado de la tarjeta -->
        <header class="card-header">
            <h2 class="mb-0">Perfil del Cliente</h2>
        </header>

        <!-- Cuerpo de la tarjeta -->
        <div class="card-body">
            <div class="row">
                <!-- Datos básicos del cliente -->
                <div class="col-md-4">
                    <p><strong>Nombre:</strong> <?= esc($cliente->nombre) ?></p>
                    <p><strong>Apellido:</strong> <?= esc($cliente->apellido) ?></p>
                    <p><strong>Email:</strong> <?= esc($cliente->email) ?></p>
                    <p>
                        <strong>Estado:</strong>
                        <?php if ($cliente->estado === 'activo'): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactivo</span>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Direcciones u otra información adicional -->
                <div class="col-md-8">
                    <h5>Direcciones de Envío</h5>
                    <?php if (!empty($direcciones)): ?>
                        <ul class="list-group">
                            <?php foreach ($direcciones as $direccion): ?>
                                <li class="list-group-item">
                                    <p class="mb-1">
                                        <strong>Calle y Número:</strong>
                                        <?= esc($direccion->calle) ?>, <?= esc($direccion->numero) ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Ciudad - Provincia:</strong>
                                        <?= esc($direccion->ciudad) ?> - <?= esc($direccion->provincia) ?>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No se han registrado direcciones.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Vista parcial: Footer Admin -->
<?= view("layouts/footer-admin") ?>