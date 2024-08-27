<?php if (!session()->has('usuario')): ?>
    <div class="alert alert-warning text-center" role="alert">
        Debes <a href="<?= base_url() ?><?= route_to('login') ?>" class="alert-link">iniciar sesión</a> para realizar compras.
    </div>
<?php endif; ?>

<div class="container mx-auto my-5 row">

    <?php if (!$productos) : ?>
        <div class="container">
            <div class="">
                <h2 class="text-center">
                    No hay Productos
                </h2>
            </div>
        </div>
    <?php else : ?>

        <button class="btn btn-secondary mb-3 d-md-none mx-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtrosOffcanvas" aria-controls="filtrosOffcanvas">
            Mostrar Filtros
        </button>

        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="filtrosOffcanvas" aria-labelledby="filtrosOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="filtrosOffcanvasLabel">Filtros</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <?= $this->include('partials/filtros') ?>
            </div>
        </div>

        <div class="d-none d-md-block col-md-2" id="filtrosContainer">
            <?= $this->include('partials/filtros') ?>
        </div>

        <div class="col-md-10 mx-auto">
            <div class="row row-cols-1 row-cols-lg-4 row-cols-md-3">

                <?php foreach ($productos as $producto) : ?>
                    <div class="col mb-3">
                        <div class="card h-100 card-producto">
                            <!-- Imagen del Producto -->
                            <a href="<?= url_to('producto', $producto->id) ?>" class="position-relative">
                                <img class="card-img-top" src="<?= base_url($producto->imagen_url) ?>" alt="<?= $producto->nombre ?>" />
                                <div class="overlay d-flex justify-content-center align-items-center">
                                    <button class="btn btn-info">Ver Detalles</button>
                                </div>
                            </a>
                            <!-- Detalles del Producto -->
                            <div class="card-body ">
                                <div class="text-center">
                                    <!-- Nombre del Producto-->
                                    <h5 class="fw-bolder"><?= $producto->nombre ?></h5>
                                    <!-- Marca del Producto -->
                                    <p class="card-text"><?= $producto->nombre_marca ?></p>
                                    <!-- Precio del Producto -->
                                    <p class="fw-bold">$ <?= $producto->precio ?></p>
                                </div>
                            </div>
                            <!-- Acciones -->
                            <div class="card-footer border-top-0 bg-transparent pt-0">
                                <div class="text-center d-flex gap-2 justify-content-center row">
                                    <?php if (session()->get('usuario')) : ?>
                                        <!-- Stock Disponible -->
                                        <?php if ($producto->stock < 9 & $producto->stock > 1) : ?>
                                            <span class="text-danger font-weight-bold">¡Últimas <?= $producto->stock ?> unidades!</span>
                                        <?php elseif ($producto->stock == 1) : ?>
                                            <span class="text-danger font-weight-bold">¡Última unidad!</span>
                                        <?php endif; ?>
                                        <div class="mb-2">
                                            <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning">
                                                Agregar al Carrito
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>

    <?php endif  ?>

</div>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>Try scrolling the rest of the page to see this option in action.</p>
        <p>Subtotal (sin envío) :</p>
    </div>
</div>

<style>
    .card-producto:hover {
        background-color: #f0f0f0 !important;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
        transform: scale(1.05);
    }

    .card-producto:hover .card-producto-title {
        color: #007bff !important;
    }

    .card-producto .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo semi-transparente */
        opacity: 0;
        /* Oculto por defecto */
        transition: opacity 0.3s ease;
        /* Transición suave */
    }

    .card-producto:hover .overlay {
        opacity: 1;
        /* Visible al pasar el mouse */
    }

    .card-producto .overlay button {
        display: none;
        /* Botón oculto por defecto */
    }

    .card-producto:hover .overlay button {
        display: block;
        /* Botón visible al pasar el mouse */
    }
</style>

<!-- <script>
    function actualizarOffcanvas(response) {
        var offcanvasBody = $('#offcanvasWithBothOptions .offcanvas-body');

        // Limpiar el contenido anterior del offcanvas (opcional)
        // offcanvasBody.empty(); 

        // Verificar si carritoProductos existe y es un array
        if (response.carritoProductos && Array.isArray(response.carritoProductos)) {
            // Si el carrito está vacío, mostrar un mensaje
            if (response.carritoProductos.length === 0) {
                offcanvasBody.html('<p>Tu carrito está vacío.</p>');
            } else {
                // Agregar los productos del carrito al offcanvas
                var productosHTML = '';
                for (var i = 0; i < response.carritoProductos.length; i++) {
                    var producto = response.carritoProductos[i];
                    productosHTML += `
                    <div class="carrito-producto">
                        <p>Producto: ${producto.nombre}</p>
                        <p>Precio: $${producto.precio}</p>
                        <p>Cantidad: ${producto.cantidad}</p>
                        <button class="btn btn-danger btn-sm eliminar-producto" data-producto-id="${producto.id}">Eliminar</button> 
                    </div>
                `;
                }
                offcanvasBody.append(productosHTML);

                // Agregar el botón "Iniciar compra"
                var botonIniciarCompra = `
                <a href="<?= route_to('carrito') ?>" class="btn btn-primary mt-3">Iniciar compra</a>
            `;
                offcanvasBody.append(botonIniciarCompra);

                // Manejar el evento de clic en los botones "Eliminar" (si es necesario)
                $('.eliminar-producto').click(function() {
                    var productoId = $(this).data('producto-id');
                    eliminarProductoDelCarrito(productoId);
                });
            }

            // Actualizar el subtotal
            $('#offcanvas-subtotal').text('$' + response.subtotal);
        } else {
            // Manejar el caso en que carritoProductos no existe o no es un array
            console.error("Error: carritoProductos no es un array válido en la respuesta del servidor.");
            // Puedes mostrar un mensaje de error al usuario aquí si lo deseas
        }
    }
</script> -->