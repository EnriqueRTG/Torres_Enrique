<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5 mx-auto">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="my-4">
        <a class="btn btn-success" href="/dashboard/producto/new">Crear</a>
        <div class="text-end">
            <form class="d-inline-flex " role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary border-3 fw-bold " type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="my-4">
        <table class="table table-dark table-striped table-hover table-responsive">

            <thead>
                <tr class="text-capitalize text-center ">
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Dimensiones</th>
                    <th scope="col">Material</th>
                    <th scope="col">Color</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Alta</th>
                    <th scope="col">Modificación</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php foreach ($productos as $key => $producto) : ?>
                    <tr>
                        <?php if ($producto->baja != 1) : ?>

                            <td>
                                <?= $producto->nombre ?>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                    <?= $producto->descripcion ?>
                                </span>
                            </td>
                            <td>
                                $ <?= $producto->precio ?>
                            </td>
                            <td>
                                <?= $producto->stock ?>
                            </td>
                            <td>
                                <?= $producto->nombre_marca ?>
                            </td>
                            <td>
                                <?= $producto->modelo ?>
                            </td>
                            <td>
                                <?= $producto->peso ?>
                            </td>
                            <td>
                                <?= $producto->dimensiones ?>
                            </td>
                            <td>
                                <?= $producto->material ?>
                            </td>
                            <td>
                                <?= $producto->color ?>
                            </td>
                            <td>
                                <?= $producto->categoria ?>
                            </td>

                            <td>
                                <?= $producto->fecha_creacion ?>
                            </td>
                            <td>
                                <?= $producto->fecha_actualizacion  ?>
                            </td>

                            <td class="text-center g-2">
                                <a class="btn btn-outline-info border-3 fw-bolder m-1" href="/dashboard/producto/<?= $producto->id ?>">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <form action="/dashboard/producto/delete/<?= $producto->id ?>" method="POST">
                                    <button class="btn btn-outline-danger border-3 fw-bolder m-1" type="submit">
                                        <i class="bi bi-trash" alt="Eliminar"></i>
                                    </button>
                                </form>
                                <a class="btn btn-outline-warning border-3 m-1" href="/dashboard/producto/edit/<?= $producto->id ?>">
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

<nav class="mb-5" aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>

<?= view("layouts/footer-admin") ?>