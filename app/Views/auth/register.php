<!-- Sección de Registro -->
<section class="container">

    <div class="card container my-5" id="cardRegistroPersonalizado">

        <div class="my-4 text-center" id="cabeceraFormRegistro">
            <legend class="h2 mb-3">Crear Cuenta</legend>

            <div class="mb-2">
                <span class="form-text" id="leyendaFormRegistro">
                    Comprá más rápido y llevá el control de tus pedidos, ¡en un solo lugar!
                </span>
            </div>
        </div>

        <form class="my-3 px-0 px-lg-5" action="<?= base_url('registro') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3 ">
                <label for="nombre" class="form-label text-white">Nombre</label>
                <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= old('nombre') ?>" placeholder="Nombre/s">
                <?php if (session('errors.nombre')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.nombre') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3 ">
                <label for="apellido" class="form-label text-white">Apellido</label>
                <input type="text" class="form-control <?= session('errors.apellido') ? 'is-invalid' : '' ?>" id="apellido" name="apellido" value="<?= old('apellido') ?>" placeholder="Apellido/s">
                <?php if (session('errors.apellido')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.apellido') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-white">Correo Electrónico</label>
                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="example@random.com">
                <?php if (session('errors.email')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.email') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-white">Contraseña</label>
                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Contraseña">
                <?php if (session('errors.password')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.password') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label text-white">Confirmar Contraseña</label>
                <input type="password" class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Repetir Contraseña">
                <?php if (session('errors.confirm_password')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.confirm_password') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label text-white">Dirección de Domicilio</label>
                <input type="text" class="form-control <?= session('errors.direccion') ? 'is-invalid' : '' ?>" id="direccion" name="direccion" value="<?= old('direccion') ?>" placeholder="Ejemplo:Av. Siempre Viva 742">
                <?php if (session('errors.direccion')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.direccion') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label text-white">Teléfono</label>
                <input type="tel" class="form-control  <?= session('errors.telefono') ? 'is-invalid' : '' ?>" id="telefono" name="telefono" value="<?= old('telefono') ?>" placeholder="1193456890">
                <?php if (session('errors.telefono')) : ?>
                    <div class="invalid-feedback">
                        <span class="text-sm">
                            <?= session('errors.telefono') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-check my-3">
                <input type="checkbox" name="terms" class="form-check-input" id="terms" value="1" >
                <label class="form-check-label text-white" for="terms">Acepto los <a href="<?= site_url('terminos') ?>" target="_blank">términos y condiciones</a></label>
                <?php if (session('errors.terms')) : ?>
                    <div class="text-danger">
                        <span class="small">
                            <?= session('errors.terms') ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-line my-3">
                <p class="text-white">
                    Ya tienes una cuenta? <a href="<?= site_url('login'); ?>">Ingresar</a>
                </p>
            </div>

            <div class="text-center my-4">
                <button type="submit" class="btn btn-lg btn-success ">Registrar</button>
            </div>
        </form>
    </div>
</section>