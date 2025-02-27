<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\MarcaModel;

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
     * Instancia del modelo de Marcas.
     *
     * @var MarcaModel
     */
    protected $marcaModel;

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
        $this->marcaModel = new MarcaModel();
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
        $filtro  = $this->request->getGet();
        $session = session();

        // Si se solicita limpiar filtros, se remueven de la sesión y se redirige.
        if ($this->request->getGet('limpiar_filtros')) {
            $session->remove(['filtro_categoria', 'filtro_precio_min', 'filtro_precio_max', 'filtro_orden', 'filtro_marca']);
            return redirect()->to(route_to('web.catalogo'));
        }

        // Construir el query builder del modelo
        $builder = $this->productoModel->builder();

        // Aplicar filtros (categorías, precio, marcas, etc.)
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

        if (!empty($filtro['marca'])) {
            $builder->whereIn('productos.marca_id', $filtro['marca']);
            $session->set('filtro_marca', $filtro['marca']);
        } elseif ($session->has('filtro_marca')) {
            $filtro['marca'] = $session->get('filtro_marca');
            $builder->whereIn('productos.marca_id', $filtro['marca']);
        }

        // Ordenamiento
        if (!empty($filtro['orden'])) {
            $session->set('filtro_orden', $filtro['orden']);
        } else {
            if ($session->has('filtro_orden')) {
                $filtro['orden'] = $session->get('filtro_orden');
            } else {
                $filtro['orden'] = 'fecha_registro';  // Valor por defecto
            }
        }

        switch ($filtro['orden']) {
            case 'precio_asc':
                $builder->orderBy('productos.precio', 'ASC');
                break;
            case 'precio_desc':
                $builder->orderBy('productos.precio', 'DESC');
                break;
            case 'alfabetico_asc':
                $builder->orderBy('productos.nombre', 'ASC');
                break;
            case 'alfabetico_desc':
                $builder->orderBy('productos.nombre', 'DESC');
                break;
            case 'novedades':
            default:
                $builder->orderBy('productos.created_at', 'DESC');
                break;
        }

        // Siempre filtrar productos activos con stock > 0 y estado activo
        $builder->where('productos.stock >', 0);
        $builder->where('productos.estado', 'activo');

        // Configuración de paginación
        $porPagina = 12;
        $page    = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;
        $offset  = ($page - 1) * $porPagina;

        // Clonar el builder para contar el total sin límite
        $builderClone = clone $builder;
        $total = $builderClone->countAllResults(false); // 'false' evita reiniciar el builder

        // Obtener solo los productos de la página actual usando nuestro método personalizado
        $productos = $this->productoModel->getProductosActivos($builder, $porPagina, $offset);

        // Crear los enlaces de paginación utilizando la plantilla 'default_full' definida en Pager.php
        $pager = \Config\Services::pager();
        $links = $pager->makeLinks($page, $porPagina, $total, 'default_full');

        // Obtener categorías y marcas con productos activos en stock
        $categorias = $this->categoriaModel->obtenerCategoriasConProductosActivos();
        $marcas     = $this->marcaModel->obtenerMarcasConProductosActivos();

        $breadcrumbs = [
            [
                'label' => 'Catálogo',
                'url'   => '',
            ],
        ];

        $data = [
            'titulo'      => 'Catálogo',
            'productos'   => $productos,
            'pager'       => $links,  // Enlaces de paginación generados manualmente
            'categorias'  => $categorias,
            'marcas'      => $marcas,
            'filtro'      => $filtro,
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('web/catalogo', $data);
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

    /**
     * Muestra una lista de sugerencias de productos que coinciden con la búsqueda.
     *
     * Este método se invoca cuando se envía el parámetro "buscador" desde el formulario de búsqueda.
     *
     * @return string Vista con las sugerencias.
     */
    public function sugerencias()
    {
        $query = $this->request->getGet('buscador');

        $breadcrumbs = [
            [
                'label' => 'Catálogo',
                'url'   => base_url('catalogo'),
            ],
            [
                'label' => 'Sugerencias',
                'url'   => '',
            ],
        ];

        if (empty($query)) {
            $data = [
                'titulo'      => 'Sugerencias',
                'cart'        => $this->cart,
                'breadcrumbs' => $breadcrumbs,
                'query'       => $query,
                'sugerencias' => [],
                'pager'       => null,
            ];
            return view('web/sugerencias',  $data);
        }

        // Reiniciar condiciones anteriores en el modelo
        $this->productoModel->resetQuery();

        // Aplicar el filtro de búsqueda y obtener el builder filtrado.
        // Se asume que este método devuelve el builder configurado:
        $builder = $this->productoModel->buscarProductosPorNombre($query);

        $porPagina = 10;
        $page      = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;
        $offset    = ($page - 1) * $porPagina;

        // Clonar el builder para contar el total sin afectar la consulta principal
        $builderClone = clone $builder;
        $total = $builderClone->countAllResults(false);

        // Obtener los registros filtrados para la página actual
        $sugerencias = $builder->limit($porPagina, $offset)->get()->getResult();

        // Generar los enlaces de paginación utilizando la plantilla 'default_full'
        $pager = \Config\Services::pager();
        $links = $pager->makeLinks($page, $porPagina, $total, 'default_full');

        $data = [
            'titulo'      => 'Sugerencias',
            'cart'        => $this->cart,
            'breadcrumbs' => $breadcrumbs,
            'query'       => $query,
            'sugerencias' => $sugerencias,
            'pager'       => $links,
        ];

        return view('web/sugerencias', $data);
    }
}
