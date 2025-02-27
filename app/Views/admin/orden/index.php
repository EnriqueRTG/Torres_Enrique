<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>
<?= view("partials/_navbar-admin") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Filtros y búsqueda -->
    <div class="row my-4">
        <div class="col-12 col-md-6 mb-2">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>
        </div>
        <div class="col-12 col-md-6 mb-2 text-end">
            <select id="filtroEstado" class="form-select w-auto d-inline-block">
                <option value="pendiente">Pendiente</option>
                <option value="procesanda">Procesanda</option>
                <option value="enviada">Enviada</option>
                <option value="completada">Completada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>
    </div>

    <!-- Tabla de órdenes -->
    <div class="table-responsive my-4">
        <table class="table table-dark table-striped table-hover" id="tablaOrdenes">
            <thead>
                <tr class="text-capitalize text-center align-middle">
                    <th>Orden #</th>
                    <th>Nombres Usuario</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Dirección Envío</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <?php if (!empty($ordenes)) : ?>
                    <?php foreach ($ordenes as $orden) : ?>
                        <tr>
                            <td><?= esc($orden->id) ?></td>
                            <td>
                                <?= esc($orden->nombre_usuario) ?><br>
                                <?= esc($orden->apellido_usuario) ?>
                            </td>
                            <td><?= date("d/m/Y H:i", strtotime($orden->created_at)) ?></td>
                            <td><?= ucfirst(esc($orden->estado)) ?></td>
                            <td>$<?= number_format($orden->total, 2) ?></td>
                            <td>
                                <?= esc($orden->calle) ?> <?= esc($orden->numero) ?><br>
                                <?= esc($orden->ciudad) ?> - <?= esc($orden->provincia) ?>
                            </td>
                            <td class="text-center">
                                <?php if ($orden->estado === 'pendiente') : ?>
                                    <a class="btn btn-outline-info btn-sm mx-1" href="<?= site_url('admin/ordenes/show/' . $orden->id) ?>" title="Ver Detalle">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a class="btn btn-outline-warning btn-sm mx-1" href="<?= site_url('admin/ordenes/edit/' . $orden->id) ?>" title="Editar Orden">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-outline-danger btn-sm mx-1" href="<?= site_url('admin/ordenes/cancelar/' . $orden->id) ?>" title="Cancelar Orden">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                    <a class="btn btn-outline-success btn-sm mx-1" href="<?= site_url('admin/ordenes/completar/' . $orden->id) ?>" title="Completar Orden">
                                        <i class="bi bi-check-circle"></i>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-outline-info btn-sm mx-1" href="<?= site_url('admin/ordenes/show/' . $orden->id) ?>" title="Ver Detalle">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron órdenes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="text-center" id="paginacion">
        <?= isset($pager) ? $pager->links() : '' ?>
    </div>
</main>

<?= view("layouts/footer-admin") ?>