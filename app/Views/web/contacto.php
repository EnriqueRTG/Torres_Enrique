<?php
$usuario = session()->get('usuario');
?>
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content" tabindex="0">
    <div class="alert-info text-center container">
        <?= session()->has('mensaje') ? view('partials/_session') : '' ?>
    </div>

    <section class="card shadow-sm my-3">
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Información de Contacto</h2>
        </header>
        <div class="card-body">
            <p class="card-text text-center">
                Por favor, envíanos tus consultas. Si ya estás registrado, tus datos se completarán automáticamente y no podrán modificarse.
            </p>
            <div class="row">
                <article class="col-lg-6 col-md-6 col-12 order-lg-0 order-md-0 order-1 mt-5">
                    <h5 class="text-center text-uppercase mb-3">
                        <i class="bi bi-envelope-paper h4"></i> Formulario de Contacto
                    </h5>
                    <hr>
                    <form method="POST" action="<?= base_url('contacto') ?>">
                        <?= csrf_field() ?>
                        <fieldset>
                            <legend class="visually-hidden">Formulario de Contacto</legend>
                            <!-- Campo: Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="bi bi-person-vcard"></i> Nombre:
                                </label>
                                <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>"
                                    id="nombre" name="nombre"
                                    value="<?= $usuario ? esc($usuario->nombre) : old('nombre') ?>"
                                    placeholder="Ingrese su Nombre"
                                    <?= $usuario ? 'readonly' : '' ?>>
                                <?php if (session('errors.nombre')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nombre') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Correo Electrónico -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope-at"></i> Correo Electrónico:
                                </label>
                                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                                    id="email" name="email"
                                    value="<?= $usuario ? esc($usuario->email) : old('email') ?>"
                                    placeholder="example@random.com"
                                    <?= $usuario ? 'readonly' : '' ?>>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                            // Si se pasa un nombre de producto en la URL, se autocompleta el asunto y mensaje
                            $productoNombre = isset($_GET['producto']) ? urldecode($_GET['producto']) : '';
                            $asuntoPredeterminado = $productoNombre ? "Consulta sobre $productoNombre" : '';
                            $mensajePredeterminado = $productoNombre ? "Hola! Me interesa tener más información sobre $productoNombre." : '';
                            ?>
                            <!-- Campo: Asunto -->
                            <div class="mb-3">
                                <label for="asunto" class="form-label">
                                    <i class="bi bi-card-checklist"></i> Asunto:
                                </label>
                                <input type="text" class="form-control <?= session('errors.asunto') ? 'is-invalid' : '' ?>"
                                    id="asunto" name="asunto"
                                    value="<?= old('asunto') ?? $asuntoPredeterminado ?>"
                                    placeholder="Ingrese el Asunto">
                                <?php if (session('errors.asunto')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.asunto') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Campo: Mensaje -->
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">
                                    <i class="bi bi-file-text"></i> Mensaje:
                                </label>
                                <textarea rows="12" class="form-control <?= session('errors.mensaje') ? 'is-invalid' : '' ?>"
                                    id="mensaje" name="mensaje"
                                    placeholder="Escribe tu mensaje aquí..."><?= old('mensaje') ?? $mensajePredeterminado ?></textarea>
                                <?php if (session('errors.mensaje')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.mensaje') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-center d-flex justify-content-around">
                                <button type="reset" class="btn btn-producto-agregar" id="btn-limpiar">
                                    <i class="bi bi-eraser"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-producto-mensaje">
                                    <i class="bi bi-send"></i> Enviar
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </article>
                <!-- Columna: Información de Contacto (detalles adicionales) -->
                <article class="col-lg-6 col-md-6 col-12 order-lg-1 order-md-1 order-0 mt-5">
                    <h5 class="text-center text-uppercase mb-3">
                        <i class="bi bi-info-square h4"></i> Información
                    </h5>
                    <div class="mx-3">
                        <hr>
                        <h6>Propietarios:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-people-fill"></i> Juan Carlos Pastore y Romina Sol Almada
                        </p>
                        <hr>
                        <h6>Nuestra ubicación:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-geo-alt-fill"></i> Mendoza 1194 - Corrientes - Corrientes - Argentina
                        </p>
                        <hr>
                        <h6>Medios de comunicación:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-whatsapp"></i> (+54) 379 440-6775
                        </p>
                        <p class="fw-bold">
                            <i class="bi bi-envelope-at-fill"></i> TattooSupplyStoreOk@gmail.com
                        </p>
                        <hr>
                        <div class="text-center">
                            <div class="d-flex ">
                                <i class="bi bi-clock-fill me-1"></i>
                                <p class="mb-0">Horarios</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Día</th>
                                            <th>Horario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lunes a Sábado</td>
                                            <td>9:00 am - 7:00 pm</td>
                                        </tr>
                                        <tr>
                                            <td>Domingos</td>
                                            <td>9:00 am - 1:00 pm</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?= view("layouts/footer-cliente") ?>

<script>
    // Agregar funcionalidad para limpiar campos (si es necesario)
    document.addEventListener('DOMContentLoaded', function() {
        var btnLimpiar = document.getElementById('btn-limpiar');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function(event) {
                event.preventDefault();
                var form = btnLimpiar.closest('form');
                if (form) {
                    form.reset();
                }
            });
        }
    });
</script>