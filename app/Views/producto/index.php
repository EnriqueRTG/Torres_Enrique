<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/panel'); ?>">Panel</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="my-4">
        <a class="btn btn-success" href="/dashboard/producto/new">Crear</a>
    </div>

    <div class="my-4">
        <table class="table table-secondary table-striped table-hover">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Presentación</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($productos as $key => $producto) : ?>
                    <tr>
                        <?php if ($producto->baja != 1) : ?>
                            <td>
                                <?= $producto->nombre ?>
                            </td>
                            <td>
                                <?= $producto->descripcion ?>
                            </td>
                            <td>
                                <?= $producto->precio ?>
                            </td>
                            <td>
                                <?= $producto->stock ?>
                            </td>
                            <td>
                                <?php foreach ($marcas as $key => $marca) : ?>
                                    <?php if ($marca->id == $producto->marca_id) : ?>
                                        <?= $marca->nombre ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </td>
                            <td>
                                <?= $producto->presentacion ?>
                            </td>


                            <td>
                                <a class="btn btn-primary" href="/dashboard/producto/<?= $producto->id ?>">
                                    <i class="bi bi-eye" alt="Ver"></i>
                                </a>
                                <form action="/dashboard/producto/delete/<?= $producto->id ?>" method="POST">
                                    <button class="btn btn-danger" type="submit">
                                        <i class="bi bi-trash" alt="Eliminar"></i>
                                    </button>
                                </form>
                                <a class="btn btn-dark" href="/dashboard/producto/edit/<?= $producto->id ?>">
                                    <i class="bi bi-pencil-square" alt="Editar"></i>
                                </a>
                            </td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</section>

<?= view("plantilla/footer-admin") ?>