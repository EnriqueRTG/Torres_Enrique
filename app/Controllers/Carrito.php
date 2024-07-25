<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\CarritoModel;
use App\Models\ProductoModel;
use App\Models\OrdenModel;
use App\Models\DetalleModel;

class Carrito extends BaseController
{
    protected $carritoModel;
    protected $productoModel;
    protected $ordenModel;
    protected $detalleOrdenModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
        $this->ordenModel = new OrdenModel();
        $this->detalleOrdenModel = new DetalleModel();
    }

    public function index()
    {
        $idUsuario = session()->get('usuario->id'); // Obtén el ID del usuario

        $data = [
            'titulo'    => 'Carrito',
            'carrito'   => $this->carritoModel->obtenerCarrito($idUsuario),
        ];

        return view('layouts/header', $data) . view('carrito/index', $data) .  view('layouts/footer');;
    }

    public function agregar()
    {
        $idUsuario = session()->get('id_usuario');
        $productoId = $this->request->getPost('producto_id');
        $cantidad = $this->request->getPost('cantidad');

        $this->carritoModel->agregarProducto($idUsuario, $productoId, $cantidad);
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function actualizar()
    {
        $idUsuario = session()->get('id_usuario');
        $productoId = $this->request->getPost('producto_id');
        $cantidad = $this->request->getPost('cantidad');

        // Validación de cantidad (opcional)
        if ($cantidad < 1) {
            return redirect()->back()->with('error', 'La cantidad debe ser al menos 1');
        }

        $this->carritoModel->actualizarCantidad($idUsuario, $productoId, $cantidad);
        return redirect()->back()->with('success', 'Cantidad actualizada');
    }

    public function eliminar()
    {
        $idUsuario = session()->get('id_usuario');
        $productoId = $this->request->getPost('producto_id');

        $this->carritoModel->eliminarProducto($idUsuario, $productoId);
        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    public function finalizarCompra()
    {
        $idUsuario = session()->get('id_usuario');
        $carrito = $this->carritoModel->obtenerCarrito($idUsuario);

        if (empty($carrito)) {
            return redirect()->to('carrito')->with('error', 'El carrito está vacío');
        }

        // Calcular el total de la compra
        $total = 0;
        foreach ($carrito as $item) {
            $producto = $this->productoModel->find($item['id_producto']);
            $total += $producto['precio'] * $item['cantidad'];
        }

        // Crear registro en la tabla "orden"
        $ordenData = [
            'id_usuario' => $idUsuario,
            'fecha' => date('Y-m-d H:i:s'),
            'total' => $total,
            // ... otros campos de la orden
        ];
        $ordenId = $this->ordenModel->insert($ordenData);

        // Crear registros en la tabla "detalle_orden"
        foreach ($carrito as $item) {
            $detalleOrdenData = [
                'id_orden' => $ordenId,
                'id_producto' => $item['id_producto'],
                'cantidad' => $item['cantidad'],
                // ... otros campos del detalle de la orden
            ];
            $this->detalleOrdenModel->insert($detalleOrdenData);
        }

        // Vaciar carrito temporal
        $this->carritoModel->vaciarCarrito($idUsuario);

        return redirect()->to('carrito/exito')->with('success', 'Compra realizada con éxito');
    }
}
