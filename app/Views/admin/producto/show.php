<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/productos'); ?>">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="row my-4">
    </div>

    <section class="card container mt-2 p-4" id="fondo-card-previsualizacion-producto">

        <div class="">
            <p class="fs-1"><?= $producto->nombre ?></p>
        </div>

        <section class="container mt-2 row mx-auto">
            <div class="col-12 col-md-12 col-lg-7">
                <div id="productCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php $active = 'active';
                        foreach ($imagenes as $imagen) : ?>
                            <div class="carousel-item <?= $active ?>">
                                <img src="<?= base_url($imagen->ruta_imagen) ?>" class="d-block w-100 rounded" alt="<?= $producto->nombre ?>">
                            </div>
                            <?php $active = ''; ?>
                        <?php endforeach; ?>
                    </div>
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

            <div class="col-12 col-md-12 col-lg-5">
                <div class="d-flex flex-column">
                    <div class="p-3 p-md-3 p-lg-5">
                        <p class="mx-5 my-3">Precio:
                            <span class="fw-bold">
                                $ <?= $producto->precio ?>
                            </span>
                        </p>

                        <p class="mx-5 my-3">Unidades disponibles:
                            <!-- Stock Disponible -->
                            <?php if ($producto->stock < 9 & $producto->stock > 1) : ?>
                                <span class="text-danger font-weight-bold">¡Últimas <?= $producto->stock ?> unidades!</span>
                            <?php elseif ($producto->stock == 1) : ?>
                                <span class="text-danger font-weight-bold">¡Última unidad!</span>
                            <?php else : ?>
                                <span class="fw-bold">
                                    <?= $producto->stock ?>
                                </span>
                            <?php endif; ?>
                        </p>

                        <div class="row row-cols-1 g-3 mx-5 my-3">
                            <?php if (session()->get('usuario')) : ?>
                                <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning col-12 disabled">
                                    Añadir al carrito
                                </a>
                                <a class="btn btn-primary col-12 disabled" href="<?= url_to('producto', $producto->id) ?>">
                                    Comprar ahora
                                </a>
                                <a class="btn btn-info col-12 disabled" href="<?= url_to('producto', $producto->id) ?>">
                                    Consultar
                                </a>
                            <?php else : ?>
                                <a class="btn btn-info col-12 disabled" href="<?= url_to('producto', $producto->id) ?>">
                                    Contactar
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mt-5">
            <p class="fs-2">Detalles</p>
        </div>

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
                    <td><?= $producto->nombre_marca ?></td>
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
                    <td><?= $producto->nombre_categoria ?></td>
                </tr>
            </tbody>
        </table>
    </section>


    <div class="text-center pt-5 d-flex justify-content-evenly">
        <a href="<?php echo base_url('admin/productos'); ?>" class="btn btn-outline-secondary border-3 fw-bolder fw-bold fs-4" title="Cancelar">
            Volver <i class="bi bi-arrow-return-left"></i>
        </a>
        <a href="<?php echo base_url() ?>admin/producto/editar/<?= $producto->id ?>" class="btn btn-outline-warning border-3 fw-bolder fw-bold fs-4">
            Editar <i class="bi bi-pencil-square"></i>
        </a>

        <a href="#" class="btn btn-outline-danger border-3 fw-bolder fw-bold fs-4" data-bs-target="#confirmarEliminacionModal" data-bs-toggle="modal" title="Eliminar">
            Eliminar <i class="bi bi-trash"></i>
        </a>

    </div>

    <div class="modal fade" id="confirmarEliminacionModal" tabindex="-1" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarEliminacionModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-wrap">¿Estás seguro de que quieres eliminar el producto <span class="fw-bolder"><?php echo $producto->nombre ?></span> ?</p>
                </div>
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