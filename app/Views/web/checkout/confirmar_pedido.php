<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: se muestran alertas de error o éxito -->
    <div class="alert-info text-center">
        <?= session()->has('error') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <header class="mb-4">
        <h1 class="mb-2 text-white">Confirmar Pedido</h1>
        <p class="text-white">Revisa el resumen de tu pedido antes de confirmar.</p>
    </header>

    <div class="row">
        <!-- Resumen de productos -->
        <div class="col-md-8">
            <h3 class="text-white-50">Productos</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="align-middle">
                        <tr class="text-center">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $item): ?>
                                <tr class="text-center">
                                    <td><?= esc($item['name']) ?></td>
                                    <td><?= esc($item['qty']) ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay productos en el carrito.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="align-middle">
                        <tr class="text-center">
                            <th colspan="3" class="text-end">Total:</th>
                            <th>$<?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Dirección seleccionada -->
        <div class="col-md-4">
            <h3 class="text-white-50">Dirección de Envío</h3>
            <div class="card">
                <div class="card-body">
                    <p><strong><?= esc($direccion->nombre_destinatario) ?></strong></p>
                    <p><?= esc($direccion->calle) ?> <?= esc($direccion->numero) ?></p>
                    <?php if (!empty($direccion->piso) || !empty($direccion->departamento)) : ?>
                        <p>Piso: <?= esc($direccion->piso) ?> - Departamento: <?= esc($direccion->departamento) ?></p>
                    <?php endif; ?>
                    <p><?= esc($direccion->ciudad) ?>, <?= esc($direccion->provincia) ?></p>
                    <p>Código Postal: <?= esc($direccion->codigo_postal) ?></p>
                    <p>Teléfono: <?= esc($direccion->telefono) ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Botón para confirmar el pedido -->
    <div class="text-center mt-4">
        <form action="<?= site_url('checkout/finalizarCompra') ?>" method="post">
            <input type="hidden" name="direccion_id" value="<?= esc($direccion->id) ?>">
            <button type="submit" class="btn btn-accion btn-lg" style="background: #B71C1C">Realizar Pedido</button>
        </form>
    </div>
</main>

<?= view("layouts/footer-cliente") ?>