<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<div class="container my-4">
    <!-- Breadcrumb -->
    <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>

    <h1 class="mb-4 text-center text-white"><?= esc($titulo) ?></h1>

    <!-- Información General de la Orden -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Resumen de la Orden #<?= esc($orden->id) ?></h3>
        </div>
        <div class="card-body">
            <p><strong>Total:</strong> $<?= number_format($orden->total, 2) ?></p>
            <p><strong>Estado:</strong> <?= ucfirst(esc($orden->estado)) ?></p>
            <p><strong>Fecha de Creación:</strong> <?= date("d/m/Y H:i", strtotime($orden->created_at)) ?></p>
        </div>
    </div>

    <!-- Detalle de la Dirección de Envío -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Dirección de Envío</h3>
        </div>
        <div class="card-body">
            <p><strong><?= esc($orden->nombre_destinatario ?? '') ?></strong></p>
            <p><?= esc($orden->calle ?? '') ?> <?= esc($orden->numero ?? '') ?></p>
            <?php if (!empty($orden->piso) || !empty($orden->departamento)) : ?>
                <p>Piso: <?= esc($orden->piso) ?> - Dpto: <?= esc($orden->departamento) ?></p>
            <?php endif; ?>
            <p><?= esc($orden->ciudad) ?>, <?= esc($orden->provincia) ?></p>
            <p>Código Postal: <?= esc($orden->codigo_postal) ?></p>
            <p>Teléfono: <?= esc($orden->telefono) ?></p>
        </div>
    </div>

    <!-- Detalle de Productos de la Orden -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Productos</h3>
        </div>
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
    </div>

    <!-- Botón de regreso -->
    <div class="text-center">
        <a href="<?= site_url('cliente/pedidos') ?>" class="btn btn-secondary">Volver a Mis Pedidos</a>
    </div>
</div>

<?= view("layouts/footer-cliente") ?>