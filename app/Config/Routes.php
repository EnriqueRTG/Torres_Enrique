<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);



$routes->group('', function ($routes) {
    $routes->get('/', 'Web\Home::index', ['as' => 'web.home']); // Home
    $routes->get('nosotros', 'Web\Nosotros::index'); // Nosotros

    $routes->group('comercializacion', function ($routes) { // Contacto
        $routes->get('', 'Web\Comercializacion::index'); // Comercializacion
        $routes->get('formas_de_pago', 'Web\Comercializacion::obtener_metodos'); // Comercializacion-Metodos de Pago
    });

    $routes->group('contacto', function ($routes) { // Contacto
        $routes->get('', 'Web\Contacto::index');
        $routes->post('', 'Web\Contacto::contacto_post'); // Registro de Contacto
        $routes->get('ubicacion', 'Web\Contacto::obtener_ubicacion'); // Contacto-Ubicacion
    });

    $routes->get('terminos', 'Web\Terminos::index'); // Terminos y usos
    $routes->add('garantia', 'Web\Garantia::index'); // Garantias

    $routes->get('catalogo', 'Web\Catalogo::index', ['as' => 'web.catalogo']); // Catalogo
    $routes->get('producto/(:num)', 'Web\Catalogo::show/$1', ['as' => 'producto']); // Producto del catalogo
    
    $routes->group('carrito', function ($routes) { // Carrito
        $routes->get('', 'Carrito::index', ['as' => 'carrito']);
        $routes->post('agregar', 'Carrito::agregar');
        $routes->post('actualizar', 'Carrito::actualizar');
        $routes->post('eliminar', 'Carrito::eliminar');
        $routes->get('finalizar', 'Carrito::finalizarCompra');
    });
});

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'admin.dashboard']); // panel del admin (Dashboard)
    $routes->resource('productos', ['controller' => 'Admin\Producto']); // Producto

    $routes->group('consultas', function ($routes) { // Consulta
        $routes->get('', 'Admin\Consulta::index');
        $routes->get('(:num)', 'Admin\Consulta::view/$1');
    });

    $routes->group('contactos', function ($routes) { // Contacto
        $routes->get('', 'Admin\Contacto::index');
        $routes->get('(:num)', 'Admin\Contacto::view/$1');
    });

    $routes->resource('categorias', ['controller' => 'Admin\Products']); // Categoria
    $routes->resource('subcategorias'); // Subcategoria
    $routes->resource('marcas'); // Marca
    $routes->resource('clientes'); // Cliente
});

$routes->group('login', function ($routes) { // Login
    $routes->get('', 'Auth\Login::index',  ['as' => 'login']);
    $routes->post('', 'Auth\Login::login_post');
    $routes->get('logout', 'Auth\Login::logout', ['as' => 'logout']); // Ruta para el logout
});

$routes->group('registro', function ($routes) { // Registro
    $routes->get('', 'Auth\Register::index');
    $routes->post('', 'Auth\Register::register_post');
});



