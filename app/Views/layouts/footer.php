<!-- Footer-->
<footer class="mt-3" id="footer-cliente">

    <div class="container">

        <section id="contenedor-lista-enlaces" class="row py-2">

            <ul class="nav col justify-content-center nav-pills nav-fill p-3 gap-3">
                <li class="nav-item">
                    <a href="<?= base_url('garantia') ?>" class="nav-link text-uppercase">Garantía</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('comercializacion/formas_de_pago') ?>" class="nav-link text-uppercase">Formas de Pago</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('contacto/ubicacion') ?>" class="nav-link text-uppercase">Ubicación</a>
                </li>
            </ul>

        </section>

        <section class="row text-center">
            <a href="<?= base_url() ?>" class="col">
                <img id="logo-footer" src="<?php echo base_url(); ?>assets/images/logos/LOGO-TRANSPARENTE.png" class="img-fluid">
            </a>
        </section>

        <section class="row align-items-baseline">

            <section class="col col-lg-6 col-12 order-lg-0 order-1">
                <ul class="nav justify-content-lg-start justify-content-center align-items-baseline">
                    <li>
                        <p class="text-center">Tatto Supply Store &middot; &copy; <?php echo date('Y') ?>
                            <br>
                            <span class="span-link-github">
                                by <a id="link-github" href="https://github.com/EnriqueRTG" target="_blank">EnriqueRTG</a>
                            </span>
                        </p>
                    </li>
                </ul>
            </section>

            <section class="col col-lg-6 col-12 order-lg-1 order-0">
                <ul class="nav justify-content-lg-end justify-content-center align-items-baseline">
                    <li>
                        <p>Seguinos en:</p>
                    </li>
                    <li class="nav-item icono-footer">
                        <a href="https://www.instagram.com/torresgamarraenrique/" class="nav-link px-3" target="_blank"><i class="bi bi-instagram"></i></a>
                    </li>
                    <li class="nav-item icono-footer">
                        <a href="https://www.facebook.com/enriqueramon.torresgamarra" class="nav-link px-3" target="_blank"><i class="bi bi-facebook"></i></a>
                    </li>
                </ul>
            </section>

        </section>

    </div>
    </section>

</footer>

<!-- JavaScript loaded here for faster Page Loading. ------------------------ -->

<!-- Load jquery 3.7.1 here for faster page loads. -->
<script src="<?= base_url('assets/js/jquery/jquery-3.7.1.min.js'); ?>"></script>

<!-- Optional JavaScript; choose one of the two! -->


<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Option 2: mi scripts -->
<!-- <script src="<?= base_url('assets/js/my_script.js'); ?>"></script> -->

</body>

</html>