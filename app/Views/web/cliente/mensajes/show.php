<!-- Vista: Detalle de Conversación -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para navegación interna -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta que muestra el detalle de la conversación -->
    <section class="card mb-4">
        <!-- Cabecera de la tarjeta: Información básica de la conversación -->
        <header class="card-header">
            <h2 class="mb-0"><?= esc($conversacion->asunto) ?></h2>
            <small class="text-muted">
                Iniciada el <?= date('d/m/Y H:i', strtotime($conversacion->created_at)) ?>
                <?php if (!empty($conversacion->nombre)): ?>
                    | De: <?= esc($conversacion->nombre) ?> (<?= esc($conversacion->email) ?>)
                <?php endif; ?>
            </small>
        </header>

        <!-- Cuerpo de la tarjeta: Listado de mensajes de la conversación -->
        <div class="card-body">
            <?php if (!empty($conversacion->mensajes)): ?>
                <div class="list-group">
                    <?php foreach ($conversacion->mensajes as $mensaje): ?>
                        <div class="list-group-item">
                            <!-- Encabezado del mensaje: Remitente y fecha -->
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php if ($mensaje->tipo_remitente == 'admin'): ?>
                                        <i class="bi bi-person"></i> Admin
                                    <?php else: ?>
                                        <i class="bi bi-person-check"></i> Yo
                                    <?php endif; ?>
                                </small>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($mensaje->created_at)) ?></small>
                            </div>
                            <!-- Contenido del mensaje -->
                            <p class="mb-0"><?= esc($mensaje->mensaje) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center">No se han registrado mensajes en esta conversación.</p>
            <?php endif; ?>
        </div>

        <!-- Pie de la tarjeta: Formulario para responder o mensaje de "conversación cerrada" -->
        <footer class="card-footer">
            <?php if ($conversacion->estado !== 'cerrado'): ?>
                <!-- Si la conversación NO está cerrada, se muestra el formulario para responder -->
                <form action="<?= site_url('cliente/mensajes/responder/' . $conversacion->id) ?>" method="post" class="mb-3">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label"><strong>Redactar Mensaje</strong></label>
                        <textarea name="mensaje" id="mensaje" rows="4" class="form-control" placeholder="Escribe tu mensaje aquí..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-consultar">
                            <i class="bi bi-send"></i> Enviar
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <!-- Si la conversación está cerrada, se muestra un mensaje informativo -->
                <div class="alert alert-secondary" role="alert">
                    Esta conversación se encuentra cerrada. No se pueden enviar más mensajes.
                </div>
            <?php endif; ?>
        </footer>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>