<?php

use CodeIgniter\Router\RouteCollection;

/** LISTO
 * @var RouteCollection $routes
 */

// Activa el auto-routing (útil para desarrollo, pero en producción se recomienda definir todas las rutas explícitamente)
$routes->setAutoRoute(true);

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Web)
|--------------------------------------------------------------------------
|
| Aquí se definen las rutas accesibles públicamente, sin necesidad de autenticación.
|
*/
$routes->group('', function ($routes) {
    // Página de inicio y páginas estáticas
    $routes->get('/', 'Web\Home::index', ['as' => 'web.home']);
    $routes->get('nosotros', 'Web\Nosotros::index');

    // Grupo: Comercialización (información, métodos de pago, etc.)
    $routes->group('comercializacion', function ($routes) {
        $routes->get('', 'Web\Comercializacion::index');
        $routes->get('formas_de_pago', 'Web\Comercializacion::obtener_metodos');
    });

    // Grupo: Contacto
    $routes->group('contacto', function ($routes) {
        $routes->get('', 'Web\Contacto::index');
        $routes->post('', 'Web\Contacto::create'); // Procesa el formulario de contacto
        $routes->get('ubicacion', 'Web\Contacto::obtener_ubicacion');
    });

    // Grupo: Consultas (solo para clientes autenticados)
    $routes->group('consulta', ['filter' => 'authCliente'], function ($routes) {
        $routes->get('', 'Web\Consulta::index');
        $routes->post('', 'Web\Consulta::create');
    });

    // Rutas estáticas adicionales
    $routes->get('terminos', 'Web\Terminos::index');
    $routes->add('garantia', 'Web\Garantia::index');

    // Catálogo y detalles de producto
    $routes->get('catalogo', 'Web\Catalogo::index', ['as' => 'web.catalogo']);
    $routes->get('producto/(:num)', 'Web\Catalogo::show/$1', ['as' => 'producto']);
    $routes->get('catalogo/sugerencias', 'Web\Catalogo::sugerencias');

    // Grupo: Carrito y Compras (solo para clientes autenticados)
    $routes->group('carrito', ['filter' => 'authCliente'], function ($routes) {
        $routes->get('', 'Web\Carrito::index');
        $routes->get('agregar/(:num)', 'Web\Carrito::agregar/$1', ['as' => 'carrito.agregar']);
        $routes->get('quitar/(:any)', 'Web\Carrito::quitar/$1', ['as' => 'carrito.quitar']);
        $routes->get('borrar', 'Web\Carrito::borrar', ['as' => 'carrito.borrar']);
        $routes->get('comprar', 'Web\Carrito::comprar');
        $routes->post('finalizarCompra', 'Web\Carrito::finalizarCompra');
    });

    // Rutas para el proceso de Checkout
    $routes->group('checkout', ['filter' => 'authCliente'], function ($routes) {
        $routes->get('seleccionarDireccion', 'Web\Checkout::seleccionarDireccion', ['as' => 'checkout.seleccionarDireccion']);
        $routes->get('nuevaDireccion', 'Web\Checkout::nuevaDireccion', ['as' => 'checkout.nuevaDireccion']);
        $routes->post('crearNuevaDireccion', 'Web\Checkout::crearNuevaDireccion', ['as' => 'checkout.crearNuevaDireccion']);
        $routes->get('confirmarPedido', 'Web\Checkout::confirmarPedido', ['as' => 'checkout.confirmarPedido']);
        $routes->post('finalizarCompra', 'Web\Checkout::finalizarCompra', ['as' => 'checkout.finalizarCompra']);
    });

    $routes->group('compras', ['filter' => 'authCliente'], function ($routes) {
        $routes->get('', 'Web\Compras::index');
        $routes->get('detalle/(:num)', 'Web\Compras::detalle_compra/$1');
        $routes->get('descargar/(:num)', 'Web\Compras::descargar/$1');
        $routes->get('descargar_factura/(:num)', 'Web\Compras::descargar_factura/$1');
    });

    // Grupo: Mensajes (para clientes)
    $routes->group('mensajes', ['filter' => 'authCliente'], function ($routes) {
        $routes->post('conversacion/(:num)/responder', 'Cliente\MensajesCliente::responderConversacion/$1', ['as' => 'cliente.mensajes.responder']);
    });

    // Rutas de venta (con algunos endpoints específicos)
    $routes->get('finalizar', 'Web\Carrito::finalizarCompra', ['as' => 'carrito.borrar']);
    $routes->get('/carrito-comprar', 'Ventascontroller::registrar_venta', ['filter' => 'auth']);
});

