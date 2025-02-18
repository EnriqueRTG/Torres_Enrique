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

    <h1 class="mb-4">Consultas</h1>
    <p class="lead">Listado de conversaciones de tipo <strong>consulta</strong>.</p>

    <!-- Spinner de carga (oculto por defecto) -->
    <div id="spinner" class="text-center d-none my-3">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Tabla de conversaciones -->
    <div class="table-responsive" id="tablaConversaciones">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-dark">
            <!-- Encabezados de la tabla -->
            <tr class="text-capitalize text-center align-middle">
                <th>ID</th>
                <th>Nombre / Email</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
                <?php if (!empty($conversaciones)): ?>
                    <?php foreach ($conversaciones as $conv): ?>
                        <!-- Se aplica un estilo distinto según el estado de la conversación -->
                        <tr class="<?= ($conv->estado == 'abierto') ? 'table-warning' : 'table-success' ?>">
                            <td><?= esc($conv->id) ?></td>
                            <td>
                                <?= esc($conv->nombre) ?><br>
                                <small><?= esc($conv->email) ?></small>
                            </td>
                            <td><?= esc($conv->asunto) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($conv->created_at)) ?></td>
                            <td>
                                <?php if ($conv->estado == 'abierto'): ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Respondido</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Enlace a la vista detalle de la conversación -->
                                <a href="<?= base_url('admin/consultas/' . $conv->id) ?>" class="btn btn-sm btn-primary">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron conversaciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="text-center" id="paginacion">
    </div>
</main>


<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>