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
                <tr class="text-capitalize text-center">
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
                    <th scope="col">Categoría</th>
                    <th scope="col">Fecha de Alta</th>
                    <th scope="col">Última Modificación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td class="align-middle">
                            <?= $producto->nombre ?>
                        </td>
                        <td class="align-middle">
                            <div class="overflow-auto" style="max-height: 100px;">
                                <?= $producto->descripcion ?>
                            </div>
                        </td>
                        <td class="align-middle">
                            $<?= $producto->precio ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->stock ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->marca ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->modelo ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->peso ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->dimensiones ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->material ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->color ?>
                        </td>
                        <td class="align-middle">
                            <?= $producto->categoria ?>
                        </td>
                        <td class="align-middle">
                            <?= DateTime::createFromFormat('Y-m-d H:i:s', $producto->fecha_registro)->format('d/m/Y H:i') ?>
                        </td>
                        <td class="align-middle">
                            <?= DateTime::createFromFormat('Y-m-d H:i:s', $producto->fecha_actualizacion)->format('d/m/Y H:i') ?>
                        </td>
                        <td class="text-center align-middle">
                            <a href="/dashboard/producto/<?= $producto->id ?>" class="btn btn-sm btn-outline-info border-3 fw-bolder m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <form action="/dashboard/producto/delete/<?= $producto->id ?>" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-danger border-3 fw-bolder m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <a href="/dashboard/producto/edit/<?= $producto->id ?>" class="btn btn-sm btn-outline-warning border-3 m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
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

<script>
    // Inicializar tooltips de Bootstrap ( muestran información adicional cuando el usuario pasa el mouse sobre un elemento)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>