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
                            <a class="nav-link" href="<?= site_url('contacto'); ?>">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                        </li>
                    </ul>

                    <!-- Opciones adicionales para clientes -->
                    <ul class="navbar-nav d-flex align-content-md-center align-content-start gap-3 justify-content-start justify-content-lg-end">
                        <!-- Carrito -->
                        <li class="nav-item dropdown mx-3">
                            <!-- Botón del carrito con dropdown-toggle -->
                            <a class="btn btn-nav-personalizado position-relative p-0"
                                href="<?= base_url('carrito'); ?>"
                                id="cartDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                aria-label="Ver carrito">
                                <i class="bi bi-cart3 fs-4"></i>
                                <?php if ($cart->totalItems() > 0): ?>
                                    <span id="cartCounter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= $cart->totalItems() ?>
                                    </span>
                                <?php endif; ?>
                            </a>


                            <!-- Dropdown que muestra el resumen del carrito -->
                            <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="cartDropdown" style="min-width: 300px;">
                                <?php if ($cart->totalItems() > 0): ?>
                                    <!-- Encabezado del resumen -->
                                    <li class="dropdown-header text-center">Productos en tu carrito</li>
                                    <?php foreach ($cart->contents() as $item): ?>
                                        <li class="dropdown-item">
                                            <div class="d-flex align-items-center">
                                                <!-- Imagen del producto -->
                                                <img src="<?= base_url($item['image'] ?? 'uploads/productos/no-image.png') ?>"
                                                    alt="<?= esc($item['name']) ?>"
                                                    class="img-thumbnail me-2"
                                                    style="width: 40px; height: auto;">
                                                <!-- Información del producto -->
                                                <div class="flex-grow-1">
                                                    <div class="truncate" style="max-width: 160px;">
                                                        <strong><?= esc($item['name']) ?></strong>
                                                    </div>
                                                    <small class="text-muted">x <?= $item['qty'] ?> - $<?= number_format($item['qty'] * $item['price'], 2) ?></small>
                                                </div>
                                                <!-- Botón para quitar este producto -->
                                                <a href="<?= base_url('carrito/quitar/' . esc($item['rowid'])) ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Eliminar">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <!-- Total del carrito -->
                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>Total:</span>
                                        <strong>$<?= number_format($cart->total(), 2) ?></strong>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <!-- Botones de acción -->
                                    <li class="dropdown-item">
                                        <div class="d-flex flex-column gap-2">
                                            <a href="<?= base_url('carrito/borrar') ?>" class="btn btn-vaciar-carrito btn-sm">Vaciar Carrito</a>
                                            <a href="<?= base_url('carrito'); ?>" class="btn btn-ver-carrito btn-sm">Ver Carrito</a>
                                            <a href="<?= base_url('checkout/seleccionarDireccion') ?>" class="btn btn-finalizar-compra btn-sm">Finalizar Compra</a>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li class="dropdown-item text-center">Carrito vacío</li>
                                <?php endif; ?>
                            </ul>
                        </li>


                        <!-- Dropdown para el usuario cliente -->
                        <li class="nav-item dropdown mx-3">
                            <!-- Ícono de usuario para desplegar el dropdown -->
                            <a class="nav-link p-0" href="#" id="clienteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4 text-white"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-cliente" aria-labelledby="clienteDropdown">
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
                            <a class="nav-link" href="<?= site_url('contacto'); ?>">Contacto</a>
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