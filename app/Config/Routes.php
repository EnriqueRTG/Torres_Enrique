<?php

use App\Controllers\Catalogo;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);

$routes->group('dashboard', ['namespace'
    => '\App\Controllers\Dashboard'], function ($routes) {
            $routes->presenter('categoria');
            $routes->presenter('subcategoria');
            $routes->presenter('marca');
            $routes->presenter('usuario');
            $routes->presenter('producto');
        });

//principal
$routes->get('/', 'Principal::index');

// Quienes somos
$routes->get('/nosotros', 'Nosotros::index');

// Comercializacion
$routes->get('/comercializacion', 'Comercializacion::index');
$routes->get('/comercializacion/metodos', 'Comercializacion::obtenerMetodos');

// Contacto
$routes->get('/contacto', 'Contacto::index');
$routes->get('/contacto/ubicacion', 'Contacto::obtenerUbicacion');

// Terminos y usos
$routes->get('/terminos', 'Terminos::index');

// Garantia
$routes->add('/garantia', 'Garantia::index');

// Catalogo
$routes->get('/catalogo', 'Catalogo::index');

// Registro
$routes->get('/registro', 'Registro::index');