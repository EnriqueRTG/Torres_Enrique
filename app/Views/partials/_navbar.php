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
                            <a class="nav-link" href="<?= site_url('consulta'); ?>">Consulta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                        </li>
                    </ul>

                    <!-- Opciones adicionales para clientes -->
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item">
                            <!-- Carrito de compras: con atributo aria-label para accesibilidad -->
                            <a class="btn btn-nav-personalizado position-relative" href="<?= route_to('carrito'); ?>" aria-label="Ver carrito">
                                <i class="bi bi-cart3"></i>
                                <?php if ($cart->totalItems() > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= $cart->totalItems() ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-nav-personalizado btn-custom" href="<?= route_to('logout'); ?>">Salir</a>
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
                            <a class="btn btn-nav-personalizado btn-custom" href="<?= route_to('logout'); ?>">Salir</a>
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