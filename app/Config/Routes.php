<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);



$routes->group('', function ($routes) {
    $routes->get('/', 'Web\Home::index', ['as' => 'web.home']); // Home
    $routes->get('nosotros', 'Web\Nosotros::index'); // Nosotros
    $routes->get('comercializacion', 'Web\Comercializacion::index'); // Comercializacion
    $routes->get('comercializacion/formas_de_pago', 'Web\Comercializacion::obtener_metodos'); // Comercializacion-Metodos de Pago

    $routes->group('contacto', function ($routes) { // Contacto
        $routes->get('/', 'Web\Contacto::index');
        $routes->post('/', 'Web\Contacto::enviar_contacto');
    });

    $routes->get('contacto/ubicacion', 'Web\Contacto::obtener_ubicacion'); // Contacto-Ubicacion
    $routes->get('terminos', 'Web\Terminos::index'); // Terminos y usos
    $routes->add('garantia', 'Web\Garantia::index'); // Garantias

    $routes->get('catalogo', 'Web\Catalogo::index', ['as' => 'web.catalogo']); // Catalogo
    $routes->get('producto/(:num)', 'Web\Catalogo::show/$1', ['as' => 'producto']); // Producto del catalogo
    $routes->get('carrito', 'Web\Carrito::index'); // Carrito
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'admin.dashboard']); // panel del admin (Dashboard)
    $routes->resource('productos', ['controller' => 'Admin\Producto']); // Producto

    $routes->group('consultas', function ($routes) { // Consulta
        $routes->get('/', 'Admin\Consulta::index');
        $routes->get('(:num)', 'Admin\Consulta::view/$1');
    });

    $routes->group('contactos', function ($routes) { // Contacto
        $routes->get('/', 'Admin\Contacto::index');
        $routes->get('(:num)', 'Admin\Contacto::view/$1');
    });

    $routes->resource('categorias', ['controller' => 'Admin\Products']); // Categoria
    $routes->resource('subcategorias'); // Subcategoria
    $routes->resource('marcas'); // Marca
    $routes->resource('clientes'); // Cliente
});

$routes->group('login', function ($routes) { // Login
    $routes->get('/', 'Auth\Login::index',  ['as' => 'login']);
    $routes->post('/', 'Auth\Login::login_post');
    $routes->get('logout', 'Auth\Login::logout', ['as' => 'logout']); // Ruta para el logout
});

$routes->group('registro', function ($routes) { // Registro
    $routes->get('/', 'Auth\Register::index');
    $routes->post('/', 'Auth\Register::register_post');
});
