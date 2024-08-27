<section class="container card mt-2 p-4">

    <h1 class="text-center mb-4">Dirección de Envío</h1>

    <?= form_open('carrito/finalizarCompra', ['class' => 'row g-3']) ?>

    <div class="col-md-8">
        <label for="calle" class="form-label">Calle:</label>
        <input type="text" class="form-control" id="calle" name="calle" value="<?= old('calle') ?>" required>
    </div>

    <div class="col-md-4">
        <label for="numero" class="form-label">Número/Altura:</label>
        <input type="text" class="form-control" id="numero" name="numero" value="<?= old('numero') ?>" required>
    </div>

    <div class="col-md-6">
        <label for="departamento" class="form-label">Piso/Departamento (opcional):</label>
        <input type="text" class="form-control" id="departamento" name="departamento" value="<?= old('departamento') ?>">
    </div>

    <div class="col-md-6">
        <label for="barrio" class="form-label">Barrio:</label>
        <input type="text" class="form-control" id="barrio" name="barrio" value="<?= old('barrio') ?>" required>
    </div>

    <div class="col-md-6">
        <label for="ciudad" class="form-label">Ciudad:</label>
        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= old('ciudad') ?>" required>
    </div>

    <div class="col-md-6">
        <label for="provincia" class="form-label">Provincia:</label>
        <input type="text" class="form-control" id="provincia" name="provincia" value="<?= old('provincia') ?>" required>
    </div>

    <div class="col-md-4">
        <label for="codigo_postal" class="form-label">Código Postal:</label>
        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?= old('codigo_postal') ?>" required>
    </div>

    <div class="col-12">
        <label for="observaciones" class="form-label">Observaciones de envío:</label>
        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?= old('observaciones') ?></textarea>
    </div>

    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary mt-3">Finalizar Compra</button>
    </div>

    <?= form_close() ?>

    <h2 class="mt-4">Resumen de la Compra</h2>

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
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tfoot>
    </table>
</section>
