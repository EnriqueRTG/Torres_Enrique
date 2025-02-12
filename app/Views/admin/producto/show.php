<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal: se utiliza <main> para delimitar el contenido principal -->
<main class="container py-5 main-content" tabindex="0">

    <!-- Mensajes de sesión: muestra errores o notificaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: navegación jerárquica -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta de presentación del producto -->
    <section class="card mt-2 p-4" id="fondo-card-previsualizacion-producto">
        <!-- Encabezado: Título del producto -->
        <header class="mb-4">
            <h1 class="fs-1"><?= esc($producto->nombre) ?></h1>
        </header>

        <!-- Sección principal: Carrusel de imágenes y detalles básicos -->
        <div class="row">
            <!-- Columna izquierda: Carrusel de imágenes principal -->
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <!-- Carrusel principal: se aplica la clase "square-carousel" para mantener proporción cuadrada -->
                <div id="productCarousel" class="carousel slide carousel-dark square-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Se marca el primer item como activo
                        $active = 'active';
                        foreach ($producto->imagenes as $index => $imagen): ?>
                            <div class="carousel-item <?= $active ?>">
                                <!-- La imagen se adapta al contenedor con object-fit: cover -->
                                <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                    class="d-block w-100 rounded view-fullscreen"
                                    alt="<?= esc($producto->nombre) ?>"
                                    data-index="<?= $index ?>"
                                    style="cursor: pointer;">
                            </div>
                        <?php $active = '';
                        endforeach; ?>
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

            <!-- Columna derecha: Detalles básicos y acciones -->
            <div class="col-12 col-lg-5">
                <div class="d-flex flex-column h-100 justify-content-between">
                    <!-- Información básica del producto -->
                    <div class="p-3">
                        <p class="h4">
                            Precio: <span class="fw-bold">$ <?= esc($producto->precio) ?></span>
                        </p>
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

                    <!-- Botones de acción (solo visibles para administradores) -->
                    <?php if (session()->get('usuario')->rol == 'administrador'): ?>
                        <div class="row row-cols-1 g-3 mx-3">
                            <div class="col">
                                <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning w-100 disabled" title="Añadir al carrito">
                                    Añadir al carrito
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-primary w-100 disabled" title="Comprar ahora">
                                    Comprar ahora
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-info w-100 disabled" title="Consultar">
                                    Consultar
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Sección: Galería de miniaturas con Swiper -->
                    <div id="galeria" class="mt-4">
                        <h5>Galería:</h5>
                        <!-- Contenedor del Swiper (la clase "mySwiper" es utilizada en la inicialización JS) -->
                        <div class="swiper-container mySwiper">
                            <div class="swiper-wrapper ">
                                <?php foreach ($producto->imagenes as $index => $imagen): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                            class="img-thumbnail view-fullscreen"
                                            alt="Imagen del producto"
                                            data-index="<?= $index ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Botones de navegación dentro del Swiper -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <!-- Paginación del Swiper -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de detalles extendidos -->
        <section class="mt-5">
            <h2 class="fs-2">Detalles</h2>
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

    <!-- Botones de acciones principales -->
    <div class="text-center pt-5 d-flex justify-content-evenly">
        <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary border-3 fw-bolder fw-bold fs-4" title="Volver">
            Volver <i class="bi bi-arrow-return-left"></i>
        </a>
        <a href="<?= base_url('admin/producto/editar/' . $producto->id) ?>" class="btn btn-outline-warning border-3 fw-bolder fw-bold fs-4" title="Editar">
            Editar <i class="bi bi-pencil-square"></i>
        </a>
        <a href="#" class="btn btn-outline-danger border-3 fw-bolder fw-bold fs-4" data-bs-toggle="modal" data-bs-target="#confirmarEliminacionModal" title="Eliminar">
            Eliminar <i class="bi bi-trash"></i>
        </a>
    </div>

    <!-- Modal para confirmar la eliminación del producto -->
    <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarEliminacionModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <p class="text-wrap">
                        ¿Estás seguro de que quieres eliminar el producto
                        <span class="fw-bolder"><?= esc($producto->nombre) ?></span>?
                    </p>
                </div>
                <!-- Pie del modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="<?= base_url('admin/producto/delete/' . $producto->id) ?>" method="POST" id="eliminarProductoForm">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para vista detallada de imágenes (no fullscreen) -->
    <div class="modal fade" id="fullscreenImageModal" tabindex="-1" aria-labelledby="fullscreenImageModalLabel" aria-hidden="true" data-bs-focus="false">
        <!-- Usamos modal-dialog-centered y modal-lg para que el modal no ocupe el 100% de la pantalla -->
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <!-- Modal con fondo translúcido -->
            <div class="modal-content translucent-modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="fullscreenImageModalLabel">Vista de Imagen</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- Cuerpo del modal: Carrusel de imágenes -->
                <div class="modal-body p-0">
                    <div id="fullscreenCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $active = 'active';
                            foreach ($producto->imagenes as $index => $imagen): ?>
                                <div class="carousel-item <?= $active ?>" data-index="<?= $index ?>">
                                    <img src="<?= base_url($imagen->ruta_imagen) ?>" class="d-block w-100" alt="<?= esc($producto->nombre) ?>">
                                </div>
                                <?php $active = ''; ?>
                            <?php endforeach; ?>
                        </div>
                        <!-- Controles del carrusel en el modal -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#fullscreenCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#fullscreenCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para el modal fullscreen y la inicialización de Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Evento para vista fullscreen: al hacer clic en cualquier imagen con la clase "view-fullscreen"
        document.querySelectorAll('.view-fullscreen').forEach(function(el) {
            el.addEventListener('click', function() {
                // Quita el foco del elemento clickeado
                el.blur();

                // Obtiene el índice de la imagen desde su atributo data-index
                var idx = el.getAttribute('data-index');
                var modalEl = document.getElementById('fullscreenImageModal');
                // Obtiene o crea la instancia del modal
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

                // Posiciona el carrusel en la imagen clickeada
                var carouselEl = document.getElementById('fullscreenCarousel');
                var carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
                carousel.to(parseInt(idx));
            });
        });

        // Antes de ocultar el modal fullscreen, mueve el foco fuera de él (al elemento <main>)
        var fullscreenModal = document.getElementById('fullscreenImageModal');
        fullscreenModal.addEventListener('hide.bs.modal', function() {
            if (fullscreenModal.contains(document.activeElement)) {
                var safeElement = document.querySelector('main');
                if (safeElement) {
                    safeElement.focus();
                } else {
                    document.activeElement.blur();
                }
            }
        });

        // Inicialización de Swiper para la galería de miniaturas
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 10
                }
            }
        });
    });
</script>