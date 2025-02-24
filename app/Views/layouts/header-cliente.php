<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración de caracteres y viewport para responsividad -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($titulo) ?></title>

    <!-- Bootstrap CSS (local) -->
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="<?= base_url('assets/icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <!-- Estilos personalizados básicos -->
    <link href="<?= base_url('assets/css/my_styles.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Swiper CSS local -->
    <link rel="stylesheet" href="<?= base_url('assets/swiper/swiper-bundle.min.css'); ?>">

    <style>
        @media (min-width: 992px) {

            /* Cuando el mouse pase sobre el enlace del dropdown, se muestre el menú */
            .navbar-nav .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0.1rem;
                /* Ajusta el espacio si es necesario */
            }
        }
    </style>
</head>

<body class="container-fluid p-0 m-0">