/*
|--------------------------------------------------------------------------
| Rutas para el Administrador
|--------------------------------------------------------------------------
|
| Estas rutas están protegidas mediante el filtro 'authAdmin' y se utilizan para
| la administración del sitio (Dashboard, Ordenes, Clientes, Productos, Conversaciones,
| Categorías y Marcas).
|
*/
$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'admin.dashboard']);

    // Grupo: Ordenes
    $routes->group('ordenes', function ($routes) {
        $routes->get('', 'Admin\Orden::index');
        $routes->get('show/(:num)', 'Admin\Orden::show/$1');
        $routes->get('cancelar/(:num)', 'Admin\Orden::cancelar/$1', ['as' => 'admin.ordenes.cancelar']);
        $routes->get('completar/(:num)', 'Admin\Orden::completar/$1', ['as' => 'admin.ordenes.completar']);
        $routes->get('buscar', 'Admin\Orden::buscarOrden');
        $routes->get('comprobante/(:num)', 'Admin\Orden::comprobante/$1');

    });

    // Grupo: Clientes
    $routes->group('clientes', function ($routes) {
        $routes->get('/', 'Admin\Cliente::index');
        $routes->get('show/(:num)', 'Admin\Cliente::show/$1');
        $routes->get('buscar', 'Admin\Cliente::buscarCliente');
        $routes->get('conversaciones/(:num)', 'Admin\Cliente::conversaciones/$1');
        $routes->get('conversaciones/(:num)/(:num)', 'Admin\Cliente::verConversacion/$1/$2');
        $routes->get('buscar', 'Admin\Cliente::buscarConversacion');
        $routes->get('ordenes/(:num)', 'Admin\Cliente::ordenes/$1');
        $routes->get('ordenes/(:num)/(:num)', 'Admin\Cliente::verOrden/$1/$2');
    });


    // Grupo: Productos
    $routes->group('productos', function ($routes) {
        $routes->get('', 'Admin\Producto::index');
        $routes->get('(:num)', 'Admin\Producto::show/$1');
        $routes->get('editar/(:num)', 'Admin\Producto::edit/$1');
        $routes->post('update/(:num)', 'Admin\Producto::update/$1');
        $routes->post('eliminar/(:num)', 'Admin\Producto::delete/$1');
        $routes->get('crear', 'Admin\Producto::new');
        $routes->post('', 'Admin\Producto::create');
    });
    // Ruta para eliminar imágenes de producto
    $routes->get('producto/eliminarImagen/(:num)', 'Admin\ImagenProducto::eliminarImagen/$1');

    // Grupo: Conversaciones (Consultas y Contactos)
    $routes->group('conversaciones', function ($routes) {
        // Consultas
        $routes->group('consultas', function ($routes) {
            $routes->get('', 'Admin\Conversacion::consultas');
            $routes->get('(:num)', 'Admin\Conversacion::mostrar_consulta/$1');
            $routes->post('(:num)/responder', 'Admin\Conversacion::responder_consulta/$1');
            $routes->get('buscar', 'Admin\Conversacion::buscar_consultas', ['as' => 'admin.buscarConsultas']);
        });
        // Contactos
        $routes->group('contactos', function ($routes) {
            $routes->get('', 'Admin\Conversacion::contactos');
            $routes->get('(:num)', 'Admin\Conversacion::mostrar_contacto/$1');
            $routes->post('(:num)/responder', 'Admin\Conversacion::responder_contacto/$1');
            $routes->get('buscar', 'Admin\Conversacion::buscar_contactos', ['as' => 'admin.buscarContactos']);
            $routes->post('(:num)/cerrar', 'Admin\Conversacion::cerrar/$1');
        });
        // Ruta para obtener el conteo de mensajes pendientes (para actualizar los badges)
        $routes->get('conteoPendientes', 'Admin\Conversacion::conteoPendientes', ['as' => 'admin.conversaciones.conteoPendientes']);
    });

    // Grupo: Categorías
    $routes->group('categorias', function ($routes) {
        $routes->get('', 'Admin\Categoria::index');
        $routes->get('buscar', 'Admin\Categoria::buscarCategoria');
        $routes->post('crear', 'Admin\Categoria::create');
        $routes->get('editar/(:num)', 'Admin\Categoria::edit/$1');
        $routes->post('update/(:num)', 'Admin\Categoria::update/$1');
        $routes->post('delete/(:num)', 'Admin\Categoria::delete/$1');
    });

    // Grupo: Marcas
    $routes->group('marcas', function ($routes) {
        $routes->get('', 'Admin\Marca::index');
        $routes->get('buscar', 'Admin\Marca::buscarMarca');
        $routes->post('crear', 'Admin\Marca::create');
        $routes->get('editar/(:num)', 'Admin\Marca::edit/$1');
        $routes->post('update/(:num)', 'Admin\Marca::update/$1');
        $routes->post('delete/(:num)', 'Admin\Marca::delete/$1');
    });
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| Rutas para el inicio de sesión y registro de usuarios.
|
*/
$routes->group('login', function ($routes) {
    $routes->get('', 'Auth\Login::index', ['as' => 'login']);
    $routes->post('', 'Auth\Login::login_post');
    $routes->get('logout', 'Auth\Login::logout', ['as' => 'logout']);
});

