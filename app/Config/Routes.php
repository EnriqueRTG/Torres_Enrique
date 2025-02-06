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

    $routes->group('consulta', ['filter' => 'authCliente'], function ($routes) { // Consulta
        $routes->get('', 'Web\Consulta::index');
        $routes->post('', 'Web\Consulta::consulta_post'); // Registro de Consulta
    });

    $routes->get('terminos', 'Web\Terminos::index'); // Terminos y usos
    $routes->add('garantia', 'Web\Garantia::index'); // Garantias

    $routes->get('catalogo', 'Web\Catalogo::index', ['as' => 'web.catalogo']); // Catalogo
    $routes->get('producto/(:num)', 'Web\Catalogo::show/$1', ['as' => 'producto']); // Producto del catalogo

    $routes->get('visitas', 'Web\Visitas::index');
    $routes->get('visitas/obtener_visitas', 'Web\Visitas::obtener_visitas');
    $routes->post('visitas/incrementar_visita', 'Web\Visitas::incrementar_visita');

    $routes->group('carrito', ['filter' => 'authCliente'], function ($routes) { // Carrito
        $routes->get('', 'Web\Carrito::index');
        //$routes->post('actualizar', 'Web\Carrito::actualizar', ['as' => 'carrito.actualizar']);
        $routes->get('agregar/(:num)', 'Web\Carrito::agregar/$1', ['as' => 'carrito.agregar']);
        $routes->get('quitar/(:any)', 'Web\Carrito::quitar/$1', ['as' => 'carrito.quitar']);
        $routes->get('borrar', 'Web\Carrito::borrar', ['as' => 'carrito.borrar']);
        $routes->get('comprar', 'Web\Carrito::comprar');
        $routes->post('finalizarCompra', 'Web\Carrito::finalizarCompra');
    });

    $routes->group('compras', ['filter' => 'authCliente'], function ($routes) { // Facturacion
        $routes->get('', 'Web\Compras::index');
        $routes->get('detalle/(:num)', 'Web\Compras::detalle_compra/$1');
        $routes->get('descargar/(:num)', 'Web\Compras::descargar/$1');
        $routes->get('descargar_factura/(:num)', 'Web\Compras::descargar_factura/$1');
    });

    // Venta
    $routes->get('finalizar', 'Web\Carrito::finalizarCompra', ['as' => 'carrito.borrar']);
    $routes->get('/carrito-comprar', 'Ventascontroller::registrar_venta', ['filter' => 'auth']);
});

$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'admin.dashboard']); // panel del admin (Dashboard)

    $routes->get('ordenes', ['controller' => 'Admin\Orden']); // Ordenes

    $routes->get('clientes', 'Admin\Cliente::index'); // Cliente

    $routes->get('cliente/(:num)/ordenes', 'Admin\Orden::obtenerOrdenesCliente/$1', ['as' => 'cliente.ordenes']); // Ordenes

    $routes->get('productos', 'Admin\Producto::index'); // Productos
    $routes->get('producto/(:num)', 'Admin\Producto::show/$1'); // Detalle del producto
    $routes->get('producto/editar/(:num)', 'Admin\Producto::edit/$1'); // Editar el producto
    $routes->post('producto/eliminar/(:num)', 'Admin\Producto::delete/$1'); // Eliminar producto
    $routes->post('producto', 'Admin\Producto::create'); // crear producto

    $routes->group('consultas', function ($routes) { // Consulta
        $routes->get('', 'Admin\Consulta::index');
        $routes->get('(:num)', 'Admin\Consulta::view/$1');
    });

    $routes->group('contactos', function ($routes) { // Contacto
        $routes->get('', 'Admin\Contacto::index');
        $routes->get('(:num)', 'Admin\Contacto::view/$1');
    });

    //Rutas Categorias
    $routes->get('categorias', 'Admin\Categoria::index'); // Listado de Categorias
    $routes->get('categorias', 'Admin\Categoria::update/$1'); // Editar la categoria
    $routes->post('categorias', 'Admin\Categoria::delete/$1'); // Eliminar la categoria
    $routes->post('categoria', 'Admin\Categoria::create'); // Crear la categoria
    $routes->post('categorias', 'Admin\Categoria::buscarCategoria'); // Filtrar las categorias por estado

    // Rutas Marcas
    $routes->get('marcas', 'Admin\Marca::index'); // Listado de Marcas
    $routes->get('marcas', 'Admin\Marca::update/$1'); // Editar la marca
    $routes->post('marcas', 'Admin\Marca::delete/$1'); // Eliminar la marca
    $routes->post('marca', 'Admin\Marca::create'); // Crear la marca
    $routes->post('marcas', 'Admin\Marca::buscarMarca'); // Filtrar las maracas por estado
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
