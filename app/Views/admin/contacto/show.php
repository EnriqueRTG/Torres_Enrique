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

    <h1 class="mb-4">Detalle de Conversación</h1>

    <!-- Tarjeta que contiene la información de la conversación -->
    <div class="card mb-4">
        <!-- Cabecera de la tarjeta con información básica de la conversación -->
        <div class="card-header">
            <strong>Asunto:</strong> <?= esc($conversacion->asunto) ?><br>
            <small>
                Iniciada el <?= date('d/m/Y H:i', strtotime($conversacion->created_at)) ?>
                <?php if (!empty($conversacion->nombre)): ?>
                    | De: <?= esc($conversacion->nombre) ?> (<?= esc($conversacion->email) ?>)
                <?php endif; ?>
            </small>
        </div>
        <!-- Cuerpo de la tarjeta: Listado de mensajes -->
        <div class="card-body">
            <?php if (!empty($conversacion->mensajes)): ?>
                <?php foreach ($conversacion->mensajes as $mensaje): ?>
                    <!-- Contenedor para cada mensaje -->
                    <div class="message-container">
                        <!-- Se aplica la clase 'administrador' o 'visitante' según el remitente -->
                        <div class="message <?= ($mensaje->tipo_remitente == 'administrador') ? 'administrador' : 'visitante' ?>">
                            <!-- Muestra información del remitente y la fecha -->
                            <small class="text-muted">
                                <?php if ($mensaje->tipo_remitente == 'administrador'): ?>
                                    <i class="bi bi-person-check"></i> Administrador
                                <?php else: ?>
                                    <i class="bi bi-person"></i> <?= esc($conversacion->nombre) ?>
                                <?php endif; ?>
                                | <?= date('d/m/Y H:i', strtotime($mensaje->created_at)) ?>
                            </small>
                            <!-- Contenido del mensaje -->
                            <p class="mb-0"><?= esc($mensaje->mensaje) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No se han registrado mensajes en esta conversación.</p>
            <?php endif; ?>
        </div>
        <!-- Pie de la tarjeta: Formulario para responder y botón para cerrar la conversación -->
        <div class="card-footer">
            <?php if ($conversacion->estado !== 'cerrada'): ?>
                <!-- Formulario para responder -->
                <form action="<?= base_url('admin/conversaciones/contactos/' . $conversacion->id . '/responder') ?>" method="post" class="mb-3">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="respuesta" class="form-label"><strong>Responder</strong></label>
                        <textarea name="respuesta" id="respuesta" rows="5" class="form-control" placeholder="Escribe tu respuesta aquí..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Enviar
                    </button>
                </form>

                <!-- Botón para marcar la conversación como cerrada -->
                <form action="<?= base_url('admin/conversaciones/contactos/' . $conversacion->id . '/cerrar') ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Marcar como Cerrada
                    </button>
                </form>
            <?php else: ?>
                <!-- Mensaje informativo cuando la conversación está cerrada -->
                <div class="alert alert-secondary" role="alert">
                    Esta conversación está cerrada. No se pueden enviar respuestas.
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- Incluimos el footer administrativo -->
<?= view("layouts/footer-admin") ?>