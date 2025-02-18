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

    <!-- Encabezado principal de la vista -->
    <header class="mb-4">
        <h1 class="fs-1 text-center">Historial de Mensajes</h1>
    </header>

    <!-- Sección principal: Lista de mensajes -->
    <section>
        <?php if (empty($mensajes)): ?>
            <!-- Mensaje informativo si no hay mensajes -->
            <div class="alert alert-info text-center">
                No hay mensajes disponibles.
            </div>
        <?php else: ?>
            <!-- Tabla responsiva para mostrar los mensajes -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Fecha</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajes as $mensaje): ?>
                            <tr>
                                <!-- Formateo de la fecha; ajusta el formato si es necesario -->
                                <td class="text-center"><?= date('d/m/Y H:i', strtotime($mensaje->created_at)) ?></td>
                                <td><?= esc($mensaje->asunto) ?></td>
                                <td><?= esc($mensaje->mensaje) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Sección de paginación (si tu controlador utiliza paginación) -->
            <div class="text-center">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>