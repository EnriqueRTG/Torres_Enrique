<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="my-4">
        <a class="btn btn-success" href="/dashboard/categoria/new">Crear</a>
        <div class="text-end">
            <form class="d-inline-flex " role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary border-3 fw-bold " type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="my-4">

        <table class="table table-dark table-striped table-hover">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php foreach ($categorias as $key => $categoria) : ?>

                    <tr>
                        <?php if ($categoria->baja != 1) : ?>

                            <td class="col-8">
                                <?= $categoria->nombre ?>
                            </td>

                            <td class="text-center g-2">
                                <form action="/dashboard/categoria/delete/<?= $categoria->id ?>" method="POST">
                                    <button class="btn btn-outline-danger border-3 fw-bolder m-1" type="submit">
                                        <i class="bi bi-trash" alt="Eliminar"></i>
                                    </button>
                                </form>
                                <a class="btn btn-outline-warning border-3 fw-bolder mx-1" href="/dashboard/categoria/edit/<?= $categoria->id ?>">
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