<!-- Vista: admin/cliente/conversaciones/show.php -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<?= view('partials/_navbar-admin') ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión -->
    <div class="alert-info text-center">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <h1 class="mb-4">Detalle de Conversación</h1>

    <!-- Tarjeta con información de la conversación -->
    <div class="card mb-4">
        <div class="card-header">
            <strong>Asunto:</strong> <?= esc($conversacion->asunto) ?><br>
            <small>
                Iniciada el <?= date('d/m/Y H:i', strtotime($conversacion->created_at)) ?>
                <?php if (!empty($conversacion->nombre)): ?>
                    | De: <?= esc($conversacion->nombre) ?> (<?= esc($conversacion->email) ?>)
                <?php endif; ?>
            </small>
        </div>

        <div class="card-body">
            <?php if (!empty($conversacion->mensajes)): ?>
                <?php foreach ($conversacion->mensajes as $mensaje): ?>
                    <div class="message-container mb-3">
                        <div class="message <?= ($mensaje->tipo_remitente == 'administrador') ? 'administrador' : 'visitante' ?>">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php if ($mensaje->tipo_remitente == 'administrador'): ?>
                                        <i class="bi bi-person-check"></i> Administrador
                                    <?php else: ?>
                                        <i class="bi bi-person"></i> <?= esc($conversacion->nombre) ?>
                                    <?php endif; ?>
                                </small>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($mensaje->created_at)) ?></small>
                            </div>
                            <p class="mb-0"><?= esc($mensaje->mensaje) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No se han registrado mensajes en esta conversación.</p>
            <?php endif; ?>
        </div>

        <footer class="card-footer">
            <?php if ($conversacion->estado === 'abierta' || $conversacion->estado === 'activa'): ?>
                <form action="<?= site_url('admin/conversaciones/consultas/' . $conversacion->id . '/responder') ?>" method="post" class="mb-3">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="respuesta" class="form-label"><strong>Responder</strong></label>
                        <textarea name="respuesta" id="respuesta" rows="5" class="form-control" placeholder="Escribe tu respuesta aquí..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Enviar
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-secondary" role="alert">
                    Esta conversación está cerrada. No se pueden enviar respuestas.
                </div>
            <?php endif; ?>
        </footer>

    </div>
</main>

<?= view("layouts/footer-admin") ?>