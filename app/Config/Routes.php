<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);

$routes->group('dashboard', ['namespace' => '\App\Controllers\Admin'], function ($routes) {
    $routes->presenter('panel');
    $routes->presenter('categoria');
    $routes->presenter('subcategoria');
    $routes->presenter('marca');
    $routes->presenter('cliente');
    $routes->presenter('producto');
});

$routes->group('', function ($routes) {
    // Principal
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
    $routes->get('registro', 'Web\Usuario::register', ['as' => 'usuario.registrar']);
    $routes->post('registro', 'Web\Usuario::register_post', ['as' => 'usuario.registrar.post']);
    // Login
    $routes->get('login', 'Web\Usuario::login', ['as' => 'usuario.login']);
    $routes->post('login', 'web\Usuario::login_post', ['as' => 'usuario.login.post']);
    // Logout
    $routes->get('logout', 'Web\Usuario::logout', ['as' => 'usuario.logout']);
});

$routes->group('api', ['namespace' => '\App\Controllers\Api'], function ($routes) {
    $routes->resource('producto');
});
