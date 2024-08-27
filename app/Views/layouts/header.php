<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=width, initial-scale=1.0">
    <title><?= $titulo ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/icons/bootstrap-icons.css'); ?>" rel="stylesheet">

    <!-- CSS -->
    <link href="<?= base_url('assets/css/my_styles.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<body class="container-fluid mx-0 px-0">

    <section id="contenido">
        <header>
            <!--Navbar-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar-personalizacion">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center gap-5" id="navbarTogglerDemo01">
                        <a class="navbar-brand mx-0" href="<?= site_url(); ?>">
                            <img id="logo-nav" class="rounded" src="<?= site_url(); ?>assets/images/logos/Logo.png" alt="Logo">
                        </a>
                        <?php if (session()->get('usuario')) : ?>
                            <?php if (session()->get('usuario')->rol_id == ROL_CLIENTE) : ?>
                                <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catalogo</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('consulta'); ?>">Consulta</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                                    </li>
                                </ul>
                                <ul class="navbar-nav gap-3 mx-0">
                                    <li class="nav-item">
                                        <a class="btn btn-nav-personalizado position-relative" href="<?= base_url('') ?><?= route_to('carrito'); ?>">
                                            <i class="bi bi-cart3"></i>
                                            <?php if ($cart->totalItems() > 0): ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <?= $cart->totalItems() ?>
                                                </span>
                                            <?php endif; ?>
                                        
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-nav-personalizado" href="<?= base_url() ?><?= route_to('logout'); ?>">
                                            Salir
                                        </a>
                                    </li>
                                </ul>
                            <?php elseif (session()->get('usuario')->rol_id == ROL_ADMIN): ?>
                                <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catalogo</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                                    </li>
                                    <li class="nav-item nav-item-per">
                                        <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                                    </li>
                                </ul>
                                <ul class="navbar-nav gap-3 mx-0">
                                    <li class="nav-item">
                                        <a class="btn btn-nav-personalizado" href="<?= base_url('admin/dashboard'); ?>">
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="btn btn-nav-personalizado" href="<?= base_url() ?><?= route_to('logout'); ?>">
                                            Salir
                                        </a>
                                    </li>
                                </ul>
                            <?php endif ?>
                        <?php else : ?>
                            <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" aria-current="page" href="<?= site_url(); ?>">Principal</a>
                                </li>
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" href="<?= site_url('catalogo'); ?>">Catalogo</a>
                                </li>
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" href="<?= site_url('nosotros'); ?>">Nosotros</a>
                                </li>
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" href="<?= site_url('comercializacion'); ?>">Comercialización</a>
                                </li>
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" href="<?= site_url('contacto'); ?>">Contacto</a>
                                </li>
                                <li class="nav-item nav-item-per">
                                    <a class="nav-link" href="<?= site_url('terminos'); ?>">Términos y usos</a>
                                </li>
                            </ul>
                            <ul class="navbar-nav gap-3 mx-0">
                                <li class="nav-item">
                                    <a class="btn btn-nav-personalizado" href="<?= base_url('login'); ?>">
                                        Ingresar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-nav-personalizado" href="<?= base_url('registro'); ?>">
                                        Registrarse
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container text-center">
            <?php if (session()->has('success')) : ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>

            <?php if (session()->has('mensaje')) : ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('mensaje') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>
        </div>