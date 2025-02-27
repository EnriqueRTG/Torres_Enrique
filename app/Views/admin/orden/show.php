<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>
<?= view("partials/_navbar-admin") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <header class="mb-4">
        <h1 class="text-center"><?= esc($titulo) ?></h1>
    </header>

    <!-- Resumen de la Orden -->
    <section class="card mb-4">
        <header class="card-header">
            <h3>Resumen de la Orden #<?= esc($orden->id) ?></h3>
        </header>
        <div class="card-body">
            <p><strong>Total:</strong> $<?= number_format($orden->total, 2) ?></p>
            <p><strong>Estado:</strong> <?= ucfirst(esc($orden->estado)) ?></p>
            <p><strong>Fecha de Creación:</strong> <?= date("d/m/Y H:i", strtotime($orden->created_at)) ?></p>
        </div>
    </section>

    <!-- Dirección de Envío -->
    <section class="card mb-4">
        <header class="card-header">
            <h3>Dirección de Envío</h3>
        </header>
        <div class="card-body">
            <p><strong><?= esc($orden->nombre_destinatario) ?></strong></p>
            <p><?= esc($orden->calle) ?> <?= esc($orden->numero) ?></p>
            <?php if (!empty($orden->piso) || !empty($orden->departamento)) : ?>
                <p>Piso: <?= esc($orden->piso) ?> - Dpto: <?= esc($orden->departamento) ?></p>
            <?php endif; ?>
            <p><?= esc($orden->ciudad) ?>, <?= esc($orden->provincia) ?></p>
            <p><strong>Código Postal:</strong> <?= esc($orden->codigo_postal) ?></p>
            <p><strong>Teléfono:</strong> <?= esc($orden->telefono) ?></p>
        </div>
    </section>

    <!-- Detalle de Productos de la Orden -->
    <section class="card mb-4">
        <header class="card-header">
            <h3>Productos</h3>
        </header>
        <div class="card-body">
            <?php if (!empty($orden->detalles)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($orden->detalles as $detalle) : ?>
                                <tr>
                                    <td><?= esc($detalle->nombre_producto) ?></td>
                                    <td><?= esc($detalle->cantidad) ?></td>
                                    <td>$<?= number_format($detalle->precio_unitario, 2) ?></td>
                                    <td>$<?= number_format($detalle->cantidad * $detalle->precio_unitario, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>$<?= number_format($orden->total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No se encontraron detalles para esta orden.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Acciones sobre la Orden -->
    <?php if ($orden->estado === 'pendiente') : ?>
        <section class="text-center mb-4">
            <a href="<?= site_url('admin/ordenes/cancelar/' . $orden->id) ?>" class="btn btn-danger mx-1" title="Cancelar Orden">
                <i class="bi bi-x-circle"></i> Cancelar Orden
            </a>
            <a href="<?= site_url('admin/ordenes/edit/' . $orden->id) ?>" class="btn btn-warning mx-1" title="Modificar Orden">
                <i class="bi bi-pencil-square"></i> Modificar Orden
            </a>
            <a href="<?= site_url('admin/ordenes/completar/' . $orden->id) ?>" class="btn btn-success mx-1" title="Completar Orden">
                <i class="bi bi-check-circle"></i> Completar Orden
            </a>
        </section>
    <?php else: ?>
        <section class="text-center mb-4">
            <p class="text-muted">No hay acciones disponibles para esta orden.</p>
        </section>
    <?php endif; ?>
</main>

<?= view("layouts/footer-admin") ?>
