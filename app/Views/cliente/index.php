<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<?= view('partials/_session') ?>

<section class="container py-5">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/panel'); ?>">Panel</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="my-4">
        <table class="table table-secondary table-striped table-hover my-5">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</td>
                    <th scope="col">Apellido</td>
                    <th scope="col">Email</td>
                    <th scope="col">Dirección</td>
                    <th scope="col">Telefono</td>
                    <th scope="col">Alta</td>
                    <th scope="col">Modificación</td>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($clientes as $key => $cliente) : ?>
                    <tr>

                        <?php if ($cliente->baja != 1) : ?>
                            <td>
                                <?= $cliente->nombre ?>
                            </td>
                            <td>
                                <?= $cliente->apellido ?>
                            </td>
                            <td>
                                <?= $cliente->email ?>
                            </td>
                            <td>
                                <?= $cliente->direccion ?>
                            </td>
                            <td>
                                <?= $cliente->telefono ?>
                            </td>
                            <td>
                                <?= $cliente->fecha_alta ?>
                            </td>
                            <td>
                                <?= $cliente->fecha_actualizacion ?>
                            </td>

                            <td>
                                <a href="/dashboard/cliente/<?= $cliente->id ?>">
                                    <i class="bi bi-eye" alt="Ver"></i>
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