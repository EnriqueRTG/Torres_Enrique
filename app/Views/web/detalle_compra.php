<div class="container mt-3">
    <h1>Detalles de la Compra</h1>

    <div class="card">
        <div class="card-header">
            <h2>Orden #<?= $orden->id ?></h2>
            <p>Fecha: <?= $orden->fecha_creacion ?></p> 
            <p>Estado: <?= $orden->estado ?></p>
        </div>
        <div class="card-body">
            <h3>Dirección de Envío</h3>
            

            <h3>Productos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detallesOrden as $detalle): ?>
                        <tr>
                            <td><?= $detalle->nombre_producto ?></td> 
                            <td><?= $detalle->cantidad ?></td>
                            <td>$<?= number_format($detalle->precio, 2) ?></td>
                            <td>$<?= number_format($detalle->cantidad * $detalle->precio, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>$<?= number_format($orden->total, 2) ?></strong></td> 
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end"> 
                <a href="<?= base_url('compras/descargar/' . $orden->id) ?>" class="btn btn-secondary me-2">Descargar Orden</a>
                <?php if ($orden->estado == 'procesada'): ?> 
                    <a href="<?= base_url('compras/descargar_factura/' . $orden->id) ?>" class="btn btn-success">Descargar Factura</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>