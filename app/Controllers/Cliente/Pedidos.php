<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\DetalleOrdenModel;
use App\Models\OrdenModel;
use App\Models\ProductoModel;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Controlador para la gestión de Pedidos del Cliente.
 *
 * Este controlador permite a un cliente ver su historial de pedidos y consultar el detalle de cada orden.
 *
 * @package App\Controllers\Cliente
 */
class Pedidos extends BaseController
{
    /**
     * Instancia del modelo de órdenes.
     *
     * @var OrdenModel
     */
    protected $ordenModel;

    /**
     * Instancia del modelo de órdenes.
     *
     * @var DetalleOrdenModel
     */
    protected $detalleOrdenModel;

    /**
     * Instancia del modelo de Productos.
     *
     * @var ProductoModel
     */
    protected $productoModel;

    /**
     * Instancia del servicio del carrito.
     *
     * @var \CodeIgniter\Cart\Cart
     */
    protected $cart;

    /**
     * Constructor.
     *
     * Inicializa el modelo de órdenes.
     */
    public function __construct()
    {
        $this->ordenModel = new OrdenModel();
        $this->detalleOrdenModel = new DetalleOrdenModel();
        $this->productoModel = new ProductoModel();
        $this->cart = \Config\Services::cart();
    }

    /**
     * Muestra la lista de pedidos del cliente.
     *
     * Obtiene las órdenes asociadas al usuario autenticado y las pasa a la vista index.
     *
     * @return string Vista renderizada con la lista de pedidos.
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }

        // Obtener las órdenes del cliente
        $ordenes = $this->ordenModel->obtenerOrdenesPorUsuario($usuario->id);

        $breadcrumbs = [
            ['label' => 'Inicio', 'url' => site_url('web/home')],
            ['label' => 'Mis Pedidos', 'url' => '']
        ];

        $data = [
            'titulo'    => 'Mis Pedidos',
            'ordenes'   => $ordenes,
            'usuario'   => $usuario,
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs
        ];

        return view('web/cliente/pedidos/index', $data);
    }

    /**
     * Muestra el detalle de una orden específica.
     *
     * Obtiene la orden detallada (con datos de usuario, dirección y productos) y la pasa a la vista show.
     *
     * @param int $id ID de la orden a mostrar.
     * @return string Vista renderizada con el detalle del pedido, o redirección si no se encuentra la orden.
     */
    public function show($id)
    {
        // Verificar que el usuario esté autenticado
        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión para ver el pedido.');
        }

        // Obtener el pedido detallado
        $orden = $this->ordenModel->obtenerOrdenDetallada($id);

        $detalles = $this->detalleOrdenModel->obtenerDetallesPorOrden($id);

        // Verificar si la orden existe y pertenece al usuario autenticado
        if (!$orden || $orden->usuario_id != $usuario->id) {
            return redirect()->to(site_url('cliente/pedidos'))->with('error', 'Pedido no encontrado o no tienes permiso para verlo.');
        }
        $breadcrumbs = [
            ['label' => 'Inicio', 'url' => site_url('web/home')],
            ['label' => 'Mis Pedidos', 'url' => site_url('cliente/pedidos')],
            ['label' => 'Detalle del Pedido #' . $orden->id, 'url' => '']
        ];

        $data = [
            'titulo'      => 'Detalle del Pedido',
            'orden'       => $orden,
            'usuario'     => $usuario,
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,

        ];

        return view('web/cliente/pedidos/show', $data);
    }

    /**
     * Genera y descarga un PDF con el resumen de la orden.
     *
     * @param int $ordenId ID de la orden a descargar.
     * @return void
     */
    public function descargarPdf($ordenId)
    {
        // Verificar que el usuario esté autenticado y tenga permiso
        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión.');
        }

        $orden = $this->ordenModel->obtenerOrdenDetallada($ordenId);
        if (!$orden || $orden->usuario_id != $usuario->id) {
            return redirect()->to(site_url('cliente/pedidos'))->with('error', 'Pedido no encontrado o no tienes permiso para verlo.');
        }

        // Configurar opciones para Dompdf (por ejemplo, soporte para UTF-8)
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        // Instanciar Dompdf
        $dompdf = new Dompdf($options);

        // Generar el HTML a partir de la vista
        $html = view('web/cliente/pedidos/pdf', ['orden' => $orden]);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // (Opcional) Configurar el tamaño del papel y la orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Enviar el PDF generado al navegador para descargar
        $dompdf->stream("orden_{$ordenId}.pdf", ['Attachment' => 1]);
    }

    /**
     * Cancela una orden de compra para el cliente autenticado y restablece el stock de los productos involucrados.
     *
     * Este método permite al usuario cancelar una orden existente. Primero, se verifica que el usuario esté autenticado;
     * si no lo está, se redirige al login con un mensaje de error. Luego, se obtiene la orden y se verifica que exista y
     * pertenezca al usuario autenticado. Además, solo se permite cancelar órdenes que estén en estado "pendiente".
     *
     * Si la cancelación es exitosa (mediante el método cancelarOrden() del modelo OrdenModel), se recorren los detalles
     * de la orden (usando, por ejemplo, el modelo OrdenDetalleModel) para restablecer el stock de cada producto involucrado,
     * sumando a su stock actual la cantidad reservada en la orden.
     *
     * Finalmente, se redirige al listado de pedidos del cliente con un mensaje de éxito ("La orden ha sido cancelada exitosamente.")
     * sin revelar al cliente que se restauró el stock.
     *
     * @param int $id ID de la orden a cancelar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la lista de pedidos del cliente con un mensaje de éxito o error.
     */
    public function cancelar($id)
    {
        // Verificar que el usuario esté autenticado
        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión para cancelar una orden.');
        }

        // Obtener la orden y verificar que pertenezca al usuario autenticado
        $orden = $this->ordenModel->find($id);
        if (!$orden || $orden->usuario_id != $usuario->id) {
            return redirect()->to(site_url('cliente/pedidos'))->with('error', 'Orden no encontrada o no tienes permiso para cancelarla.');
        }

        // Solo se pueden cancelar órdenes pendientes
        if ($orden->estado !== 'pendiente') {
            return redirect()->to(site_url('cliente/pedidos'))->with('error', 'Solo se pueden cancelar órdenes pendientes.');
        }

        // Intentar cancelar la orden
        if ($this->ordenModel->cancelarOrden($id)) {
            // Restaurar el stock de cada producto involucrado
            $detalles = $this->detalleOrdenModel->obtenerDetallesPorOrden($id);
            foreach ($detalles as $detalle) {
                // Se espera que $detalle tenga 'producto_id' y 'cantidad'
                $producto = $this->productoModel->find($detalle->producto_id);
                if ($producto) {
                    $nuevoStock = $producto->stock + $detalle->cantidad;
                    $this->productoModel->update($detalle->producto_id, ['stock' => $nuevoStock]);
                }
            }
            return redirect()->to(site_url('cliente/pedidos'))->with('mensaje', 'La orden ha sido cancelada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo cancelar la orden. Por favor, inténtalo de nuevo.');
        }
    }

    public function buscarPedido()
    {
        $estado   = $this->request->getGet('estado') ?? 'todas';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $porPage  = 10;
        $clienteId = session()->get('usuario')->id;

        try {
            $ordenes      = $this->ordenModel->obtenerOrdenesFiltradasCliente($estado, $busqueda, $pagina, $porPage, $clienteId);
            $totalPaginas = $this->ordenModel->obtenerTotalPaginasCliente($busqueda, $estado, $porPage, $clienteId);

            return $this->response->setJSON([
                'pedidos'      => $ordenes,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las órdenes. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
