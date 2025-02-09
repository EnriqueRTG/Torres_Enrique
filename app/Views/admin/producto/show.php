<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal para la vista de detalle del producto -->
<section class="container py-5">

    <!-- Mensajes de sesión -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta con la previsualización del producto -->
    <section class="card container mt-2 p-4" id="fondo-card-previsualizacion-producto">

        <!-- Título del producto -->
        <div>
            <p class="fs-1"><?= $producto->nombre ?></p>
        </div>

        <!-- Sección: Carrusel de imágenes y detalles del producto -->
        <section class="container mt-2 row mx-auto">
            <!-- Carrusel de imágenes -->
            <div class="col-12 col-md-12 col-lg-7">
                <div id="productCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php $active = 'active'; ?>
                        <?php foreach ($producto->imagenes as $imagen) : ?>
                            <div class="carousel-item <?= $active ?>">
                                <img src="<?= base_url($imagen->ruta_imagen) ?>" class="d-block w-100 rounded" alt="<?= $producto->nombre ?>">
                            </div>
                            <?php $active = ''; // Solo el primer elemento debe estar activo 
                            ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Detalles y acciones del producto -->
            <div class="col-12 col-md-12 col-lg-5">
                <div class="d-flex flex-column">
                    <div class="p-3 p-md-3 p-lg-5">
                        <!-- Precio del producto -->
                        <p class="mx-5 my-3">
                            Precio:
                            <span class="fw-bold">$ <?= $producto->precio ?></span>
                        </p>

                        <!-- Disponibilidad en stock con mensaje condicional -->
                        <p class="mx-5 my-3">
                            Unidades disponibles:
                            <?php if ($producto->stock < 9 && $producto->stock > 1) : ?>
                                <span class="text-danger fw-bold">¡Últimas <?= $producto->stock ?> unidades!</span>
                            <?php elseif ($producto->stock == 1) : ?>
                                <span class="text-danger fw-bold">¡Última unidad!</span>
                            <?php else : ?>
                                <span class="fw-bold"><?= $producto->stock ?></span>
                            <?php endif; ?>
                        </p>

                        <!-- Botones de acción, se muestran según si hay un usuario logueado -->
                        <div class="row row-cols-1 g-3 mx-5 my-3">
                            <?php if (session()->get('usuario')) : ?>
                                <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning col-12 disabled">
                                    Añadir al carrito
                                </a>
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-primary col-12 disabled">
                                    Comprar ahora
                                </a>
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-info col-12 disabled">
                                    Consultar
                                </a>
                            <?php else : ?>
                                <a href="<?= url_to('producto', $producto->id) ?>" class="btn btn-info col-12 disabled">
                                    Contactar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: Detalles del producto -->
        <div class="mt-5">
            <p class="fs-2">Detalles</p>
        </div>

        <!-- Tabla con información detallada del producto -->
        <table class="table table-responsive table-striped table-bordered table-hover">
            <tbody class="table-group-divider">
                <tr>
                    <td>Producto</td>
                    <td><?= $producto->nombre ?></td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td><?= $producto->descripcion ?></td>
                </tr>
                <tr>
                    <td>Marca</td>
                    <td><?= $producto->marca_nombre ?></td>
                </tr>
                <tr>
                    <td>Modelo</td>
                    <td><?= $producto->modelo ?></td>
                </tr>
                <tr>
                    <td>Peso</td>
                    <td><?= $producto->peso ?></td>
                </tr>
                <tr>
                    <td>Dimensiones</td>
                    <td><?= $producto->dimensiones ?></td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td><?= $producto->material ?></td>
                </tr>
                <tr>
                    <td>Colores</td>
                    <td><?= $producto->color ?></td>
                </tr>
                <tr>
                    <td>Categorias</td>
                    <td><?= $producto->categoria_nombre ?></td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Botones de acciones principales (volver, editar, eliminar) -->
    <div class="text-center pt-5 d-flex justify-content-evenly">
        <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary border-3 fw-bolder fw-bold fs-4" title="Cancelar">
            Volver <i class="bi bi-arrow-return-left"></i>
        </a>
        <a href="<?= base_url('admin/producto/editar/' . $producto->id) ?>" class="btn btn-outline-warning border-3 fw-bolder fw-bold fs-4">
            Editar <i class="bi bi-pencil-square"></i>
        </a>
        <a href="#" class="btn btn-outline-danger border-3 fw-bolder fw-bold fs-4" data-bs-target="#confirmarEliminacionModal" data-bs-toggle="modal" title="Eliminar">
            Eliminar <i class="bi bi-trash"></i>
        </a>
    </div>

    <!-- Modal para confirmar la eliminación del producto -->
    <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarEliminacionModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <p class="text-wrap">
                        ¿Estás seguro de que quieres eliminar el producto
                        <span class="fw-bolder"><?= $producto->nombre ?></span>?
                    </p>
                </div>
                <!-- Pie del modal con acciones -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="/dashboard/producto/delete/<?= $producto->id ?>" method="POST" id="eliminarProductoForm">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= view("layouts/footer-admin") ?>