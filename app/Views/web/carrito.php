<!-- Vista: app/Views/web/carrito.php -->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar (para la parte pública del sitio) -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal: Catálogo del Carrito -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de error o confirmación -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Título principal -->
    <header class="text-center bg-body py-3 mb-4">
        <h1 class="fs-1">Productos de tu Carrito</h1>
    </header>

    <!-- Tabla de productos del carrito -->
    <div class="table-responsive">
        <table class="table table-striped">
            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-center align-middle">
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody>
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <tr data-rowid="<?= esc($item['rowid']) ?>">
                            <!-- Nombre del producto -->
                            <td><?= esc($item['name']) ?></td>
                            <!-- Cantidad con controles de incremento y decremento -->
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad('<?= esc($item['rowid']) ?>', -1)">
                                        -
                                    </button>
                                    <input type="text" class="form-control text-center" value="<?= esc($item['qty']) ?>" min="1" onchange="actualizarCantidad('<?= esc($item['rowid']) ?>', this.value)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidad('<?= esc($item['rowid']) ?>', 1)">
                                        +
                                    </button>
                                </div>
                                <!-- Mensaje de stock (si existe) -->
                                <span class="stock-message text-danger"></span>
                            </td>
                            <!-- Precio Unitario -->
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <!-- Subtotal -->
                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                            <!-- Acciones: botón para eliminar el producto del carrito -->
                            <td>
                                <a href="<?= base_url('carrito/quitar/' . esc($item['rowid'])) ?>" class="btn btn-danger btn-sm">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center fs-3">El carrito está vacío.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <!-- Pie de la tabla con el total -->
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong id="carrito-total">$<?= number_format($total, 2) ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Controles adicionales (acciones para el carrito) -->
    <?php if (!empty($cartItems)): ?>
        <div class="d-flex justify-content-between mt-3">
            <a href="<?= base_url('carrito/borrar') ?>" class="btn btn-secondary">Limpiar Carrito</a>
            <a href="<?= base_url('carrito/comprar') ?>" class="btn btn-success">Realizar Compra</a>
        </div>
    <?php endif; ?>
</main>

<?= view("layouts/footer-cliente", ['titulo' => $titulo]) ?>

<!-- Scripts -->
<script>
    /**
     * Función para actualizar la cantidad de un producto en el carrito.
     * Recibe el identificador de la fila y el cambio en la cantidad.
     * Realiza una solicitud AJAX para actualizar el backend y, de ser exitosa, actualiza la vista.
     * 
     * @param {string} rowid - Identificador único de la fila en el carrito.
     * @param {number|string} cambioCantidad - Cambio en la cantidad (puede ser un número o el valor del input).
     */
    function actualizarCantidad(rowid, cambioCantidad) {
        // 1. Obtener la fila y el input de cantidad
        const fila = document.querySelector(`tr[data-rowid="${rowid}"]`);
        const inputCantidad = fila.querySelector('input[type="text"]');

        // 2. Calcular la nueva cantidad
        let nuevaCantidad = parseInt(inputCantidad.value) + parseInt(cambioCantidad);

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
                    const subtotalElement = fila.querySelector('td:nth-child(4)');
                    subtotalElement.textContent = '$' + data.subtotal;
                    const totalElement = document.querySelector('#carrito-total');
                    totalElement.textContent = '$' + data.total;
                    inputCantidad.value = nuevaCantidad;
                    // Mostrar mensaje de stock si existe
                    const stockMessageElement = fila.querySelector('.stock-message');
                    stockMessageElement.textContent = data.stockMessage || '';
                } else {
                    console.error("Error al actualizar el carrito:", data.message || "Error desconocido");
                    alert("Hubo un error al actualizar el carrito. " + (data.message ? data.message : "Por favor, inténtalo de nuevo."));
                }
            })
            .catch(error => {
                console.error("Error en la solicitud AJAX:", error);
                alert("Hubo un error al comunicarse con el servidor. Por favor, inténtalo de nuevo.");
            });
    }

    /**
     * Función para mostrar un mensaje temporal en el carrito.
     * 
     * @param {string} mensaje - Mensaje a mostrar.
     * @param {string} tipo - Tipo de alerta (por ejemplo, 'success' o 'danger').
     */
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