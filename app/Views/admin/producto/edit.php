<!-- Vista parcial: Header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<?php
// Recuperar los errores de validación enviados como flashdata, si existen.
$errors = session()->getFlashdata('errors');
?>

<!-- Contenido principal: Se utiliza <main> para delimitar el contenido principal -->
<main class="container py-5 main-content">

    <!-- Mensajes de sesión (errores o notificaciones) -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: Navegación jerárquica -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta para la edición del producto -->
    <section class="card">
        <!-- Encabezado de la tarjeta: Muestra el nombre actual del producto -->
        <header class="card-header">
            <h1 class="card-title fs-1"><?= esc($producto->nombre) ?></h1>
        </header>

        <!-- Cuerpo de la tarjeta: Formulario de edición -->
        <div class="card-body">
            <!-- Formulario para actualizar el producto; se utiliza multipart/form-data para subir imágenes -->
            <form action="<?= base_url('admin/productos/update/' . $producto->id) ?>" method="POST" enctype="multipart/form-data" role="form">
                <div class="row">
                    <!-- Columna izquierda: Carrusel de imágenes actuales -->
                    <div class="col-md-6">
                        <!-- Carrusel de imágenes para visualizar las imágenes actuales -->
                        <div id="carruselImagenes" class="carousel slide carousel-dark" data-bs-ride="carousel" aria-label="Carrusel de imágenes del producto">
                            <div class="carousel-inner">
                                <?php
                                // Variable para marcar el primer elemento como activo
                                $active = 'active';
                                foreach ($producto->imagenes as $index => $imagen): ?>
                                    <div class="carousel-item text-center <?= $active ?>">
                                        <!-- Imagen del producto -->
                                        <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                            class="img-thumbnail view-fullscreen"
                                            alt="Imagen del producto"
                                            data-index="<?= $index ?>">
                                        <!-- Botón de eliminación, solo si la imagen no es la predeterminada -->
                                        <?php if ($imagen->ruta_imagen !== 'uploads/productos/no-image.png'): ?>
                                            <div class="mt-2">
                                                <a href="#"
                                                    class="btn btn-danger btn-eliminar-imagen"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#eliminarImagenModal"
                                                    data-imagen-id="<?= $imagen->id ?>"
                                                    data-imagen-nombre="<?= esc($imagen->nombre) ? esc($imagen->nombre) : 'Imagen ' . $imagen->id ?>">
                                                    Eliminar
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php
                                    // Después del primer elemento, ya no se aplica "active"
                                    $active = '';
                                endforeach; ?>
                            </div>
                            <!-- Controles del carrusel -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenes" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenes" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>

                    <!-- Columna derecha: Campos principales para editar -->
                    <div class="col-md-6">
                        <!-- Campo: Nombre del producto -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text"
                                class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                                id="nombre" name="nombre"
                                value="<?= old('nombre', $producto->nombre) ?>">
                            <?php if (isset($errors['nombre'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['nombre'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Campo: Precio -->
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                    class="form-control <?= isset($errors['precio']) ? 'is-invalid' : '' ?>"
                                    id="precio" name="precio"
                                    value="<?= old('precio', $producto->precio) ?>">
                                <?php if (isset($errors['precio'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['precio'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Campo: Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Unidades disponibles:</label>
                            <input type="number"
                                class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>"
                                id="stock" name="stock"
                                value="<?= old('stock', $producto->stock) ?>">
                            <?php if (isset($errors['stock'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['stock'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Campo: Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select class="form-select <?= isset($errors['estado']) ? 'is-invalid' : '' ?>"
                                id="estado" name="estado" aria-label="Seleccionar estado del producto">
                                <option value="activo" <?= old('estado', $producto->estado) == 'activo' ? 'selected' : '' ?>>Activo</option>
                                <option value="inactivo" <?= old('estado', $producto->estado) == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                            </select>
                            <?php if (isset($errors['estado'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['estado'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Campo: Subir nuevas imágenes -->
                        <div class="mb-3 mt-3">
                            <label for="imagenes" class="form-label">Subir nuevas imágenes:</label>
                            <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple>
                        </div>
                        <!-- Sección: Galería Actual (imitando la vista show) -->
                        <div id="galeria" class="my-4">
                            <h5>Galería:</h5>
                            <!-- Contenedor del Swiper para miniaturas -->
                            <div class="swiper-container mySwiper">
                                <div class="swiper-wrapper">
                                    <?php foreach ($producto->imagenes as $index => $imagen): ?>
                                        <div class="swiper-slide text-center">
                                            <!-- Miniatura con opción de vista fullscreen -->
                                            <img src="<?= base_url($imagen->ruta_imagen) ?>"
                                                class="img-thumbnail view-fullscreen"
                                                alt="Imagen del producto"
                                                data-index="<?= $index ?>">
                                            <!-- Botón de eliminación (si la imagen no es la predeterminada) -->
                                            <?php if ($imagen->ruta_imagen !== 'uploads/productos/no-image.png'): ?>
                                                <div class="mt-2">
                                                    <a href="#"
                                                        class="btn btn-danger btn-eliminar-imagen"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#eliminarImagenModal"
                                                        data-imagen-id="<?= $imagen->id ?>"
                                                        data-imagen-nombre="<?= esc($imagen->nombre) ? esc($imagen->nombre) : 'Imagen ' . $imagen->id ?>">
                                                        Eliminar
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!-- Controles de navegación laterales -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                                <!-- Paginación opcional -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de detalles adicionales del producto -->
                <section class="mt-5">
                    <h2 class="fs-2">Detalles</h2>
                    <!-- Campo: Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>"
                            id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $producto->descripcion) ?></textarea>
                        <?php if (isset($errors['descripcion'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['descripcion'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Distribución en dos columnas para el resto de detalles -->
                    <div class="row">
                        <!-- Columna izquierda: Marca, Modelo y Peso -->
                        <div class="col-md-6">
                            <!-- Selección de Marca -->
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca:</label>
                                <select class="form-select <?= isset($errors['marca_id']) ? 'is-invalid' : '' ?>"
                                    id="marca" name="marca_id" aria-label="Seleccionar marca">
                                    <option value="<?= $producto->marca_id ?>" selected><?= esc($producto->marca_nombre) ?></option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <?php if ($producto->marca_nombre != $marca->nombre): ?>
                                            <option value="<?= $marca->id ?>"><?= esc($marca->nombre) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['marca_id'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['marca_id'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Modelo -->
                            <div class="mb-3">
                                <label for="modelo" class="form-label">Modelo:</label>
                                <input type="text" class="form-control <?= isset($errors['modelo']) ? 'is-invalid' : '' ?>"
                                    id="modelo" name="modelo" value="<?= old('modelo', $producto->modelo) ?>">
                                <?php if (isset($errors['modelo'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['modelo'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Peso -->
                            <div class="mb-3">
                                <label for="peso" class="form-label">Peso:</label>
                                <input type="text" class="form-control <?= isset($errors['peso']) ? 'is-invalid' : '' ?>"
                                    id="peso" name="peso" value="<?= old('peso', $producto->peso) ?>">
                                <?php if (isset($errors['peso'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['peso'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Columna derecha: Dimensiones, Material y Color -->
                        <div class="col-md-6">
                            <!-- Campo: Dimensiones -->
                            <div class="mb-3">
                                <label for="dimensiones" class="form-label">Dimensiones:</label>
                                <input type="text" class="form-control <?= isset($errors['dimensiones']) ? 'is-invalid' : '' ?>"
                                    id="dimensiones" name="dimensiones" value="<?= old('dimensiones', $producto->dimensiones) ?>">
                                <?php if (isset($errors['dimensiones'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['dimensiones'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Material -->
                            <div class="mb-3">
                                <label for="material" class="form-label">Material:</label>
                                <input type="text" class="form-control <?= isset($errors['material']) ? 'is-invalid' : '' ?>"
                                    id="material" name="material" value="<?= old('material', $producto->material) ?>">
                                <?php if (isset($errors['material'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['material'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Color -->
                            <div class="mb-3">
                                <label for="color" class="form-label">Color:</label>
                                <input type="text" class="form-control <?= isset($errors['color']) ? 'is-invalid' : '' ?>"
                                    id="color" name="color" value="<?= old('color', $producto->color) ?>">
                                <?php if (isset($errors['color'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['color'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Campo: Categoría (destacado debajo de las columnas) -->
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select class="form-select <?= isset($errors['categoria_id']) ? 'is-invalid' : '' ?>"
                            id="categoria" name="categoria_id" aria-label="Seleccionar categoría">
                            <option value="<?= $producto->categoria_id ?>" selected><?= esc($producto->categoria_nombre) ?></option>
                            <?php foreach ($categorias as $categoria): ?>
                                <?php if ($producto->categoria_nombre != $categoria->nombre): ?>
                                    <option value="<?= $categoria->id ?>"><?= esc($categoria->nombre) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['categoria_id'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['categoria_id'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Botones de acción: Cancelar y Guardar cambios -->
                <div class="text-center pt-5 d-flex justify-content-evenly pb-3">
                    <a href="<?= session()->get('referer') ?>" class="btn btn-outline-secondary border-3 fw-bolder fw-bold fs-4" title="Cancelar">
                        Cancelar <i class="bi bi-arrow-return-left"></i>
                    </a>
                    <button type="submit" class="btn btn-outline-warning border-3 fw-bolder fw-bold fs-4" title="Guardar cambios">
                        Guardar <i class="bi bi-pencil-square"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<!-- Modal para confirmar la eliminación de una imagen -->
<div class="modal fade" id="eliminarImagenModal" tabindex="-1" aria-labelledby="eliminarImagenModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarImagenModalLabel">Confirmar Eliminación de Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la imagen <strong id="nombreImagen"></strong>?</p>
            </div>
            <!-- Pie del modal: Formulario para confirmar la eliminación -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formEliminarImagen" method="POST" action="">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vista parcial: Footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts: Manejo del modal fullscreen, inicialización de Swiper y configuración del modal para eliminación de imágenes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Inicialización de Swiper para la galería de miniaturas ---
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

        // --- Configuración del modal para eliminación de imágenes ---
        var eliminarImagenModal = document.getElementById('eliminarImagenModal');
        eliminarImagenModal.addEventListener('show.bs.modal', function(event) {
            // Obtener el botón que disparó el modal
            var button = event.relatedTarget;
            // Extraer atributos personalizados con la información de la imagen
            var imagenId = button.getAttribute('data-imagen-id');
            var imagenNombre = button.getAttribute('data-imagen-nombre');
            // Actualizar el contenido del modal con el nombre de la imagen a eliminar
            document.getElementById('nombreImagen').textContent = imagenNombre;
            // Actualizar la acción del formulario para eliminar la imagen
            var form = document.getElementById('formEliminarImagen');
            form.action = "<?= base_url('admin/imagenproducto/eliminarImagen') ?>/" + imagenId;
        });
    });
</script>