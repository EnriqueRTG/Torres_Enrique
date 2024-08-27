<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\DetalleOrdenModel;
use App\Models\OrdenModel;
use App\Models\ProductoModel;


class Carrito extends BaseController
{
    protected $cart;

    public function __construct()
    {
        helper(['form', 'url', 'cart', 'number']); // Carga todos los helpers necesarios una sola vez en el constructor
        $this->cart = \Config\Services::cart(); // O usa 'new Cart()' si la cargaste manualmente
    }

    public function index()
    {
        $data = [
            'titulo' => 'Carrito de compras',
            'cartItems' => $this->cart->contents(),
            'total' => $this->cart->total(),
            'cart'  => $this->cart,
        ];

        return view('layouts/header', $data)
            . view('web/carrito', $data)
            . view('layouts/footer');
    }

    public function agregar($idProducto = null) // Recibe el ID del producto como parámetro
    {
        if ($idProducto === null) {
            throw new \InvalidArgumentException('ID de producto no proporcionado');
        }

        $productoModel = new ProductoModel();
        $producto = $productoModel->find($idProducto);

        if (!$producto) {
            throw new \OutOfBoundsException('Producto no encontrado');
        }

        // Verificar si el producto ya está en el carrito
        $cartItem = $this->cart->getItem($producto->id);

        if ($cartItem) {
            // El producto ya está en el carrito, actualizar la cantidad
            $this->cart->update($cartItem['rowid'], [
                'qty' => $cartItem['qty'] + 1
            ]);

            return redirect()->back()->with('success', 'La cantidad del producto en el carrito ha sido actualizada.');
        } else {
            // El producto no está en el carrito, insertarlo
            $data = [
                'id'      => $producto->id,
                'qty'     => 1,
                'price'   => $producto->precio,
                'name'    => $producto->nombre,
                // ... otros datos que necesites (imagen, opciones, etc.)
            ];

            $this->cart->insert($data);

            return redirect()->back();
        }
    }

    public function actualizar()
    {
        $cart = \Config\Services::cart();;

        try {
            $rowid = $this->request->getPost('rowid');
            $nuevaCantidad = $this->request->getPost('cantidad');

            // Validaciones 
            if (!is_numeric($nuevaCantidad) || $nuevaCantidad < 1) {
                return $this->response->setJSON(['success' => false, 'message' => 'Cantidad inválida']);
            }

            // Obtener el item del carrito ANTES de actualizarlo
            $item = $this->cart->getItem($rowid);

            if (!$item) {
                throw new \OutOfBoundsException('El producto no se encontró en el carrito');
            }

            // Obtener el producto desde la base de datos 
            $productoModel = new ProductoModel();
            $producto = $productoModel->find($item['id']);

            if (!$producto) {
                throw new \OutOfBoundsException('El producto no se encontró en la base de datos');
            }

            // Verificar stock disponible
            if ($nuevaCantidad > $producto->stock) {
                return $this->response->setJSON(['success' => false, 'message' => 'No hay suficiente stock disponible']);
            }

            // Actualizar el carrito
            $cart->update(array(
                'rowid'   => $item['rowid'],
                'qty'     => $nuevaCantidad,
            ));

            $item = $this->cart->getItem($rowid);

            // Calcular el nuevo subtotal y total 
            $subtotal = $item['qty'] * $item['price']; // Usar la cantidad actualizada del item
            $total = $this->cart->total();

            // Devolver una respuesta JSON
            $response_data = [
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($total, 2)
            ];

            // Opcional: Agregar un mensaje de stock si es necesario
            if ($nuevaCantidad >= $producto->stock - 3) {
                $response_data['stockMessage'] = "¡Últimas {$producto->stock} unidades!";
            }

            return $this->response->setJSON($response_data);
        } catch (\OutOfBoundsException $e) {
            log_message('error', 'Error al actualizar el carrito: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar el carrito: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el carrito']);
        }
    }

    public function quitar($rowid)
    {
        // si $rowid es 'all' destruye el carrito
        if ($rowid == "all") {
            $this->cart->destroy();
        } else { // sino solo destruye la fila seleccionada 
            $this->cart->remove($rowid);
        }
        return redirect()->back()->withInput();
    }

    public function borrar() // Cambiado el nombre a "borrar" para evitar conflictos con palabras reservadas
    {
        $this->cart->destroy();
        return redirect()->back()->withInput();
    }

    public function comprar()
    {
        // 1. Verificar si el carrito tiene productos
        if ($this->cart->totalItems() == 0) {
            return redirect()->to(route_to('web.catalogo'))->with('error', 'El carrito está vacío. Agrega productos antes de continuar.');
        }

        // 2. Obtener datos del usuario (si estás usando autenticación)
        $usuario = session()->get('usuario'); // Ajusta esto según tu implementación de autenticación

        // 3. Pasar datos del carrito y del usuario a la vista
        $data = [
            'titulo' => 'Direccion de envio',
            'cartItems' => $this->cart->contents(),
            'total' => $this->cart->total(),
            'usuario' => $usuario,
            'cart'  => $this->cart,
        ];

        // 4. Cargar la vista de dirección de envío
        return view('layouts/header', $data)
            . view('web/direccion_envio', $data)
            . view('layouts/footer');
    }

    public function finalizarCompra()
    {
        $db = \Config\Database::connect();
        if ($db->connect_error) {
            die("Error de conexión a la base de datos: " . $db->connect_error);
        } else {
            echo "Conexión exitosa a la base de datos!";
        }

        // 1. Obtener datos del formulario y del carrito
        $direccion = $this->request->getPost('direccion');
        $cartItems = $this->cart->contents();
        $total = $this->cart->total();

        // 2. Validar datos (¡Importante!)
        // ... Realiza las validaciones necesarias para $direccion y los datos del carrito

        // 3. Procesar la compra (lógica principal)
        try {
            // 3.1. Iniciar transacción en la base de datos (opcional pero recomendado)
            $db->transBegin();

            // 3.2. Crear la orden de compra
            $ordenModel = new OrdenModel(); // Asegúrate de tener este modelo

            $ordenData = [
                'total' => $total,
                'direccion_envio' => $direccion,
                'usuario_id' => session()->get('usuario')->id,
                'estado' => 'pendiente', // O el estado inicial que corresponda
                // ... otros datos de la orden
            ];

            $ordenId = $ordenModel->insert($ordenData);

            // 3.3. Crear los detalles de la orden
            $ordenDetalleModel = new DetalleOrdenModel(); // Asegúrate de tener este modelo
            $productoModel = new ProductoModel();
            foreach ($cartItems as $item) {
                $ordenDetalleData = [
                    'orden_id' => $ordenId,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['qty'],
                    'precio_unitario' => $item['price']
                ];
                $ordenDetalleModel->insert($ordenDetalleData);

                // 3.4. Actualizar el stock del producto
                $productoModel->actualizarStock($item['id'], $item['qty']);
            }

            // 3.5. Confirmar la transacción
            $db->transCommit();

            // 3.6. Vaciar el carrito
            $this->cart->destroy();

            // 3.7. Redirigir a la vista de compras con mensaje de éxito
            return redirect()->to(route_to('compras'))->with('success', '¡Tu orden de compra se ha realizado con éxito!');
        } catch (\Exception $e) {
            // 3.8. Revertir la transacción en caso de error
            $db->transRollback();

            log_message('error', 'Error al procesar la compra: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al procesar tu compra. Por favor, inténtalo de nuevo.');
        }
    }
}
