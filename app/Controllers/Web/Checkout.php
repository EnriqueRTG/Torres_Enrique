<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\DireccionModel;
use App\Models\OrdenModel;
use App\Models\DetalleOrdenModel;
use App\Models\ProductoModel;

/**
 * Controlador para el proceso de Checkout.
 *
 * Este controlador gestiona el flujo de compra: selección o alta de dirección, 
 * confirmación del pedido y finalización de la compra.
 *
 * @package App\Controllers\Web
 */
class Checkout extends BaseController
{
    protected $direccionModel;
    protected $ordenModel;
    protected $detalleOrdenModel;
    protected $productoModel;
    protected $cart;

    /**
     * Constructor.
     *
     * Inicializa los modelos y el servicio del carrito.
     */
    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->direccionModel    = new DireccionModel();
        $this->ordenModel        = new OrdenModel();
        $this->detalleOrdenModel = new DetalleOrdenModel();
        $this->productoModel     = new ProductoModel();
        $this->cart              = \Config\Services::cart();
    }

    /**
     * Muestra la vista para seleccionar una dirección de envío.
     *
     * Lista las direcciones registradas del cliente y ofrece la opción de agregar una nueva.
     *
     * @return string Vista renderizada.
     */
    public function seleccionarDireccion()
    {
        $usuario = session()->get('usuario');

        // Obtener las direcciones del cliente
        $direcciones = $this->direccionModel->obtenerDireccionesDelCliente($usuario->id);

        $breadcrumbs = [
            ['label' => 'Carrito', 'url' => site_url('carrito')],
            ['label' => 'Checkout', 'url' => ''],
        ];

        $data = [
            'titulo'      => 'Seleccionar Dirección de Envío',
            'direcciones' => $direcciones,
            'usuario'     => $usuario,
            'cart'        => $this->cart,
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/checkout/seleccionar_direccion', $data);
    }

    /**
     * Muestra el formulario para agregar una nueva dirección.
     *
     * @return string Vista del formulario de alta de nueva dirección.
     */
    public function nuevaDireccion()
    {
        $usuario = session()->get('usuario');

        $breadcrumbs = [
            ['label' => 'Carrito', 'url' => site_url('carrito')],
            ['label' => 'Checkout', 'url' => site_url('checkout/seleccionarDireccion')],
            ['label' => 'Nueva Direccion', 'url' => ''],
        ];

        $data = [
            'titulo'  => 'Agregar Nueva Dirección',
            'cart'        => $this->cart,
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
            'usuario' => $usuario,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/checkout/nueva_direccion', $data);
    }

    /**
     * Procesa la creación de una nueva dirección y redirige a la selección.
     *
     * Agrega la nueva dirección al registro del cliente y redirige a la vista de selección de dirección.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function crearNuevaDireccion()
    {
        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión para continuar.');
        }

        $data = $this->request->getPost();
        $data['usuario_id'] = $usuario->id;

        if (!$this->direccionModel->agregarDireccionCliente($data)) {
            return redirect()->back()->withInput()->with('errors', $this->direccionModel->errors());
        }

        return redirect()->to(site_url('checkout/seleccionarDireccion'))->with('mensaje', 'Dirección agregada correctamente.');
    }

    /**
     * Muestra la vista de confirmación del pedido.
     *
     * Recibe el ID de la dirección seleccionada y muestra un resumen final del pedido (productos, total, dirección).
     *
     * @return string Vista renderizada de confirmación del pedido.
     */
    public function confirmarPedido()
    {
        $usuario = session()->get('usuario');

        // Se espera que el ID de la dirección se envíe vía GET o POST
        $direccionId = $this->request->getPost('direccion_id') ?? $this->request->getGet('direccion_id');
        if (!$direccionId) {
            return redirect()->back()->with('error', 'No se seleccionó ninguna dirección.');
        }

        $direccion = $this->direccionModel->find($direccionId);
        if (!$direccion) {
            return redirect()->back()->with('error', 'Dirección no encontrada.');
        }

        $cartItems = $this->cart->contents();
        $total = $this->cart->total();

        $breadcrumbs = [
            ['label' => 'Carrito', 'url' => site_url('carrito')],
            ['label' => 'Checkout', 'url' => site_url('checkout/seleccionarDireccion')],
            ['label' => 'Nueva Direccion', 'url' => ''],
        ];

        $data = [
            'titulo'      => 'Confirmar Pedido',
            'direccion'   => $direccion,
            'cartItems'   => $cartItems,
            'total'       => $total,
            'usuario'     => $usuario,
            'breadcrumbs' => $breadcrumbs,
            'cart'        => $this->cart,
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
        ];

        return view('web/checkout/confirmar_pedido', $data);
    }

    /**
     * Finaliza la compra.
     *
     * Procesa la orden de compra, crea los detalles, actualiza el stock, confirma la transacción y vacía el carrito.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras finalizar la compra.
     */
    public function finalizarCompra()
    {
        // Conectar a la base de datos
        $db = \Config\Database::connect();
        $direccionId = $this->request->getPost('direccion_id');
        $cartItems = $this->cart->contents();
        $total = $this->cart->total();

        $usuario = session()->get('usuario');
        if (!$usuario) {
            return redirect()->to(site_url('login'))->with('error', 'Debes iniciar sesión para continuar.');
        }

        if (!$direccionId) {
            return redirect()->back()->with('error', 'Debes seleccionar una dirección para enviar tu pedido.');
        }

        try {
            // Iniciar la transacción
            $db->transBegin();

            // Crear la orden de compra
            $ordenModel = new \App\Models\OrdenModel();
            $ordenData = [
                'total'             => $total,
                'direccion_envio_id' => $direccionId,
                'usuario_id'        => $usuario->id,
                'estado'            => 'pendiente',
            ];
            $ordenId = $ordenModel->crearOrden($ordenData);
            if (!$ordenId) {
                throw new \Exception('No se pudo crear la orden.');
            }

            // Instanciar los modelos necesarios para los detalles y productos
            $ordenDetalleModel = new \App\Models\DetalleOrdenModel();
            $productoModel = new \App\Models\ProductoModel();

            // Recorrer cada ítem del carrito para insertar el detalle y actualizar stock
            foreach ($cartItems as $item) {
                $ordenDetalleData = [
                    'orden_id'        => $ordenId,
                    'producto_id'     => $item['id'],
                    'cantidad'        => (int)$item['qty'],
                    'precio_unitario' => $item['price']
                ];

                // Crear el detalle de la orden; se valida internamente en el modelo
                $detalleId = $ordenDetalleModel->crearDetalle($ordenDetalleData);
                if (!$detalleId) {
                    // Si ocurre un error, se lanzará una excepción con los errores del modelo
                    throw new \Exception('Error al crear el detalle del producto ID ' . $item['id'] . ': ' . print_r($ordenDetalleModel->errors(), true));
                }

                // Actualizar el stock del producto; si falla, se lanza una excepción
                if (!$productoModel->actualizarStock($item['id'], $item['qty'])) {
                    throw new \Exception('Error al actualizar el stock del producto ID ' . $item['id']);
                }
            }

            // Confirmar la transacción
            $db->transCommit();

            // Vaciar el carrito
            $this->cart->destroy();

            return redirect()->to(site_url('cliente/pedidos/show/' . $ordenId))
                ->with('success', '¡Tu orden de compra se ha realizado con éxito!');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            $db->transRollback();
            log_message('error', 'Error al procesar la compra: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al procesar tu compra. Por favor, inténtalo de nuevo.');
        }
    }
}
