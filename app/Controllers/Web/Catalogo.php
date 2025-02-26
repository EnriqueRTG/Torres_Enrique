<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;

/** LISTO
 * Controlador para el Catálogo de Productos.
 *
 * Este controlador gestiona la visualización del catálogo, incluyendo la aplicación de filtros 
 * (por categoría, precio y orden), la carga de productos activos y la obtención de categorías con stock.
 *
 * @package App\Controllers\Web
 */
class Catalogo extends BaseController
{
    /**
     * Instancia del modelo de Productos.
     *
     * @var ProductoModel
     */
    protected $productoModel;

    /**
     * Instancia del modelo de Categorías.
     *
     * @var CategoriaModel
     */
    protected $categoriaModel;

    /**
     * Instancia del servicio de Carrito de Compras.
     *
     * @var Cart
     */
    protected $cart;

    /**
     * Constructor.
     *
     * Inicializa los modelos y el servicio del carrito.
     */
    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->cart = \Config\Services::cart();
    }

    /**
     * Muestra la vista del catálogo.
     *
     * Aplica filtros basados en categoría, precio y orden. Los filtros se guardan en sesión para persistir
     * la selección del usuario.
     *
     * @return string Vista renderizada del catálogo.
     */
    public function index()
    {
        $filtro = $this->request->getGet();
        $session = session();

        // Si se solicita limpiar filtros, se remueven de la sesión y se redirige.
        if ($this->request->getGet('limpiar_filtros')) {
            $session->remove(['filtro_categoria', 'filtro_precio_min', 'filtro_precio_max', 'filtro_orden']);
            return redirect()->to(route_to('web.catalogo'));
        }

        // Construir la consulta utilizando el Query Builder del modelo
        $builder = $this->productoModel->builder();

        // Aplicar filtros según categoría, precio mínimo y máximo, usando la sesión si es necesario
        if (!empty($filtro['categoria'])) {
            $builder->whereIn('productos.categoria_id', $filtro['categoria']);
            $session->set('filtro_categoria', $filtro['categoria']);
        } elseif ($session->has('filtro_categoria')) {
            $filtro['categoria'] = $session->get('filtro_categoria');
            $builder->whereIn('productos.categoria_id', $filtro['categoria']);
        }

        if (!empty($filtro['precio_min'])) {
            $builder->where('productos.precio >=', $filtro['precio_min']);
            $session->set('filtro_precio_min', $filtro['precio_min']);
        } elseif ($session->has('filtro_precio_min')) {
            $builder->where('productos.precio >=', $session->get('filtro_precio_min'));
        }

        if (!empty($filtro['precio_max'])) {
            $builder->where('productos.precio <=', $filtro['precio_max']);
            $session->set('filtro_precio_max', $filtro['precio_max']);
        } elseif ($session->has('filtro_precio_max')) {
            $builder->where('productos.precio <=', $session->get('filtro_precio_max'));
        }

        // Ordenamiento: se guarda en la sesión o se establece un valor por defecto
        if (!empty($filtro['orden'])) {
            $session->set('filtro_orden', $filtro['orden']);
        } else {
            if ($session->has('filtro_orden')) {
                $filtro['orden'] = $session->get('filtro_orden');
            } else {
                $filtro['orden'] = 'fecha_registro';
            }
        }

        // Aplicar ordenamiento basado en el valor de 'orden'
        switch ($filtro['orden']) {
            case 'precio_asc':
                $builder->orderBy('productos.precio', 'ASC');
                break;
            case 'precio_desc':
                $builder->orderBy('productos.precio', 'DESC');
                break;
            case 'novedades':
            default:
                $builder->orderBy('productos.created_at', 'DESC');
                break;
        }

        // Obtener los productos activos utilizando un método del modelo que reciba el builder
        $productos = $this->productoModel->getProductosActivos($builder);

        // Obtener categorías con productos activos en stock
        $categorias = $this->obtenerCategoriasConProductosActivos();

        $breadcrumbs = [
            [
                'label' => 'Catálogo',
                'url'   => '',
            ],
        ];

        $data = [
            'titulo'      => 'Catálogo',
            'productos'   => $productos,
            'categorias'  => $categorias,
            'filtro'      => $filtro,
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/catalogo', $data);
    }

    /**
     * Método privado para obtener las categorías con productos activos en stock.
     *
     * @return array Lista de categorías.
     */
    private function obtenerCategoriasConProductosActivos()
    {
        return $this->categoriaModel->select('categorias.*')
            ->join('productos', 'productos.categoria_id = categorias.id')
            ->where('productos.estado', 'activo')
            ->where('productos.stock >', 0)
            ->groupBy('categorias.id')
            ->findAll();
    }

    /**
     * Muestra el detalle de un producto.
     *
     * Obtiene el producto completo, incluyendo sus relaciones (marcas, categorías, imágenes).
     *
     * @param int $id ID del producto.
     * @return string Vista renderizada del producto.
     */
    public function show($id)
    {
        $producto = $this->productoModel->obtenerProductoPorId($id);

        if (!$producto) {
            return redirect()->to('/catalogo')->with('error', 'Producto no encontrado');
        }

        $breadcrumbs = [
            [
                'label' => 'Catálogo',
                'url'   => base_url('catalogo'),
            ],
            [
                'label' => $producto->nombre,
                'url'   => '',
            ],
        ];

        $data = [
            'producto'    => $producto,
            'titulo'      => $producto->nombre,
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/producto', $data);
    }
}
