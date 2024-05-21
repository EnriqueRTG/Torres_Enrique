<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
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
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
                <?php foreach ($categorias as $key => $categoria) : ?>

                    <tr>
                        <?php if ($categoria->baja != 1) : ?>

                            <td class="col-8">
                                <?= $categoria->nombre ?>
                            </td>

                            <td class="col-4">
                                <div class="row row-cols-3">
                                    <form class="col row" action="/dashboard/categoria/delete/<?= $categoria->id ?>" method="POST">
                                        <button class="btn btn-danger col" type="submit">
                                            <i class="bi bi-trash" alt="Eliminar"></i>
                                        </button>
                                    </form>
                                    <a class="btn btn-warning col" href="/dashboard/categoria/edit/<?= $categoria->id ?>">
                                        <i class="bi bi-pencil-square" alt="Editar"></i>
                                    </a>
                                </div>
                            </td>

                        <?php endif ?>
                    </tr>

                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</section>

<?= view("plantilla/footer-admin") ?>