$routes->group('registro', function ($routes) {
    $routes->get('', 'Auth\Register::index');
    $routes->post('', 'Auth\Register::register_post');
});

/*
|--------------------------------------------------------------------------
| Rutas para Clientes (Autenticados)
|--------------------------------------------------------------------------
|
| Estas rutas están protegidas mediante el filtro 'authCliente' y permiten
| que los usuarios autenticados gestionen su perfil, direcciones y mensajes.
|
*/
$routes->group('cliente', ['filter' => 'authCliente'], function ($routes) {
    // Perfil del cliente
    $routes->group('perfil', function ($routes) {
        $routes->get('', 'Cliente\Perfil::mostrar', ['as' => 'cliente.perfil']);
        $routes->get('editar', 'Cliente\Perfil::editar', ['as' => 'cliente.perfil.editar']);
        $routes->post('actualizar', 'Cliente\Perfil::actualizar', ['as' => 'cliente.perfil.actualizar']);
    });

    // Direcciones de envío
    $routes->group('direcciones', function ($routes) {
        $routes->get('crear', 'Cliente\Direccion::crear', ['as' => 'cliente.direcciones.crear']);
        $routes->post('guardar', 'Cliente\Direccion::guardar', ['as' => 'cliente.direcciones.guardar']);
        $routes->get('editar/(:num)', 'Cliente\Direccion::editar/$1', ['as' => 'cliente.direcciones.editar']);
        $routes->post('actualizar/(:num)', 'Cliente\Direccion::actualizar/$1', ['as' => 'cliente.direcciones.actualizar']);
        $routes->get('eliminar/(:num)', 'Cliente\Direccion::eliminar/$1', ['as' => 'cliente.direcciones.eliminar']);
    });

    // Mensajes del cliente
    $routes->group('mensajes', function ($routes) {
        $routes->get('', 'Cliente\Mensaje::index', ['as' => 'cliente.mensajes.index']);
        $routes->get('redactar', 'Cliente\Mensaje::redactar', ['as' => 'cliente.mensajes.redactar']);
        $routes->post('enviar', 'Cliente\Mensaje::create', ['as' => 'cliente.mensajes.redactar']);
        $routes->get('ver/(:num)', 'Cliente\Mensaje::ver/$1', ['as' => 'cliente.mensajes.ver']);
        $routes->post('responder/(:num)', 'Cliente\Mensaje::responder/$1', ['as' => 'cliente.mensajes.responder']);
        $routes->post('cerrar/(:num)', 'Cliente\Mensaje::cerrar/$1', ['as' => 'cliente.mensajes.cerrar']);
    });

    // Perfil del cliente
    $routes->group('pedidos', function ($routes) {
        $routes->get('', 'Cliente\Pedidos::index', ['as' => 'cliente.pedidos.index']);
        $routes->get('show/(:num)', 'Cliente\Pedidos::show/$1', ['as' => 'cliente.pedidos.show']);
        $routes->get('descargarPdf/(:num)', 'Cliente\Pedidos::descargarPdf/$1', ['as' => 'cliente.pedidos.descargarPdf']);
        $routes->get('cancelar/(:num)', 'Cliente\Pedidos::cancelar/$1', ['as' => 'cliente.pedidos.cancelar']);
    });
});
