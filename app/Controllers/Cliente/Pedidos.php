<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\DetalleOrdenModel;
use App\Models\OrdenModel;
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
    protected $detalleModel;

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
        $this->detalleModel = new DetalleOrdenModel();
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

        $detalles = $this->detalleModel->obtenerDetallesPorOrden($id);

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
     * Cancela una orden de compra.
     *
     * Este método permite al usuario cancelar una orden existente. En lugar de eliminar la orden,
     * se actualiza su estado a "cancelada" usando el método cancelarOrden() del modelo OrdenModel.
     * Solo se permite cancelar una orden si ésta pertenece al usuario autenticado.
     *
     * @param int $id ID de la orden a cancelar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la lista de pedidos con un mensaje de éxito o error.
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

        // Intentar cancelar la orden mediante el método del modelo
        if ($this->ordenModel->cancelarOrden($id)) {
            return redirect()->to(site_url('cliente/pedidos'))->with('success', 'La orden ha sido cancelada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo cancelar la orden. Por favor, inténtalo de nuevo.');
        }
    }
}
