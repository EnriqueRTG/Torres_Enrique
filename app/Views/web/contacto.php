<!-- Sección de contacto -->
<section class="container">

    <div class="card container user-select-none mt-2">
        <p class="card-header mt-3 shadow-lg titulo-seccion banner-seccion">
            Info. de Contacto
        </p>
        <!-- Formulario e Informacion-->
        <div class="card-body vstack gap-3">
            <p class="card-text card-texto">
                Ante la necesidad de cualquier información por alguno de nuestros artículos o cualquier comentario que
                nos permita mejorar el servicio, no dudes en hacernos llegar tu mensaje por medio de algunos de nuestros
                canales de comunicación. Estamos atentos a lo que tengas para decirnos!
            </p>
            <!-- Formulario e informacion -->
            <div class="row justify-content-between mt-3 card-texto">
                <!-- Formulario-->
                <div class="col col-lg-6 col-md-6 col-12 order-lg-0 order-md-0 order-1 my-lg-0 my-3">
                    <!-- Título del formulario de contacto -->
                    <h5 class="text-center my-3 etiqueta text-uppercase">
                        <i class="bi bi-envelope-paper h4"></i>
                        Formulario de Contacto
                    </h5>
                    <hr class="mb-4">
                    <div class="container mb-4">
                        <div class="row mx-2">
                            <!-- Campo de ingreso de correo electrónico -->
                            <form method="POST" action="<?php echo base_url('contacto') ?>">
                                <?= csrf_field() ?>
                                <fieldset>
                                    <!-- Nombre -->
                                    <div class="form-group">
                                        <label for="nombre" class="form-label mt-4 beige">
                                            <i class="bi bi-person-vcard"></i>
                                            Nombre:
                                        </label>
                                        <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Ingrese su Nombre">
                                        <?php if (session('errors.nombre')) : ?>
                                            <div class="invalid-feedback">
                                                <span class="text-sm">
                                                    <?= session('errors.nombre') ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email" class="form-label mt-4 beige">
                                            <i class="bi bi-envelope-at"></i>
                                            Correo Electrónico:
                                        </label>
                                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="example@random.com">
                                        <?php if (session('errors.email')) : ?>
                                            <div class="invalid-feedback">
                                                <span class="text-sm">
                                                    <?= session('errors.email') ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Asunto -->
                                    <div class="form-group">
                                        <label for="asunto" class="form-label mt-4 beige">
                                            <i class="bi bi-card-checklist"></i>
                                            Asunto:
                                        </label>
                                        <input type="text" class="form-control <?= session('errors.asunto') ? 'is-invalid' : '' ?>" id="asunto" name="asunto" value="<?= old('asunto') ?>" placeholder="Ingrese el Asunto">
                                        <?php if (session('errors.asunto')) : ?>
                                            <div class="invalid-feedback">
                                                <span class="text-sm">
                                                    <?= session('errors.asunto') ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Area de texto para los comentarios -->
                                    <div class="form-group">
                                        <label for="mensaje" class="form-label mt-4 beige">
                                            <i class="bi bi-file-text"></i>
                                            Mensaje:
                                        </label>
                                        <textarea type="text" rows="12" class="form-control <?= session('errors.mensaje') ? 'is-invalid' : '' ?>" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí..."><?= old('mensaje') ?></textarea>
                                        <?php if (session('errors.mensaje')) : ?>
                                            <div class="invalid-feedback">
                                                <span class="text-sm">
                                                    <?= session('errors.mensaje') ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <div class=" text-center">
                                            <button type="submit" class="btn btn-info btn-lg mt-4 fw-bold">
                                                <i class="bi bi-send"></i>
                                                Enviar
                                            </button>
                                        </div>

                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Informacion -->
                <div class="col col-lg-6 col-md-6 col-12 order-lg-1 order-md-1 order-0 my-lg-0 my-3">
                    <h5 class="text-center my-3 text-uppercase">
                        <i class="bi bi-info-square h4"></i>
                        Información
                    </h5>
                    <div class="mx-4">
                        <hr class="mb-4">
                        <!-- Titulas -->
                        <h6 class="">
                            Propietarios:
                        </h6>
                        <i class="bi bi-people-fill"></i>
                        Juan Carlos Pastore y Romina Sol Almada
                        <hr class="mb-4">
                        <!--Datos de ubicación -->
                        <h6 class="">
                            Nuestra ubicación:
                        </h6>
                        <div class="">
                            <p class="fw-bold">
                                <!-- Ubicación -->
                                <i class="bi bi-geo-alt-fill"></i>
                                Mendoza 1194 - Corrientes - Corrientes - Argentina
                            </p>
                        </div>
                        <hr>
                        <h6 class="">
                            Medios de comunicación:
                        </h6>
                        <!-- Teléfono -->
                        <div>
                            <p class="fw-bold">
                                <!-- Teléfono -->
                                <i class="bi bi-whatsapp"></i>
                                (+54) 379 440-6775
                            </p>
                        </div>
                        <!-- Correo electrónico -->
                        <div>
                            <p class="fw-bold">
                                <!-- Email -->
                                <i class="bi bi-envelope-at-fill"></i>
                                TattooSupplyStoreOk@gmail.com
                            </p>
                        </div>

                        <!-- Horario de atención (IMG)-->
                        <div class=" text-center">
                            <hr class="mb-4">
                            <!-- Horarios -->
                            <div class=" d-flex">
                                <i class="bi bi-clock-fill m-1"></i>
                                <p class="m-1">Horarios</p>
                            </div>
                            <img id="img-contacto-horarios" src="<?php echo base_url("assets/images/contacto/horarios.png") ?>" class="img-fluid mb-4 mt-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mt-5 pt-5">

    <div class="card container user-select-none">
        <p class="card-header mt-3 shadow-lg titulo-seccion banner-seccion">
            <i class="bi bi-shop"></i>
            Visitanos
        </p>

        <!-- Iframe de la ubicacion -->
        <section class="container mt-2" id="ubicacion">
            <div class="embed-responsive embed-responsive-16by9 shadow p-3 mb-5 bg-white rounded">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d303.9827267431783!2d-58.83574120545759!3d-27.470911618713988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca235e1fb8f%3A0x9bdef32943f1a9c!2sCCO%2C%20Mendoza%201194%2C%20W3400%20Corrientes!5e0!3m2!1ses!2sar!4v1682285923762!5m2!1ses!2sar" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
        </section>
    </div>
</section>