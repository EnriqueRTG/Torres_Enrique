<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Se incluye la barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">

    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Botón Búsqueda -->
    <div class="row my-4">
        <!-- Búsqueda -->
        <div class="col-auto ms-auto">
            <form class="d-inline-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-primary border-3 fw-bold" type="submit">Buscar</button>
            </form>
        </div>

        <!-- Filtro por estado -->
        <div class="col-md-2 offset-md-10">
            <select id="filtroEstado" class="form-select">
                <option value="pendiente">Pendiente</option>
                <option value="procesanda">Procesanda</option>
                <option value="enviada">Enviada</option>
                <option value="completada">Completada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>
    </div>

    <!-- Tabla de marcas -->
    <div class="my-4">
        <!-- Spinner de carga -->
        <div class="text-center d-none m-5" id="spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <table class="table table-dark table-striped table-hover table-responsive" id="tablaOrdenes">
            <thead>
                <tr class="text-capitalize text-center align-middle">
                    <th scope="col">Nro Usuario</td>
                    <th scope="col">Fecha</td>
                    <th scope="col">Estado</td>
                    <th scope="col">Total</td>
                    <th scope="col">Direccion Envio</td>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center align-middle">
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

        <!-- Paginación -->
        <div class="text-center" id="paginacion">
        </div>
    </div>
</main>

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