<!-- Sección de Login -->
<section class="container mb-5 pb-5">

    <div class="card container my-5" id="cardRegistroPersonalizado">

        <form class="my-3 px-0 px-lg-5" action="<?= base_url('login') ?>" method="POST">
            <!-- Token -->
            <?= csrf_field(); ?>

            <div class="my-4 text-center" id="cabeceraFormRegistro">
                <legend class="h2 mb-3">Ingresar</legend>

                <div class="mb-3">
                    <span class="form-text" id="leyendaFormRegistro">
                        Comprá más rápido y llevá el control de tus pedidos, ¡en un solo lugar!
                    </span>
                </div>
            </div>

            <div class="form-floating my-5">
                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="Correo electrónico aquí">
                <label for="email">Correo electrónico</label>
                <?php if (session('errors.email')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.email') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-floating mb-5">
                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Contraseña aquí">
                <label for="password">Contraseña</label>
                <?php if (session('errors.password')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.password') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-line">
                <p class="text-white my-5">
                    No tienes una cuenta? <a href="<?= site_url('registro'); ?>">Registrarse</a>
                </p>
            </div>

            <div class="text-center my-4">
                <button type="submit" class="btn btn-lg btn-success ">iniciar Sesión</button>
            </div>

        </form>

    </div>
</section>