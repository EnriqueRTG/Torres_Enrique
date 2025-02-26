<!-- 
    Vista: Nueva Conversación
    Descripción: Permite al cliente iniciar una nueva conversación mediante un formulario.
    Se solicita ingresar un asunto y un mensaje. Al enviar el formulario, los datos se procesarán 
    en el controlador y, en caso de éxito, se redirigirá al índice de conversaciones con un mensaje de éxito.
-->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Sección para mostrar mensajes de sesión (errores o confirmaciones) -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Tarjeta que encapsula el formulario para iniciar una nueva conversación -->
    <section class="card">
        <!-- Encabezado de la tarjeta -->
        <header class="card-header">
            <h2 class="mb-0">Nueva Conversación</h2>
        </header>

        <!-- Cuerpo de la tarjeta: Formulario de nueva conversación -->
        <div class="card-body">
            <!-- El formulario envía los datos a la ruta que procesa la creación de la conversación -->
            <form action="<?= site_url('cliente/mensajes/enviar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row g-3">
                    <!-- Campo Asunto -->
                    <div class="col-12">
                        <label for="asunto" class="form-label">Asunto</label>
                        <input
                            type="text"
                            class="form-control"
                            id="asunto"
                            name="asunto"
                            placeholder="Ingresa el asunto"
                            required>
                    </div>
                    <!-- Campo Mensaje -->
                    <div class="col-12">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea
                            class="form-control"
                            id="mensaje"
                            name="mensaje"
                            rows="5"
                            placeholder="Escribe tu mensaje aquí..."
                            required></textarea>
                    </div>
                </div>
                <!-- Botones de acción: Cancelar y Enviar, ahora alineados al margen izquierdo -->
                <div class="d-flex justify-content-start mt-4">
                    <!-- Botón Cancelar: redirige al listado de conversaciones -->
                    <a href="<?= site_url('cliente/mensajes') ?>" class="btn btn-secondary me-2">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <!-- Botón Enviar: envía el formulario -->
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Enviar Mensaje
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>