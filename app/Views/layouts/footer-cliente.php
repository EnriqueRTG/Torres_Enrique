<!-- Footer -->
<footer class="bg-dark text-white py-4" id="footer-cliente">
    <div class="container">
        <!-- Primera fila: Secciones de información -->
        <div class="row">
            <!-- Columna 1: Servicio al Cliente -->
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase">Servicio al Cliente</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?= base_url('garantia') ?>" class="text-white text-decoration-none">
                            Garantía
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('comercializacion#formas-de-pago') ?>" class="text-white text-decoration-none">
                            Formas de Pago
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('contacto/ubicacion') ?>" class="text-white text-decoration-none">
                            Ubicación
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Columna 2: Acerca de Nosotros -->
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase">Acerca de Nosotros</h5>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?= site_url('nosotros') ?>" class="text-white text-decoration-none">
                            Nuestra Historia
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('contacto') ?>" class="text-white text-decoration-none">
                            Contacto
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('terminos') ?>" class="text-white text-decoration-none">
                            Términos y Usos
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Columna 3: Redes Sociales -->
            <div class="col-md-4 mb-3">
                <h5 class="text-uppercase">Síguenos</h5>
                <ul class="list-unstyled d-flex">
                    <li class="me-3">
                        <a href="https://www.instagram.com/torresgamarraenrique/" class="text-white fs-4" target="_blank" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/enriqueramon.torresgamarra" class="text-white fs-4" target="_blank" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Segunda fila: Logo y créditos -->
        <div class="row border-top pt-3">
            <div class="col text-center">
                <p class="mb-0 small text-white">
                    Tattoo Supply Store &middot; &copy; <?= date('Y') ?> &middot; by
                    <a href="https://github.com/EnriqueRTG" class="text-white text-decoration-none" target="_blank">
                        EnriqueRTG
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Cierre de JavaScript -->
<!-- jQuery (opcional, si se requiere) -->
<script src="<?= base_url('assets/js/jquery/jquery-3.7.1.min.js'); ?>"></script>
<!-- Bootstrap Bundle con Popper -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- Archivo de alertas -->
<script src="<?= base_url('assets/js/alerts.js'); ?>"></script>
<!-- Swiper JS local -->
<script src="<?= base_url('assets/swiper/swiper-bundle.min.js'); ?>"></script>
</body>

</html>