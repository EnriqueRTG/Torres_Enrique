<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);

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

