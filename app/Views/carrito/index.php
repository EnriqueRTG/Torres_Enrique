<h1>Tu carrito de compras</h1>

<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($carrito as $item): ?>
            <tr>
                <td><?= $item['nombre_producto'] ?></td>
                <td><?= $item['precio'] ?></td>
                <td>
                    <form method="post" action="<?= base_url('carrito/actualizar') ?>">
                        <input type="hidden" name="producto_id" value="<?= $item['id_producto'] ?>">
                        <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1">
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
                <td><?= $item['precio'] * $item['cantidad'] ?></td>
                <td>
                    <form method="post" action="<?= base_url('carrito/eliminar') ?>">
                        <input type="hidden" name="producto_id" value="<?= $item['id_producto'] ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('carrito/finalizar') ?>">Finalizar compra</a>
