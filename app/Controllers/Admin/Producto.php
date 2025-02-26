<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;
use App\Models\ImagenProductoModel;

/** LISTO
 * Controlador para la gestión de productos.
 *
 * Este controlador administra la visualización, creación, actualización, eliminación y filtrado
 * de productos, incluyendo la integración con las marcas y categorías asociadas.
 * 
 * @package App\Controllers\Admin
 */
class Producto extends BaseController
{
    /**
     * @var ProductoModel
     */
    protected $productoModel;
    /**
     * @var MarcaModel
     */
    protected $marcaModel;
    /**
     * @var CategoriaModel
     */
    protected $categoriaModel;
    /**
     * @var ImagenModel
     */
    protected $imagenModel;

    /**
     * Constructor.
     * Se instancian los modelos necesarios para la gestión de productos.
     */
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->marcaModel    = new MarcaModel();
        $this->categoriaModel = new CategoriaModel();
        $this->imagenModel   = new ImagenProductoModel();
    }

    /**
     * Muestra la lista de productos con filtros y paginación.
     *
     * Recoge los parámetros de filtrado y búsqueda (estado, textoBusqueda y página) desde GET,
     * obtiene los productos filtrados mediante el modelo y carga la vista correspondiente con
     * los datos necesarios, incluyendo breadcrumbs y conteos.
     *
     * @return string Vista renderizada.
     */
    public function index()
    {
        // Recoger parámetros desde GET con valores por defecto
        $estado        = $this->request->getGet('estado') ?? 'todos';
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $pagina        = $this->request->getGet('pagina') ?? 1;
        $perPage       = 10; // Registros por página

        // Obtener productos filtrados y paginados (se pasa la página actual)
        $productos = $this->productoModel->obtenerProductosFiltrados($estado, $textoBusqueda, $pagina, $perPage);

        // Configurar breadcrumbs para la navegación interna
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => '']
        ];

        // Obtener conteos pendientes (este método se asume definido en el controlador base)
        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Administrar Productos',
            'productos'           => $productos,
            'pager'               => $this->productoModel->pager,
            'estado'              => $estado,
            'textoBusqueda'       => $textoBusqueda,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/producto/index', $data);
    }

    /**
     * Muestra el detalle completo de un producto.
     *
     * Obtiene el producto por su ID y, en caso de que no tenga imágenes, asigna una imagen
     * por defecto. Configura también los breadcrumbs y otros datos necesarios para la vista.
     *
     * @param int $id ID del producto.
     * @return string Vista renderizada o redirección en caso de error.
     */
    public function show($id)
    {
        $producto = $this->productoModel->obtenerProductoPorId($id);

        // Si el producto no tiene imágenes, asignar una imagen por defecto.
        if (empty($producto->imagenes)) {
            $producto->imagenes[] = (object)['ruta_imagen' => 'uploads/productos/no-image.png'];
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => $producto->nombre, 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'      => $producto->nombre,
            'producto'    => $producto,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view("admin/producto/show", $data);
    }

    /**
     * Muestra la vista para crear un nuevo producto.
     *
     * Se obtienen las marcas y categorías para llenar los selects en el formulario,
     * y se guarda el referer para poder regresar después de editar.
     *
     * @return string Vista de creación.
     */
    public function new()
    {
        // Guardar el referer para volver a la página anterior luego de la edición
        $referer = $this->request->getServer('HTTP_REFERER');
        session()->set('referer', $referer);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => 'Crear Producto', 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'        => "Crear Producto",
            'producto'      => $this->productoModel,
            'categorias'    => $this->categoriaModel->find(),
            'marcas'        => $this->marcaModel->find(),
            'breadcrumbs'   => $breadcrumbs,
            'referer'       => $referer,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view("admin/producto/new", $data);
    }

    /**
     * Crea un nuevo producto y procesa la subida de imágenes.
     *
     * Recoge los datos del formulario vía POST y utiliza el modelo para crear el producto.
     * Luego procesa la subida de imágenes; si no se sube ninguna, asigna una imagen por defecto.
     * Redirige a la vista de listado de productos con un mensaje de éxito.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function create()
    {
        // Recoger datos del formulario
        $dataProducto = $this->request->getPost();

        // Crear el producto (la validación y guardado se realizan en el modelo)
        $productoId = $this->productoModel->crearProducto($dataProducto);

        if (!$productoId) {
            session()->setFlashdata('errors', $this->productoModel->errors());
            return redirect()->back()->withInput();
        }

        // Procesar la subida de imágenes
        $archivos = $this->request->getFiles();
        $subioImagen = false;

        // Procesar la imagen principal (campo "imagen")
        if (isset($archivos['imagen'])) {
            $imagenPrincipal = $archivos['imagen'];
            if ($imagenPrincipal->isValid() && !$imagenPrincipal->hasMoved()) {
                $nuevoNombre = $imagenPrincipal->getRandomName();
                if ($imagenPrincipal->move(FCPATH . 'uploads/productos', $nuevoNombre)) {
                    $imagenData = [
                        'nombre'       => $imagenPrincipal->getClientName(),
                        'ruta_imagen'  => 'uploads/productos/' . $nuevoNombre,
                        'producto_id'  => $productoId,
                    ];
                    $this->imagenModel->insert($imagenData);
                    $subioImagen = true;
                } else {
                    log_message('errors', 'Error al mover la imagen principal: ' . $imagenPrincipal->getErrorString());
                }
            }
        }

        // Procesar imágenes adicionales (campo "imagenes[]")
        if (isset($archivos['imagenes'])) {
            foreach ($archivos['imagenes'] as $imagen) {
                if ($imagen->isValid() && !$imagen->hasMoved()) {
                    $nuevoNombre = $imagen->getRandomName();
                    if ($imagen->move(FCPATH . 'uploads/productos', $nuevoNombre)) {
                        $imagenData = [
                            'nombre'       => $imagen->getClientName(),
                            'ruta_imagen'  => 'uploads/productos/' . $nuevoNombre,
                            'producto_id'  => $productoId,
                        ];
                        $this->imagenModel->insert($imagenData);
                        $subioImagen = true;
                    } else {
                        log_message('errors', 'Error al mover imagen adicional: ' . $imagen->getErrorString());
                    }
                }
            }
        }
        return redirect()->to('/admin/producto')->with('mensaje', 'Alta de producto exitosa!');
    }

    /**
     * Muestra la vista para editar un producto.
     *
     * Obtiene el producto por ID, guarda el referer para regresar y configura los breadcrumbs,
     * además de pasar las marcas y categorías a la vista.
     *
     * @param int $id ID del producto a editar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista de edición o redirección en caso de error.
     */
    public function edit($id)
    {
        // Guardar el referer para volver a la página anterior después de editar
        $referer = $this->request->getServer('HTTP_REFERER');
        session()->set('referer', $referer);

        $producto = $this->productoModel->obtenerProductoPorId($id);
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }

        // Si el producto no tiene imágenes, asignar una imagen por defecto
        if (empty($producto->imagenes)) {
            $producto->imagenes[] = (object)[
                'id'          => 0,
                'nombre'      => 'No Image',
                'ruta_imagen' => 'uploads/productos/no-image.png'
            ];
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => 'Edición: ' . $producto->nombre, 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Editar Producto',
            'producto'            => $producto,
            'marcas'              => $this->marcaModel->find(),
            'categorias'          => $this->categoriaModel->find(),
            'referer'             => $referer,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/producto/edit', $data);
    }

    /**
     * Procesa la actualización de un producto.
     *
     * Recoge los datos del formulario vía POST, compara el nombre para evitar validación
     * innecesaria, y actualiza el producto. Si la actualización es exitosa, procesa la subida de imágenes.
     * Redirige a la vista de detalle del producto o vuelve al formulario con errores.
     *
     * @param int $id ID del producto a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id)
    {
        // Recoger datos del formulario
        $data = $this->request->getPost();

        // Obtener el producto actual para comparar el nombre y evitar la validación is_unique
        $productoActual = $this->productoModel->obtenerProductoPorId($id);

        if ($data['nombre'] === $productoActual->nombre) {
            // Remover la regla de unicidad para el campo 'nombre'
            $reglas = $this->productoModel->validationRules;
            $reglas['nombre'] = 'required|min_length[3]|max_length[255]';
            $this->productoModel->setValidationRules($reglas);
        }

        if ($this->productoModel->actualizarProducto($id, $data)) {

            // Procesar la subida de imágenes (imágenes adicionales)
            $imagenes = $this->request->getFiles();
            if (!empty($imagenes['imagenes'])) {
                $imagenModel = new \App\Models\ImagenProductoModel();
                foreach ($imagenes['imagenes'] as $imagen) {
                    if ($imagen->isValid() && !$imagen->hasMoved()) {
                        $nuevoNombre = $imagen->getRandomName();
                        if ($imagen->move(FCPATH . 'uploads/productos', $nuevoNombre)) {
                            $imagenData = [
                                'nombre'       => $imagen->getClientName(),
                                'ruta_imagen'  => 'uploads/productos/' . $nuevoNombre,
                                'producto_id'  => $id,
                            ];
                            $imagenModel->insert($imagenData);
                        } else {
                            log_message('error', 'Error al mover imagen adicional: ' . $imagen->getErrorString());
                        }
                    }
                }
            }

            return redirect()->to('admin/productos/' . $id)->with('mensaje', 'Producto modificado exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->productoModel->errors());
        }
    }

    /**
     * Elimina un producto (dar de baja cambiando su estado a inactivo).
     *
     * @param int $id ID del producto a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $this->productoModel->eliminarProducto($id);
        return redirect()->to('admin/producto')->with('mensaje', 'Eliminación exitosa!');
    }

    /**
     * Filtra y busca productos mediante AJAX.
     *
     * Recoge los parámetros GET (estado, textoBusqueda, página) y utiliza el modelo para obtener
     * los productos filtrados y el total de páginas. Retorna los datos en formato JSON.
     *
     * @return \CodeIgniter\HTTP\Response JSON con productos, página actual y total de páginas.
     */
    public function buscarProducto()
    {
        $estado        = $this->request->getGet('estado') ?? 'todos';
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $pagina        = $this->request->getGet('pagina') ?? 1;
        $perPage       = 10;

        try {
            // Obtener productos filtrados y paginados
            $productos = $this->productoModel->obtenerProductosFiltrados($estado, $textoBusqueda, $pagina, $perPage);
            // Obtener el total de páginas
            $totalPaginas = $this->productoModel->obtenerTotalPaginas($textoBusqueda, $estado);

            return $this->response->setJSON([
                'productos'    => $productos,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error en buscarProducto: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar los productos. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
