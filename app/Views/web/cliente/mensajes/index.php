<!-- 
    Vista: Listado de Conversaciones del Cliente
    Descripción: Se listan todas las conversaciones iniciadas por el cliente, ordenadas de la más reciente a la más antigua.
    El campo "Estado" ahora muestra:
      - "Cerrado" si la conversación está marcada como cerrada.
      - "Respondido" si la conversación está abierta pero el último mensaje fue enviado por el administrador.
      - "Pendiente" si la conversación está abierta y el último mensaje fue enviado por el cliente (o no existe información del último mensaje).
-->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar del cliente -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de error o confirmación -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado: Título y botón "Redactar" -->
    <div class="d-flex flex-column mb-4">
        <h1 class="h3 mb-1 text-white">Mis Conversaciones</h1>
        <div class="mt-2">
            <a href="<?= site_url('cliente/mensajes/redactar') ?>" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Redactar
            </a>
        </div>
    </div>

    <!-- Formulario de búsqueda -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <div class="col-12 col-md-8">
            <label for="busqueda" class="form-label text-white">Buscar por asunto o mensaje:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingresa palabra clave" value="<?= esc($busqueda ?? '') ?>">
        </div>
        <div class="col-12 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de Conversaciones -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr class="text-center">
                    <th>Asunto</th>
                    <th>Fecha de Inicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($conversaciones)): ?>
                    <?php foreach ($conversaciones as $conv): ?>
                        <tr class="text-center">
                            <!-- Asunto -->
                            <td><?= esc($conv->asunto) ?></td>
                            <!-- Fecha de inicio -->
                            <td><?= date('d/m/Y H:i', strtotime($conv->created_at)) ?></td>
                            <!-- Estado, basado en la lógica definida -->
                            <td>
                                <?php if ($conv->estado === 'cerrado'): ?>
                                    <!-- Si la conversación está marcada como cerrada -->
                                    <span class="badge bg-secondary">Cerrada</span>
                                <?php else: ?>
                                    <?php
                                    // Si se cuenta con el último mensaje, se evalúa el remitente.
                                    // Se asume que $conv->ultimoMensaje es un objeto con la propiedad 'tipo_remitente'
                                    if (isset($conv->ultimoMensaje)) {
                                        if ($conv->ultimoMensaje->tipo_remitente === 'admin') {
                                            // Si el último mensaje fue del administrador
                                            echo '<span class="badge bg-success">Respondido</span>';
                                        } else {
                                            // Si el último mensaje fue del cliente
                                            echo '<span class="badge bg-warning text-dark">Pendiente</span>';
                                        }
                                    } else {
                                        // Si no existe información del último mensaje, se asume pendiente.
                                        echo '<span class="badge bg-warning text-dark">Pendiente</span>';
                                    }
                                    ?>
                                <?php endif; ?>
                            </td>
                            <!-- Acciones -->
                            <td>
                                <a href="<?= site_url('cliente/mensajes/ver/' . $conv->id) ?>" class="btn btn-sm btn-primary" title="Ver conversación">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron conversaciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación (si se utiliza la paginación de CodeIgniter) -->
    <?php if (isset($pager)): ?>
        <div class="d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</main>

<?= view("layouts/footer-cliente") ?>