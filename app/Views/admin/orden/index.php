<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<?= view('partials/_session') ?>

<section class="container py-5 main-content">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>

    </nav>

    <div class="text-end">
        <form class="d-inline-flex mt-5" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary border-3 fw-bold " type="submit">Buscar</button>
        </form>
    </div>



    <div class="my-3 table-responsive">
        <table class="table table-dark table-striped table-hover my-5 ">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nro Usuario</td>
                    <th scope="col">Fecha</td>
                    <th scope="col">Estado</td>
                    <th scope="col">Total</td>
                    <th scope="col">Direccion Envio</td>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php foreach ($ordenes as $key => $orden) : ?>
                    <tr>
                        <td>
                            <?= $orden->usuario_id ?>
                        </td>
                        <td>
                            <?= $orden->fecha ?>
                        </td>
                        <td>
                            <?= $orden->estado ?>
                        </td>
                        <td>
                            <?= $orden->total ?>
                        </td>
                        <td>
                            <?= $orden->direccion_envio_id ?>
                        </td>

                        <td class="text-center g-2">
                            <a class="btn btn-outline-warning btn-sm border-3 mx-1" href="<?php echo base_url('admin/dashboard'); ?><?= $orden->id ?>">
                                <i class="bi bi-box-seam-fill"></i>
                            </a>
                            <a class="btn btn-outline-info btn-sm border-3 mx-1" href="<?php echo base_url('admin/dashboard'); ?><?= $orden->id ?>">
                                <i class="bi bi-envelope-at-fill"></i>
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