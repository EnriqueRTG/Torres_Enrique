<div class="container mt-3">

    <div class="text-center bg-body">
        <p class="fs-1">Productos de tu Carrito</p>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cartItems != null): ?>
                <?php foreach ($cartItems as $item): ?>
                    <tr data-rowid="<?= $item['rowid'] ?>">
                        <td><?= $item['name'] ?></td>
                        <td>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad('<?= $item['rowid'] ?>', -1)">
                                        -
                                    </button>
                                </div>
                                <input type="text" class="form-control text-center" value="<?= $item['qty'] ?>" min="1" onchange="actualizarCantidad('<?= $item['rowid'] ?>', this.value)">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad('<?= $item['rowid'] ?>', 1)">
                                        +
                                    </button>
                                </div>
                            </div>
                            <span class="stock-message text-danger"></span>
                        </td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                        <td>
                            <a href="<?= base_url('carrito/quitar/' . $item['rowid']) ?>" class="btn btn-danger btn-sm">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center fs-3" colspan="5">El carrito está vacío.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong id="carrito-total">$<?= number_format($total, 2) ?></strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <?php if ($cartItems != null): ?>
        <div class="d-flex justify-content-between mt-3">
            <a href="<?= base_url('carrito/borrar') ?>" class="btn btn-secondary">Limpiar Carrito</a>
            <a href="<?= base_url('carrito/comprar') ?>" class="btn btn-success">Realizar Compra</a>
        </div>
    <?php endif; ?>

</div>

<script>
    function actualizarCantidad(rowid, cambioCantidad) {
        // 1. Obtener la fila y el input de cantidad
        const fila = document.querySelector(`tr[data-rowid="${rowid}"]`);
        const inputCantidad = fila.querySelector('input[type="text"]');

        // 2. Calcular la nueva cantidad
        let nuevaCantidad = parseInt(inputCantidad.value) + cambioCantidad;

        // 3. Validar la nueva cantidad
        if (isNaN(nuevaCantidad) || nuevaCantidad < 1) {
            alert("Por favor, ingresa una cantidad válida.");
            return;
        }

        // 4. Preparar los datos a enviar
        const data = new FormData();
        data.append('rowid', rowid);
        data.append('cantidad', nuevaCantidad);

        // 5. Enviar la solicitud AJAX
        fetch('<?= site_url('web/carrito/actualizar') ?>', {
                method: 'POST',
                body: data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Carrito actualizado con éxito");

                    // 6. Actualizar la vista del carrito
                    // Actualizar el subtotal de la fila
                    const subtotalElement = fila.querySelector('td:nth-child(4)');
                    subtotalElement.textContent = '$' + data.subtotal;

                    // Actualizar el total del carrito
                    const totalElement = document.querySelector('#carrito-total');
                    totalElement.textContent = '$' + data.total;

                    // Actualizar el valor del input de cantidad
                    inputCantidad.value = nuevaCantidad;

                    // Verificar y mostrar mensaje de stock
                    const stockMessageElement = fila.querySelector('.stock-message');
                    if (data.hasOwnProperty('stockMessage')) {
                        stockMessageElement.textContent = data.stockMessage;
                    } else {
                        stockMessageElement.textContent = '';
                    }

                } else {
                    // Manejar errores si la actualización falla
                    console.error("Error al actualizar el carrito:", data.message || "Error desconocido");
                    alert("Hubo un error al actualizar el carrito. " + (data.message ? data.message : "Por favor, inténtalo de nuevo."));
                }
            })
            .catch(error => {
                console.error("Error en la solicitud AJAX:", error);
                alert("Hubo un error al comunicarse con el servidor. Por favor, inténtalo de nuevo.");
            });
    }

    function mostrarMensajeCarrito(mensaje, tipo) {
        const mensajeCarrito = document.getElementById('mensaje-carrito');
        mensajeCarrito.textContent = mensaje;
        mensajeCarrito.classList.remove('alert-success', 'alert-danger');
        mensajeCarrito.classList.add('alert-' + tipo);
        mensajeCarrito.style.display = 'block';

        setTimeout(() => {
            mensajeCarrito.style.display = 'none';
        }, 5000);
    }
</script>