<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal: contenido de la página de Contacto -->
<main class="container my-3 main-content" tabindex="0">
    <!-- Mensajes de sesión: alertas de éxito o error -->
    <div class="alert-info text-center container">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Tarjeta principal de "Info. de Contacto" -->
    <section class="card shadow-sm my-3">
        <!-- Encabezado de la tarjeta -->
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Información de Contacto</h2>
        </header>

        <!-- Cuerpo de la tarjeta: Distribución en dos columnas -->
        <div class="card-body">
            <!-- Introducción general -->
            <p class="card-text text-center">
                Si necesitas información sobre nuestros artículos o deseas enviarnos algún comentario para mejorar el servicio, no dudes en contactarnos. ¡Estamos atentos a lo que tengas para decirnos!
            </p>

            <div class="row g-4">
                <!-- Columna: Formulario de Contacto -->
                <article class="col-lg-6 col-md-6 col-12 order-lg-0 order-md-0 order-1 mt-5">
                    <h5 class="text-center text-uppercase mb-3">
                        <i class="bi bi-envelope-paper h4"></i> Formulario de Contacto
                    </h5>
                    <hr>
                    <!-- Formulario de Contacto -->
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
                                    id="nombre" name="nombre" value="<?= old('nombre') ?>"
                                    placeholder="Ingrese su Nombre">
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
                                    id="email" name="email" value="<?= old('email') ?>"
                                    placeholder="example@random.com">
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>


                            <?php
                            // Obtener el nombre del producto desde la URL (si existe)
                            $productoNombre = isset($_GET['producto']) ? urldecode($_GET['producto']) : '';

                            // Texto predefinido para el asunto y mensaje
                            $asuntoPredeterminado = $productoNombre ? "Consulta sobre $productoNombre" : '';
                            $mensajePredeterminado = $productoNombre ? "Hola! Me interesa tener más información sobre $productoNombre." : '';
                            ?>

                            <!-- Campo: Asunto -->
                            <div class="mb-3">
                                <label for="asunto" class="form-label">
                                    <i class="bi bi-card-checklist"></i> Asunto:
                                </label>
                                <input type="text" class="form-control <?= session('errors.asunto') ? 'is-invalid' : '' ?>"
                                    id="asunto" name="asunto" value="<?= old('asunto') ?? $asuntoPredeterminado ?>"
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

                            <!-- Botón de Envío -->
                            <div class="text-center d-flex justify-content-around">
                                <button type="reset" class="btn btn-producto-agregar" id="btn-limpiar">
                                    <i class="bi bi-eraser"></i> limpiar
                                </button>
                                <button type="submit" class="btn btn-producto-mensaje">
                                    <i class="bi bi-send"></i> Enviar
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </article>

                <!-- Columna: Información de Contacto -->
                <article class="col-lg-6 col-md-6 col-12 order-lg-1 order-md-1 order-0 mt-5">
                    <h5 class="text-center text-uppercase mb-3">
                        <i class="bi bi-info-square h4"></i> Información
                    </h5>
                    <div class="mx-3">
                        <hr>
                        <!-- Propietarios -->
                        <h6>Propietarios:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-people-fill"></i> Juan Carlos Pastore y Romina Sol Almada
                        </p>
                        <hr>
                        <!-- Ubicación -->
                        <h6>Nuestra ubicación:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-geo-alt-fill"></i> Mendoza 1194 - Corrientes - Corrientes - Argentina
                        </p>
                        <hr>
                        <!-- Medios de comunicación -->
                        <h6>Medios de comunicación:</h6>
                        <p class="fw-bold">
                            <i class="bi bi-whatsapp"></i> (+54) 379 440-6775
                        </p>
                        <p class="fw-bold">
                            <i class="bi bi-envelope-at-fill"></i> TattooSupplyStoreOk@gmail.com
                        </p>
                        <hr>
                        <!-- Sección: Horarios de Atención -->
                        <div class="text-center">
                            <!-- Encabezado del bloque de horarios -->
                            <div class="d-flex ">
                                <i class="bi bi-clock-fill me-1"></i>
                                <p class="mb-0">Horarios</p>
                            </div>
                            <!-- Tabla responsiva con efecto cebra para los horarios -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Día</th>
                                            <th scope="col">Horario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lunes a Sábado</td>
                                            <td>9:00 am - 7:00 pm (Jornada continua)</td>
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

    <!-- Sección: Visítanos (Mapa de Ubicación) -->
    <section class="pt-5">
        <article class="card shadow-sm">
            <header class="card-header text-center bg-transparent border-0">
                <h2 class="titulo-seccion text-uppercase">
                    <i class="bi bi-shop"></i> Visítanos
                </h2>
            </header>
            <!-- Iframe responsivo para la ubicación -->
            <section id="ubicacion" class="container my-3">
                <div class="embed-responsive embed-responsive-16by9 shadow p-3 bg-white rounded">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d303.9827267431783!2d-58.83574120545759!3d-27.470911618713988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca235e1fb8f%3A0x9bdef32943f1a9c!2sCCO%2C%20Mendoza%201194%2C%20W3400%20Corrientes!5e0!3m2!1ses!2sar!4v1682285923762!5m2!1ses!2sar" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
        </article>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnLimpiar = document.getElementById('btn-limpiar');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', function(event) {
                event.preventDefault(); // Evita el comportamiento predeterminado del botón

                var form = btnLimpiar.closest('form');
                if (form) {
                    form.reset(); // Resetea el formulario a su estado inicial

                    // Borrar manualmente los campos autocompletados desde PHP
                    document.getElementById('asunto').value = "";
                    document.getElementById('mensaje').value = "";
                }
            });
        }
    });
</script>