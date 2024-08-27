<section class="card container mt-2 p-4">

    <div class="">
        <p class="fs-1"><?= $producto->nombre ?></p>
    </div>

    <section class="container mt-2 row mx-auto">
        <div class="col-12 col-md-12 col-lg-7">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $active = 'active';
                    foreach ($imagenes as $imagen) : ?>
                        <div class="carousel-item <?= $active ?>">
                            <img src="<?= base_url($imagen->url) ?>" class="d-block w-100 rounded" alt="<?= $producto->nombre ?>">
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
                            <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning col-12">
                                Añadir al carrito
                            </a>
                            <a class="btn btn-primary col-12" href="<?= url_to('producto', $producto->id) ?>">
                                Comprar ahora
                            </a>
                            <a class="btn btn-info col-12" href="<?= url_to('producto', $producto->id) ?>">
                                Consultar
                            </a>
                        <?php else : ?>
                            <a class="btn btn-info col-12" href="<?= url_to('producto', $producto->id) ?>">
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
                <td>
                    <?php foreach ($categorias as $categoria) : ?>
                        <span class="text-capitalize me-3"><?= $categoria->nombre ?></span>
                    <?php endforeach; ?>
                </td>
            </tr>
        </tbody>
    </table>
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