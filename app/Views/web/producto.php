<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal: se utiliza <main> para delimitar el contenido principal -->
<main class="container my-3 main-content" tabindex="0">

    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div id="flashMessage" class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: navegación jerárquica -->
    <nav aria-label="breadcrumb" class="my-3">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta de presentación del producto -->
    <section class="card mt-2 p-4" id="fondo-card-previsualizacion-producto">
        <!-- Encabezado: Título del producto -->
        <header class="mb-4 text-center">
            <h1 class="fs-1"><?= esc($producto->nombre) ?></h1>
        </header>

        <!-- Sección principal: Carrusel de imágenes y detalles básicos -->
        <div class="row">
            <!-- Columna izquierda: Carrusel de imágenes principal -->
            <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                <!-- Carrusel con proporción cuadrada -->
                <div id="productCarousel" class="carousel slide carousel-dark square-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Marcar el primer item como activo
                        $active = 'active';
                        foreach ($producto->imagenes as $index => $imagen): ?>
                            <div class="carousel-item <?= $active ?>">
                                <!-- Imagen con efecto de vista fullscreen (clic para abrir modal) -->
                                <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                    class="d-block w-100 rounded view-fullscreen"
                                    alt="<?= esc($producto->nombre) ?>"
                                    data-index="<?= $index ?>"
                                    style="cursor: pointer;">
                            </div>
                        <?php
                            $active = '';
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

            <!-- Columna derecha: Detalles básicos y botones de acción -->
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

                    <!-- Ejemplo para usuario no autenticado -->
                    <?php if (!session()->get('usuario')): ?>
                        <div class="row row-cols-1 text-center p-3 text-center">
                            <div class="col">
                                <a href="<?= base_url('contacto?producto=' . urlencode($producto->nombre)) ?>"
                                    class="btn btn-consultar w-50" title="Contactar">
                                    Contactar
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if (session()->get('usuario')->rol == ROL_ADMIN): ?>
                            <!-- Botones inhabilitados para el administrador -->
                            <div class="row row-cols-1 g-3 mx-3 text-center">
                                <div class="col">
                                    <a href="#" class="btn btn-consultar w-50 disabled" title="Consultar">Consultar</a>
                                </div>
                                <div class="col">
                                    <a href="#" class="btn btn-agregar-carrito w-50 disabled" title="Añadir al carrito">Añadir al carrito</a>
                                </div>
                            </div>
                        <?php elseif (session()->get('usuario')->rol == ROL_CLIENTE): ?>
                            <!-- Botones para el cliente -->
                            <div class="row row-cols-1 g-3 mx-3 text-center">
                                <div class="col">
                                    <a href="<?= base_url('contacto?producto=' . urlencode($producto->nombre)) ?>"
                                        class="btn btn-consultar w-50" title="Contactar">
                                        Consultar
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="<?= base_url('web/carrito/agregar/' . $producto->id) ?>" class="btn btn-agregar-carrito w-50" title="Añadir al carrito">Añadir al carrito</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <!-- Sección: Galería de miniaturas con Swiper -->
                    <div id="galeria" class="mt-4">
                        <h5>Galería:</h5>
                        <div class="swiper-container mySwiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($producto->imagenes as $index => $imagen): ?>
                                    <div class="swiper-slide">
                                        <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                            class="img-thumbnail view-fullscreen"
                                            alt="Imagen del producto"
                                            data-index="<?= $index ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Controles y paginación del Swiper -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Detalles extendidos del producto -->
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

    <!-- Modal para vista detallada de imágenes -->
    <div class="modal fade" id="fullscreenImageModal" tabindex="-1" aria-labelledby="fullscreenImageModalLabel" aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <?php
                                $active = '';
                            endforeach; ?>
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
<?= view("layouts/footer-cliente") ?>

<!-- Scripts: Manejo del modal fullscreen y Swiper -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Configuración para vista fullscreen: al hacer clic en una imagen con clase "view-fullscreen"
        document.querySelectorAll('.view-fullscreen').forEach(function(el) {
            el.addEventListener('click', function() {
                el.blur(); // Quitar el foco del elemento clickeado
                var idx = el.getAttribute('data-index');
                var modalEl = document.getElementById('fullscreenImageModal');
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                var carouselEl = document.getElementById('fullscreenCarousel');
                var carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
                carousel.to(parseInt(idx));
            });
        });

        // Antes de ocultar el modal fullscreen, mover el foco fuera (al elemento <main>)
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

        // Inicialización de Swiper para la mini galería (si se usa)
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

        // Asigna un único event listener para los botones "Agregar al Carrito"
        document.querySelectorAll(".btn-agregar-carrito").forEach(function(btn) {
            btn.addEventListener("click", function(event) {
                event.preventDefault(); // Evita la recarga de la página

                fetch(this.href, {
                        method: "POST"
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            actualizarCartCounter(data.totalItems);
                            mostrarMensajeFlash(data.message);
                            // Después de 1.5 segundos, recargar la página para reflejar el cambio en el carrito
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            mostrarMensajeFlash(data.message, "danger");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        mostrarMensajeFlash("Error al agregar el producto", "danger");
                    });
            });
        });
    });

    /**
     * Actualiza el contador del carrito en el navbar.
     * Si el contador ya existe, actualiza su texto; de lo contrario, lo crea y lo añade.
     * @param {number} totalItems - La cantidad total de items en el carrito.
     */
    function actualizarCartCounter(totalItems) {
        let counterEl = document.getElementById("cartCounter");
        if (counterEl) {
            counterEl.textContent = totalItems;
        } else {
            let cartDropdown = document.getElementById("cartDropdown");
            let newCounter = document.createElement("span");
            newCounter.id = "cartCounter";
            newCounter.className = "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
            newCounter.textContent = totalItems;
            cartDropdown.appendChild(newCounter);
        }
    }

    /**
     * Muestra un mensaje en el contenedor flash.
     * @param {string} texto - El mensaje a mostrar.
     * @param {string} [tipo="success"] - Tipo de alerta (success, danger, etc.).
     */
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