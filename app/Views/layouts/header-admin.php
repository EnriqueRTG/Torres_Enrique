<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=width, initial-scale=1.0">
    <title><?= $titulo ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/bootstrap/icons/font/bootstrap-icons.css'); ?>" rel="stylesheet">

    <!-- CSS -->
    <link href="<?= base_url('assets/css/my_styles_dashboard.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<body class="container-fluid mx-0 px-0">

    <header>

        <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary bg-dark py-4" data-bs-theme="dark">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarCenteredExample" aria-controls="navbarCenteredExample" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample">
                    <!-- Left links -->
                    <ul class="navbar-nav mb-2 mb-lg-0 gap-3">
                        <li class="nav-item nav-item-per">
                            <a class="nav-link" aria-current="page" href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a>
                        </li>

                        <li class="nav-item dropdown nav-item-per">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Mensajes
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

                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown nav-item-per">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url() ?><?= route_to('logout'); ?>">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>

    </header>