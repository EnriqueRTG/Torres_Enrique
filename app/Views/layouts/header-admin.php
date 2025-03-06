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

    <!-- icono de la pestaña -->
    <link rel="icon" href="<?= base_url('assets/images/icono/Logo.ico') ?>" type="image/x-icon">

    <style>
        /* Estilos para lograr un footer pegajoso usando Flexbox */
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

        /* Dropdown se despliega al pasar el cursor (solo en pantallas grandes) */
        @media (min-width: 992px) {
            .navbar-nav .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>