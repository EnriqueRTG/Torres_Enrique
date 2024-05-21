<!-- Sección de Login -->
<section class="container mb-5 pb-5">

    <div class="card container my-5" id="cardRegistroPersonalizado">

        <form class="my-3 px-5" action="<?php echo base_url('login') ?>" method="POST">

            <div class="my-4 text-center" id="cabeceraFormRegistro">
                <legend class="h2 mb-3">Ingresar</legend>

                <div class="mb-3">
                    <span class="form-text" id="leyendaFormRegistro">
                        Comprá más rápido y llevá el control de tus pedidos, ¡en un solo lugar!
                    </span>
                </div>

                <!--Mensaje -->
                <section class="text-center">
                    <?= view('partials/_session-error') ?>
                </section>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="email" placeholder="Correo electrónico aquí">
                <label for="email">Correo electrónico</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña aquí">
                <label for="floatingPassword">Contraseña</label>
            </div>

            <div class="form-line my-3">
                <p class="text-white">
                    No tienes una cuenta? <a href="<?php echo base_url('registro'); ?>">Registrarse</a>
                </p>
            </div>

            <div class="text-center my-4">
                <button type="submit" class="btn btn-lg btn-success ">iniciar Sesión</button>
            </div>

        </form>

    </div>
</section>