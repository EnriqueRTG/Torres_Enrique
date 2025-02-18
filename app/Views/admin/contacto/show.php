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
                        <!-- Se aplica la clase 'admin' o 'visitor' según el remitente -->
                        <div class="message <?= ($mensaje->tipo_remitente == 'admin') ? 'admin' : 'visitor' ?>">
                            <!-- Muestra información del remitente y la fecha -->
                            <small class="text-muted">
                                <?php if ($mensaje->tipo_remitente == 'admin'): ?>
                                    <i class="bi bi-person-check"></i> Admin
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
        <!-- Pie de la tarjeta: Formulario para responder -->
        <div class="card-footer">
            <form action="<?= base_url('admin/conversaciones/contactos/' . $conversacion->id . '/responder') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="respuesta" class="form-label"><strong>Responder</strong></label>
                    <textarea name="respuesta" id="respuesta" rows="5" class="form-control" placeholder="Escribe tu respuesta aquí..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> Enviar Respuesta
                </button>
            </form>
        </div>
    </div>
</main>

<!-- Incluimos el footer administrativo -->
<?= view("layouts/footer-admin") ?>