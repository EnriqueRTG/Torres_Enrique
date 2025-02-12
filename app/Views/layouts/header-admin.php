<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta etiquetas básicas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo) ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="<?= base_url('assets/icons/bootstrap-icons.css'); ?>" rel="stylesheet">

    <!-- CSS personalizado para el dashboard -->
    <link href="<?= base_url('assets/css/my_styles_dashboard.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Swiper CSS local -->
    <link rel="stylesheet" href="<?= base_url('assets/swiper/swiper-bundle.min.css'); ?>">


    <style>
        /* Sticky footer con Flexbox */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body>
    <!-- Header principal con navegación -->
    <header>
        <!-- Navbar de Bootstrap (responsive y con tema oscuro) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-4" data-bs-theme="dark">
            <div class="container-fluid">
                <!-- Botón de toggle para vistas móviles -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCenteredExample" aria-controls="navbarCenteredExample" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
                <!-- Menú colapsable centrado -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
                    <ul class="navbar-nav mb-2 mb-lg-0 gap-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">Tienda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Mensajes
                                <!-- Badge para mensajes no leídos -->
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    99+
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Consultas
                                        <span class="badge text-bg-warning">4</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Contactos
                                        <span class="badge text-bg-warning">4</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Dropdown para opciones del admin -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url() ?><?= route_to('logout'); ?>">Salir</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>