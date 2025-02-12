<!-- Contenedor principal para la vista de detalle del producto -->
<section class="container py-5 main-content">

    <!-- Tarjeta para la presentación del producto -->
    <section class="card mt-2 p-4" id="fondo-card-previsualizacion-producto">
        <!-- Título del producto -->
        <div class="mb-4">
            <h1 class="fs-1"><?= esc($producto->nombre) ?></h1>
        </div>

        <!-- Sección principal: Carrusel de imágenes y detalles principales -->
        <div class="row">
            <!-- Columna para el carrusel de imágenes -->
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <div id="productCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Marcar el primer item como activo
                        $active = 'active';
                        foreach ($producto->imagenes as $imagen): ?>
                            <div class="carousel-item <?= $active ?>">
                                <img src="<?= base_url($imagen->ruta_imagen) ?>" class="d-block w-100 rounded" alt="<?= esc($producto->nombre) ?>">
                            </div>
                            <?php $active = ''; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>

            <!-- Columna para detalles principales y acciones -->
            <div class="col-12 col-lg-5">
                <div class="d-flex flex-column h-100 justify-content-between">
                    <!-- Detalles básicos: precio, stock, etc. -->
                    <div class="p-3">
                        <p class="h4">Precio: <span class="fw-bold">$ <?= esc($producto->precio) ?></span></p>
                        <p class="h5">
                            Unidades disponibles:
                            <?php if ($producto->stock < 9 && $producto->stock > 1): ?>
                                <span class="text-danger fw-bold">¡Últimas <?= esc($producto->stock) ?> unidades!</span>
                            <?php elseif ($producto->stock == 1): ?>
                                <span class="text-danger fw-bold">¡Última unidad!</span>
                            <?php else: ?>
                                <span class="fw-bold"><?= esc($producto->stock) ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <!-- Botones de acción: según si el usuario está logueado o no -->
                    <div class="row row-cols-1 g-3 mx-3">
                        <?php if (session()->get('usuario')->rol == 'administrador'): ?>
                            <div class="col">
                                <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning w-100 disabled">
                                    Añadir al carrito
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-primary w-100 disabled">
                                    Comprar ahora
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-info w-100 disabled">
                                    Consultar
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Galería adicional (miniaturas) -->
                    <div id="galeria" class="mt-4">
                        <h5>Galería:</h5>
                        <div class="row g-2">
                            <?php foreach ($producto->imagenes as $imagen): ?>
                                <div class="col-4">
                                    <img src="<?= base_url($imagen->ruta_imagen) ?>" class="img-thumbnail" alt="Imagen del producto">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de detalles extendidos -->
        <div class="mt-5">
            <h2 class="fs-2">Detalles</h2>
        </div>

        <!-- Tabla con información extendida -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <tbody class="table-group-divider">
                    <tr>
                        <td>Producto</td>
                        <td><?= esc($producto->nombre) ?></td>
                    </tr>
                    <tr>
                        <td>Descripción</td>
                        <td><?= esc($producto->descripcion) ?></td>
                    </tr>
                    <tr>
                        <td>Marca</td>
                        <td><?= esc($producto->marca_nombre) ?></td>
                    </tr>
                    <tr>
                        <td>Modelo</td>
                        <td><?= esc($producto->modelo) ?></td>
                    </tr>
                    <tr>
                        <td>Peso</td>
                        <td><?= esc($producto->peso) ?></td>
                    </tr>
                    <tr>
                        <td>Dimensiones</td>
                        <td><?= esc($producto->dimensiones) ?></td>
                    </tr>
                    <tr>
                        <td>Material</td>
                        <td><?= esc($producto->material) ?></td>
                    </tr>
                    <tr>
                        <td>Colores</td>
                        <td><?= esc($producto->color) ?></td>
                    </tr>
                    <tr>
                        <td>Categoría</td>
                        <td><?= esc($producto->categoria_nombre) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

</section>

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