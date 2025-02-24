<!-- Navbar personalizado para el cliente -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" id="navbar-personalizacion">

    <div class="container">
        <!-- Aquí usas la clase "container" en lugar de "container-fluid" para agregar márgenes laterales -->
        <a class="navbar-brand" href="<?= site_url(); ?>">
            <img id="logo-nav" class="rounded" src="<?= site_url(); ?>assets/images/logos/Logo.png" alt="Logo">
        </a>

        <!-- Botón de menú para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido colapsable del Navbar -->
        <div class="collapse navbar-collapse justify-content-center gap-5" id="navbarTogglerDemo01">

            <!-- Menú de navegación dinámico según el rol del usuario -->
            <?php if (session()->get('usuario')) : ?>

                <?php if (session()->get('usuario')->rol == ROL_CLIENTE) : ?>

                    <!-- Menú para clientes -->
                    <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                        </li>
                    </ul>

                    <!-- Opciones adicionales para clientes -->
                    <ul class="navbar-nav d-flex align-content-md-center align-content-start gap-3 justify-content-start justify-content-lg-end">
                        <!-- Carrito -->
                        <li class="nav-item mx-3">
                            <a class="btn btn-nav-personalizado position-relative p-0" href="<?= base_url('carrito'); ?>" aria-label="Ver carrito">
                                <i class="bi bi-cart3 fs-4"></i>
                                <?php if ($cart->totalItems() > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= $cart->totalItems() ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- Dropdown para el usuario cliente -->
                        <li class="nav-item dropdown mx-3">
                            <!-- Ícono de usuario para desplegar el dropdown -->
                            <a class="nav-link p-0" href="#" id="clienteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4 text-white"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="clienteDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('cliente/perfil'); ?>">
                                        <i class="bi bi-person"></i> Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('cliente/pedidos'); ?>">
                                        <i class="bi bi-bag-check"></i> Pedidos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('cliente/mensajes'); ?>">
                                        <i class="bi bi-envelope"></i> Mensajes
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url() ?><?= route_to('logout'); ?>">
                                        <i class="bi bi-box-arrow-right"></i> Salir
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>



                <?php elseif (session()->get('usuario')->rol == ROL_ADMIN): ?>

                    <!-- Menú para administradores -->
                    <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                        </li>
                    </ul>

                    <!-- Opciones adicionales para administradores -->
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item">
                            <a class="btn btn-nav-personalizado btn-custom" href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-nav-personalizado btn-custom" href="<?= base_url() ?><?= route_to('logout'); ?>">Salir</a>
                        </li>
                    </ul>
                <?php endif; ?>

            <?php else: ?>

                <!-- Menú para usuarios no autenticados -->
                <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('contacto'); ?>">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                    </li>
                </ul>

                <!-- Opciones para usuarios no autenticados -->
                <ul class="navbar-nav gap-3">
                    <li class="nav-item">
                        <a class="btn btn-nav-personalizado btn-custom" href="<?= base_url('login'); ?>">Ingresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav-personalizado btn-custom" href="<?= base_url('registro'); ?>">Registrarse</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Solo aplicar hover si la ventana es mayor a 992px (por ejemplo, desktop)
        if (window.innerWidth >= 992) {
            const dropdownContainer = document.getElementById("clienteDropdown").parentElement;
            let timeout;

            dropdownContainer.addEventListener("mouseenter", function() {
                clearTimeout(timeout);
                const dd = new bootstrap.Dropdown(document.getElementById("clienteDropdown"));
                dd.show();
            });

            dropdownContainer.addEventListener("mouseleave", function() {
                timeout = setTimeout(function() {
                    const dd = new bootstrap.Dropdown(document.getElementById("clienteDropdown"));
                    dd.hide();
                }, 300);
            });
        }
    });
</script>