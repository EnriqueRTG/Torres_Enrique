<section class="container mt-3 p-2">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <div class="bg-white text-center">
        <p class="fs-1">Mis Compras</p>
    </div>


    <?php if ($ordenes): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Número de Orden</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordenes as $orden): ?>
                    <tr>
                        <td><?= $orden->id ?></td>
                        <td><?= $orden->fecha_creacion ?></td>
                        <td>$<?= number_format($orden->total, 2) ?></td>
                        <td><?= $orden->estado ?></td>
                        <td>
                            <a href="<?= base_url('compras/detalle/' . $orden->id) ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                            <a href="<?= base_url('compras/descargar/' . $orden->id) ?>" class="btn btn-secondary btn-sm">Descargar Orden</a>
                            <?php if ($orden->estado == 'procesada'): ?>
                                <a href="<?= base_url('compras/descargar_factura/' . $orden->id) ?>" class="btn btn-success btn-sm">Descargar Factura</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aún no has realizado ninguna compra.</p>
    <?php endif; ?>
</section>