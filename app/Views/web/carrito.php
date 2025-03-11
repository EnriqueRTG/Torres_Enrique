<!-- Vista: app/Views/web/carrito.php -->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar (para la parte pública del sitio) -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal: Catálogo del Carrito -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div id="flashMessage" class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: navegación jerárquica -->
    <nav aria-label="breadcrumb" class="my-3">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2 text-white">Carrito</h1>
        <p class="lead text-white">Listado de productos agregados a tu <strong>Carrito de Compras</strong></p>
    </header>

    <!-- Tabla de productos del carrito -->
    <div class="table-responsive">
        <table class="table table-striped">
            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-center align-middle">
                    <th scope="col">Imagen</th>
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
                        <tr class="text-center align-middle" data-rowid="<?= esc($item['rowid']) ?>">
                            <!-- Imagen del producto -->
                            <td>
                                <img src="<?= base_url($item['image'] ?? 'uploads/productos/no-image.png') ?>"
                                    alt="<?= esc($item['name']) ?>"
                                    class="img-thumbnail me-2"
                                    style="width: 50px; height: auto;">
                            </td>
                            <!-- Nombre del producto -->
                            <td><?= esc($item['name']) ?></td>
                            <!-- Cantidad con controles de incremento y decremento -->
                            <td style="min-width: 120px;">
                                <!-- Dentro del <td> de la cantidad -->
                                <div class="input-group input-group-sm flex-nowrap">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidadDelta('<?= esc($item['rowid']) ?>', -1)">-</button>
                                    <!-- Se usa onchange para llamar a la función directa -->
                                    <input type="number" class="form-control text-center cantidad-input"
                                        value="<?= esc($item['qty']) ?>" min="1"
                                        onchange="actualizarCantidadDirect('<?= esc($item['rowid']) ?>', this.value)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidadDelta('<?= esc($item['rowid']) ?>', 1)">+</button>
                                </div>

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
                        <td colspan="6" class="text-center fs-3">El carrito está vacío.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <!-- Pie de la tabla con el total -->
            <tfoot>
                <tr class="text-center align-middle">
                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                    <td><strong id="carrito-total">$<?= number_format($total, 2) ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Controles adicionales (acciones para el carrito) -->
    <?php if (!empty($cartItems)): ?>
        <div class="d-flex justify-content-between mt-3">
            <a href="<?= base_url('carrito/borrar') ?>" class="btn btn-vaciar-carrito">Limpiar Carrito</a>
            <a href="<?= base_url('checkout/seleccionarDireccion') ?>" class="btn btn-finalizar-compra">Realizar Compra</a>
        </div>
    <?php endif; ?>
</main>

<?= view("layouts/footer-cliente", ['titulo' => $titulo]) ?>

<!-- Estilos personalizados para mejorar la visibilidad en móviles -->
<style>
    @media (max-width: 576px) {

        /* Aumenta el tamaño del input de cantidad y sus botones en mobile */
        .cantidad-input {
            font-size: 1.1rem;
            padding: 0.5rem;
            width: 70px;
        }

        .input-group .btn {
            font-size: 1rem;
            padding: 0.4rem 0.6rem;
        }
    }
</style>

<!-- Scripts: Funciones para actualizar cantidades y mostrar mensajes -->
<script>
    // Función llamada cuando se cambia manualmente el valor del input
    function actualizarCantidadDirect(rowid, nuevoValor) {
        const nuevaCantidad = parseInt(nuevoValor);
        actualizarCantidadAJAX(rowid, nuevaCantidad);
    }

    // Función llamada cuando se hace clic en los botones, que suma o resta un delta
    function actualizarCantidadDelta(rowid, delta) {
        const fila = document.querySelector(`tr[data-rowid="${rowid}"]`);
        const inputCantidad = fila.querySelector('input[type="number"]');
        const cantidadActual = parseInt(inputCantidad.value);
        const nuevaCantidad = cantidadActual + parseInt(delta);
        actualizarCantidadAJAX(rowid, nuevaCantidad);
    }

    // Función central que envía la solicitud AJAX con la cantidad final
    function actualizarCantidadAJAX(rowid, nuevaCantidad) {
        const dataForm = new FormData();
        dataForm.append('rowid', rowid);
        dataForm.append('cantidad', nuevaCantidad);

        fetch('<?= site_url('web/carrito/actualizar') ?>', {
                method: 'POST',
                body: dataForm
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    mostrarMensajeFlash(data.message);
                    // Recargar la página en 1.5 segundos para actualizar el carrito completo
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
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

    // Función para actualizar el contenedor de mensajes (flash)
    function mostrarMensajeFlash(texto, tipo = "success") {
        const flashEl = document.getElementById("flashMessage");
        flashEl.className = `alert alert-${tipo} alert-dismissible fade show text-center`;
        flashEl.innerHTML = `
            ${texto}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `;
        flashEl.style.display = "block";

        setTimeout(() => {
            flashEl.classList.add("fade");
            setTimeout(() => {
                flashEl.style.display = "none";
                flashEl.classList.remove("fade");
            }, 500);
        }, 3000);
    }
</script>