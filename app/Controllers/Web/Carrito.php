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
     * Constructor.
     *
     * Carga los helpers necesarios y obtiene la instancia del carrito.
     */
    public function __construct()
    {
        helper(['form', 'url', 'cart', 'number']);
        $this->cart = \Config\Services::cart();
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
            throw new \InvalidArgumentException('ID de producto no proporcionado');
        }

        $productoModel = new ProductoModel();
        $producto = $productoModel->obtenerProductoPorId($idProducto);
        if (!$producto) {
            throw new \OutOfBoundsException('Producto no encontrado');
        }
        // Asigna la imagen principal: la primera del arreglo de imágenes o una por defecto
        $producto->imagen_principal = isset($producto->imagenes[0]->ruta_imagen) ? $producto->imagenes[0]->ruta_imagen : 'uploads/productos/no-image.png';

        // Verificar si el producto ya está en el carrito
        $cartItem = $this->cart->getItem($producto->id);
        if ($cartItem) {
            // Actualizar la cantidad del producto en el carrito
            $this->cart->update($cartItem['rowid'], [
                'qty' => $cartItem['qty'] + 1
            ]);
            return redirect()->back()->with('success', 'La cantidad del producto en el carrito ha sido actualizada.');
        } else {
            // Insertar el producto en el carrito, incluyendo la imagen principal
            $data = [
                'id'    => $producto->id,
                'qty'   => 1,
                'price' => $producto->precio,
                'name'  => $producto->nombre,
                'image' => $producto->imagen_principal,
            ];
            $this->cart->insert($data);
            return redirect()->back();
        }
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

            // Validar la nueva cantidad
            if (!is_numeric($nuevaCantidad) || $nuevaCantidad < 1) {
                return $this->response->setJSON(['success' => false, 'message' => 'Cantidad inválida']);
            }

            // Obtener el item del carrito antes de actualizarlo
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

            // Verificar que la nueva cantidad no exceda el stock
            if ($nuevaCantidad > $producto->stock) {
                return $this->response->setJSON(['success' => false, 'message' => 'No hay suficiente stock disponible']);
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

            $response_data = [
                'success'  => true,
                'subtotal' => number_format($subtotal, 2),
                'total'    => number_format($total, 2)
            ];

            // Agregar mensaje de stock si la cantidad se acerca al límite
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
        } else {
            $this->cart->remove($rowid);
        }
        return redirect()->back()->withInput();
    }

    /**
     * Destruye completamente el carrito.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras destruir el carrito.
     */
    public function borrar()
    {
        $this->cart->destroy();
        return redirect()->back()->withInput();
    }
}
