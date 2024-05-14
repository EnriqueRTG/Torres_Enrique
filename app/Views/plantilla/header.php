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
                        <a class="navbar-brand mx-0" href="<?php echo base_url(); ?>">
                            <img id="logo-nav" class="rounded" src="<?= base_url(); ?>assets/images/logos/Logo.png" alt="Logo">
                        </a>
                        <ul class="navbar-nav mb-2 mb-lg-0 mx-0 mx-lg-5">
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" aria-current="page" href="<?php echo base_url(); ?>">Principal</a>
                            </li>
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" href="<?php echo base_url('catalogo'); ?>">Catalogo</a>
                            </li>
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" href="<?php echo base_url('nosotros'); ?>">Nosotros</a>
                            </li>
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" href="<?php echo base_url('comercializacion'); ?>">Comercialización</a>
                            </li>
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" href="<?php echo base_url('contacto'); ?>">Contacto</a>
                            </li>
                            <li class="nav-item nav-item-per">
                                <a class="nav-link" href="<?php echo base_url('terminos'); ?>">Términos y usos</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav gap-3 mx-0">
                            <li class="nav-item">
                                <a class="btn btn-nav-personalizado" data-bs-toggle="modal" data-bs-target="#ingresarModalCenteredScrollable">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Ingresar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-nav-personalizado" href="<?php echo base_url('registro'); ?>">
                                    Registrarse
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="modal fade" id="ingresarModalCenteredScrollable" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" id="modalContenidoIngresar">
                            <div class="modal-header">
                                <h5 class="modal-title">Ingresar</h5>
                                <button type="button" class="btn-close bg-white " data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form>
                                <div class="modal-body">

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput" id="labelCorreo">Correo electrónico</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                        <label for="floatingPassword" id="labelContrasenia">Contraseña</label>
                                    </div>

                                    <hr class="my-3">

                                    <div class="form-line">
                                        <p>
                                            No tienes una cuenta? <a href="<?php echo base_url('registro'); ?>">Registrarse</a>
                                        </p>
                                    </div>

                                </div>

                                <div class="modal-footer justify-content-center gap-5">
                                    <button type="button" class="btn btn-subtle btn-danger" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Cerrar
                                    </button>
                                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </header>