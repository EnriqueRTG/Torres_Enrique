<!-- Footer -->
<footer class="bg-dark pt-4" data-bs-theme="dark">
    <div class="container">
        <div class="text-center text-white">
            <!-- Información de copyright -->
            <p class="mb-0">
                Tattoo Supply Store &middot; &copy; <?= date('Y') ?>
            </p>
            <p>
                by <a href="https://github.com/EnriqueRTG" target="_blank" class="text-white text-decoration-underline">EnriqueRTG</a>
            </p>
        </div>
    </div>
</footer>

<script>
    // Define la variable global "base_url" usando la función base_url() de PHP
    const base_url = '<?= base_url() ?>';
</script>

<!-- Incluir el script modularizado para actualizar el conteo de los mensajes para los badges -->
<script src="<?= base_url('assets/js/badges.js') ?>"></script>

<!-- JavaScript: jQuery y Bootstrap Bundle (incluye Popper) -->
<!-- Nota: Si usas Bootstrap 5, jQuery es opcional, pero se incluye si es requerido en tu proyecto -->
<script src="<?= base_url('assets/js/jquery/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Swiper JS local -->
<script src="<?= base_url('assets/swiper/swiper-bundle.min.js'); ?>"></script>



</body>

</html>