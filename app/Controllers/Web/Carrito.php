<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProductoModel;

/**
 * Controlador para la gestión del Carrito de Compras.
 *
 * Este controlador se encarga de mostrar el carrito, agregar productos,
 * actualizar cantidades y eliminar items. La lógica del proceso de checkout
 * (selección de dirección, confirmación del pedido y finalización de la compra)
 * se gestiona en un controlador aparte.
 *
 * @package App\Controllers\Web
 */
class Carrito extends BaseController
{
    /**
     * Instancia del servicio del carrito.
     *
     * @var \CodeIgniter\Cart\Cart
     */
    protected $cart;

    /**
     * Instancia del modelo de Productos.
     *
     * @var ProductoModel
     */
    protected $productoModel;

    /**
     * Constructor.
     *
     * Carga los helpers necesarios y obtiene la instancia del carrito.
     */
    public function __construct()
    {
        helper(['form', 'url', 'cart', 'number']);
        $this->cart = \Config\Services::cart();
        $this->productoModel = new ProductoModel();
    }

    /**
     * Muestra la vista del carrito de compras.
     *
     * Pasa a la vista los items del carrito, el total y datos adicionales (como breadcrumbs).
     *
     * @return string Vista renderizada del carrito.
     */
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Carrito', 'url' => ''],
        ];

        $data = [
            'titulo'      => 'Carrito de Compras',
            'cartItems'   => $this->cart->contents(),
            'total'       => $this->cart->total(),
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/carrito', $data);
    }

    /**
     * Agrega un producto al carrito.
     *
     * Si el producto ya existe en el carrito, incrementa su cantidad; si no, inserta un nuevo ítem.
     * Se obtiene el producto completo mediante el modelo y se asigna su imagen principal.
     *
     * @param int|null $idProducto ID del producto a agregar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la operación.
     * @throws \InvalidArgumentException Si no se proporciona un ID de producto.
     * @throws \OutOfBoundsException Si el producto no se encuentra.
     */
    public function agregar($idProducto = null)
    {
        if ($idProducto === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID de producto no proporcionado'
            ]);
        }

        $producto = $this->productoModel->obtenerProductoPorId($idProducto);

        if (!$producto) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
        }

        $producto->imagen_principal = isset($producto->imagenes[0]->ruta_imagen)
            ? $producto->imagenes[0]->ruta_imagen
            : 'uploads/productos/no-image.png';

        $cartItem = $this->cart->getItem($producto->id);
        if ($cartItem) {
            $this->cart->update($cartItem['rowid'], ['qty' => $cartItem['qty'] + 1]);
        } else {
            $data = [
                'id'    => $idProducto,
                'qty'   => 1,
                'price' => $producto->precio,
                'name'  => $producto->nombre,
                'image' => $producto->imagen_principal,
            ];
            $this->cart->insert($data);
        }

        // Devuelve también la cantidad total y el total del carrito
        return $this->response->setJSON([
            'success'    => true,
            'message'    => 'Producto agregado al carrito',
            'totalItems' => $this->cart->totalItems(),
            'total'      => $this->cart->total()
        ]);
    }



    /**
     * Actualiza la cantidad de un producto en el carrito.
     *
     * Realiza una solicitud AJAX para actualizar la cantidad en el backend y, si es exitosa,
     * actualiza la vista con el nuevo subtotal, total y mensaje de stock.
     *
     * @return \CodeIgniter\HTTP\Response JSON con el estado, subtotal y total actualizados.
     */
    public function actualizar()
    {
        try {
            $rowid = $this->request->getPost('rowid');
            $nuevaCantidad = $this->request->getPost('cantidad');
            $mensajeCorreccion = ""; // Para almacenar el mensaje de corrección, si lo hay

            // Si la cantidad no es numérica o es menor a 1, la forzamos a 1 y notificamos
            if (!is_numeric($nuevaCantidad) || $nuevaCantidad < 1) {
                $nuevaCantidad = 1;
                $mensajeCorreccion = "La cantidad mínima es 1. Se ha ajustado a 1.";
            }

            // Obtener el item del carrito
            $item = $this->cart->getItem($rowid);
            if (!$item) {
                throw new \OutOfBoundsException('El producto no se encontró en el carrito');
            }

            // Obtener el producto desde la base de datos para verificar el stock
            $productoModel = new ProductoModel();
            $producto = $productoModel->find($item['id']);
            if (!$producto) {
                throw new \OutOfBoundsException('El producto no se encontró en la base de datos');
            }

            // Si la cantidad supera el stock, la forzamos al stock y notificamos
            if ($nuevaCantidad > $producto->stock) {
                $nuevaCantidad = $producto->stock;
                $mensajeCorreccion = "La cantidad excede el stock disponible. Se ha ajustado a " . $producto->stock . ".";
            }

            // Actualizar la cantidad en el carrito
            $this->cart->update([
                'rowid' => $item['rowid'],
                'qty'   => $nuevaCantidad,
            ]);

            // Obtener el item actualizado y calcular el nuevo subtotal y total
            $item = $this->cart->getItem($rowid);
            $subtotal = $item['qty'] * $item['price'];
            $total = $this->cart->total();

            // Si no hubo corrección, establecer mensaje de éxito genérico
            if (!$mensajeCorreccion) {
                $mensajeCorreccion = "Cantidad actualizada.";
            }

            $response_data = [
                'success'  => true,
                'subtotal' => number_format($subtotal, 2),
                'total'    => number_format($total, 2),
                'message'  => $mensajeCorreccion
            ];

            // Si la cantidad se acerca al stock, agrega un mensaje adicional de stock
            if ($nuevaCantidad >= $producto->stock - 3 && $producto->stock > 0) {
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



    /**
     * Elimina un producto del carrito o vacía el carrito completo.
     *
     * Si se pasa "all" como parámetro, destruye el carrito; de lo contrario, elimina el item específico.
     *
     * @param string $rowid Identificador del item o "all" para vaciar el carrito.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la operación.
     */
    public function quitar($rowid)
    {
        if ($rowid == "all") {
            $this->cart->destroy();
            $message = "Carrito vaciado";
        } else {
            $this->cart->remove($rowid);
            $message = "Artículo eliminado del carrito";
        }
        return redirect()->back()->with('mensaje', $message)->withInput();
    }


    /**
     * Destruye completamente el carrito.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras destruir el carrito.
     */
    public function borrar()
    {
        $this->cart->destroy();
        $message = "Carrito vaciado";
        return redirect()->back()->with('mensaje', $message)->withInput();
    }
}
