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

    $routes->group('contacto', function ($routes) {
        $routes->get('', 'Web\Contacto::index');
        $routes->post('', 'Web\Contacto::create'); // Para enviar el formulario de contacto
        $routes->get('ubicacion', 'Web\Contacto::obtener_ubicacion');
    });

    $routes->group('consulta', ['filter' => 'authCliente'], function ($routes) { // Consulta
        $routes->get('', 'Web\Consulta::index');
        $routes->post('', 'Web\Consulta::create'); // Registro de Consulta
    });

    $routes->get('terminos', 'Web\Terminos::index'); // Terminos y usos
    $routes->add('garantia', 'Web\Garantia::index'); // Garantias

    $routes->get('catalogo', 'Web\Catalogo::index', ['as' => 'web.catalogo']); // Catalogo
    $routes->get('producto/(:num)', 'Web\Catalogo::show/$1', ['as' => 'producto']); // Producto del catalogo

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

    $routes->group('mensajes', ['filter' => 'authCliente'], function ($routes) {
        // Ruta para responder a una conversación:
        $routes->post('conversacion/(:num)/responder', 'Cliente\MensajesCliente::responderConversacion/$1', ['as' => 'cliente.mensajes.responder']);
    });

    // Venta
    $routes->get('finalizar', 'Web\Carrito::finalizarCompra', ['as' => 'carrito.borrar']);
    $routes->get('/carrito-comprar', 'Ventascontroller::registrar_venta', ['filter' => 'auth']);
});

$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'admin.dashboard']); // panel del admin (Dashboard)

    $routes->get('ordenes', ['controller' => 'Admin\Orden']); // Ordenes

    $routes->get('clientes', 'Admin\Cliente::index'); // Cliente
    $routes->get('clientes', 'Admin\Cliente::buscarCliente'); // Cliente

    // Rutas para Productos
    $routes->get('productos', 'Admin\Producto::index');
    $routes->get('producto/(:num)', 'Admin\Producto::show/$1');
    $routes->get('producto/editar/(:num)', 'Admin\Producto::edit/$1');
    $routes->post('producto/update/(:num)', 'Admin\Producto::update/$1');
    $routes->post('producto/eliminar/(:num)', 'Admin\Producto::delete/$1');
    $routes->get('producto/crear', 'Admin\Producto::new');
    $routes->post('producto', 'Admin\Producto::create');
    $routes->post('productos', 'Admin\Producto::buscarProducto');

    // Ruta para eliminar imágenes de producto
    // Se utiliza GET para eliminar, pero también puedes usar POST si prefieres mayor seguridad.
    $routes->get('producto/eliminarImagen/(:num)', 'Admin\ImagenProducto::eliminarImagen/$1');

    $routes->group('conversaciones', function ($routes) {
        // Rutas para Consultas:
        $routes->get('consultas', 'Admin\Conversacion::consultas'); // Listado de consultas
        $routes->get('consultas/(:num)', 'Admin\Conversacion::mostrar_consulta/$1'); // Ver detalle de consulta
        $routes->post('consultas/(:num)/responder', 'Admin\Conversacion::responder_consulta/$1'); // Ruta para enviar respuesta a una consulta
        $routes->get('consultas/buscar', 'Admin\Conversacion::buscar_consultas', ['as' => 'admin.buscarConsultas']); // Ruta para filtrar las consultas

        // Rutas para Contactos:
        $routes->get('contactos', 'Admin\Conversacion::contactos'); // Listado de contactos
        $routes->get('contactos/(:num)', 'Admin\Conversacion::mostrar_contacto/$1'); // Ver detalle de contacto
        $routes->post('contactos/(:num)/responder', 'Admin\Conversacion::responder_contacto/$1'); // Ruta para enviar respuesta a un contacto
        $routes->get('contactos/buscar', 'Admin\Conversacion::buscar_contactos', ['as' => 'admin.buscarContactos']);
    });

    //Rutas Categorias
    $routes->get('categorias', 'Admin\Categoria::index'); // Listado de Categorias
    $routes->get('categorias', 'Admin\Categoria::update/$1'); // Editar la categoria
    $routes->post('categorias', 'Admin\Categoria::delete/$1'); // Eliminar la categoria
    $routes->post('categoria', 'Admin\Categoria::create'); // Crear la categoria
    $routes->get('categorias', 'Admin\Categoria::buscarCategoria'); // Filtrar las categorias por estado

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
