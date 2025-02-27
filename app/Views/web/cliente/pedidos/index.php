<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<div class="container my-3 main-content">
    <!-- Breadcrumb -->
    <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>

    <h1 class="mb-4 text-center text-white"><?= esc($titulo) ?></h1>

    <?php if (!empty($ordenes)) : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="text-center align-middle">
                    <tr>
                        <th>Orden</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <?php foreach ($ordenes as $orden) : ?>
                        <tr>
                            <td># <?= esc($orden->id) ?></td>
                            <td>$<?= number_format($orden->total, 2) ?></td>
                            <td><?= ucfirst(esc($orden->estado)) ?></td>
                            <td><?= date("d/m/Y H:i", strtotime($orden->created_at)) ?></td>
                            <td>
                                <a href="<?= site_url('cliente/pedidos/show/' . $orden->id) ?>" class="btn btn-info btn-sm m-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('cliente/pedidos/descargarPdf/' . $orden->id) ?>" class="btn btn-secondary btn-sm m-1">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                </a>
                                <a href="<?= site_url('cliente/pedidos/cancelar/' . $orden->id) ?>" class="btn btn-danger btn-sm m-1">
                                    <i class="bi bi-x-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="text-center fs-4">No tienes pedidos registrados.</p>
    <?php endif; ?>
</div>

<?= view("layouts/footer-cliente") ?>