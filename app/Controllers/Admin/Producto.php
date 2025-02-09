<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;
use App\Models\ImagenProductoModel;

/**
 * Description of Producto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Producto extends BaseController
{
    protected $productoModel;
    protected $marcaModel;
    protected $categoriaModel;


    public function __construct()
    {
        // Instanciar los modelos de forma centralizada para su uso en los métodos
        $this->productoModel = new ProductoModel();
        $this->marcaModel    = new MarcaModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $estado = $this->request->getGet('estado') ?? 'todos';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        // Obtiene los productos filtrados y paginados
        $productos = $this->productoModel->obtenerProductosFiltrados($estado, $busqueda, $perPage);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => ''],
        ];

        $data = [
            'titulo'      => 'Administrar Productos',
            'productos'   => $productos,
            'pager'       => $this->productoModel->pager,
            'estado'      => $estado,
            'busqueda'    => $busqueda,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('admin/producto/index', $data);
    }

    /**
     * Muestra el detalle completo de un producto.
     *
     * @param int $id ID del producto.
     */
    public function show($id)
    {
        $producto = $this->productoModel->obtenerProductoPorId($id);

        // Si el producto no tiene imágenes, asignar una imagen por defecto.
        if (empty($producto->imagenes)) {
            $producto->imagenes[] = (object) ['ruta_imagen' => 'uploads/productos/no-image.png'];
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => $producto->nombre, 'url' => ''],
        ];

        $data = [
            'titulo'      => $producto->nombre,
            'producto'    => $producto,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view("admin/producto/show", $data);
    }

    public function new()
    {
        $productoModel = $this->productoModel;
        $categoriaModel = $this->categoriaModel;
        $marcaModel = $this->marcaModel;

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => 'Crear Producto', 'url' => ''],
        ];

        $data = [
            'titulo'        => "Crear Producto",
            'producto'      => $productoModel,
            'categorias'    => $categoriaModel->find(),
            'marcas'        => $marcaModel->find(),
            'nombreBoton'   => 'Crear',
            'breadcrumbs'   => $breadcrumbs,
        ];

        echo view("admin/producto/new", $data);
    }

    public function create()
    {
        $productoModel = new ProductoModel();
        $imagenModel = new ImagenProductoModel();

        if (empty($data['ruta_imagen'])) {
            $data['ruta_imagen'] = 'uploads/productos/no_image.png';
        }

        if ($this->validate('productos_create')) {
            $productoModel->insert([
                'nombre'          => $this->request->getPost('nombre'),
                'descripcion'     => $this->request->getPost('descripcion'),
                'precio'          => $this->request->getPost('precio'),
                'stock'           => $this->request->getPost('stock'),
                'marca_id'        => $this->request->getPost('marca_id'),
                'presentacion'    => $this->request->getPost('presentacion'),
            ]);

            // 2. Obtener el ID del producto recién creado
            $productoId = $productoModel->getInsertID();

            // 3. Cargar las imágenes y asociarlas al producto
            $imagenes = $this->request->getFiles();

            foreach ($imagenes['imagenes'] as $imagen) {
                if ($imagen->isValid() && !$imagen->hasMoved()) {
                    $nuevoNombre = $imagen->getRandomName();
                    $imagen->move(WRITEPATH . 'uploads/productos', $nuevoNombre);

                    $imagenData = [
                        'nombre' => $imagen->getClientName(),
                        'ruta' => 'uploads/productos/' . $nuevoNombre,
                    ];

                    $imagenModel->save($imagenData); // Insertar en ImagenModel

                    $productoModel->imagenes()->attach($productoId, ['imagen_id' => $imagenModel->getInsertID()]);
                }
            }
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Alta de producto exitosa!');
    }

    /**
     * Muestra la vista para editar un producto.
     *
     * Se obtiene el producto por ID, se guarda el referer para luego poder regresar,
     * se generan los breadcrumbs y se pasan a la vista junto con las marcas y categorías.
     *
     * @param int $id ID del producto a editar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista de edición o redirección en caso de error.
     */
    public function edit($id)
    {
        // Obtener la URL referer para poder volver a la página anterior después de editar
        $referer = $this->request->getServer('HTTP_REFERER');
        session()->set('referer', $referer);

        // Obtener el producto por ID utilizando el método del modelo
        $producto = $this->productoModel->obtenerProductoPorId($id);
        if (!$producto) {
            // Si no se encuentra el producto, redirigir con mensaje de error
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }

        // Generar breadcrumbs dinámicos para la vista de edición
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de productos', 'url' => base_url('admin/productos')],
            ['label' => 'Edición: ' . $producto->nombre, 'url' => ''],
        ];

        // Preparar los datos a enviar a la vista
        $data = [
            'titulo'        => 'Editar Producto',
            'producto'      => $producto,
            'marcas'        => $this->marcaModel->find(),
            'categorias'    => $this->categoriaModel->find(),
            'nombre_boton'  => 'Editar',
            'referer'       => $referer,
            'breadcrumbs'   => $breadcrumbs,
        ];

        return view('admin/producto/edit', $data);
    }

    /**
     * Procesa la actualización de un producto.
     *
     * Se reciben los datos del formulario, se intenta actualizar el producto mediante el modelo
     * y, en función del resultado, se redirige a la vista de detalle o se vuelve al formulario con errores.
     *
     * @param int $id ID del producto a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la vista correspondiente.
     */
    public function update($id)
    {
        // Obtener los datos enviados por POST
        $data = $this->request->getPost();

        // Obtener el producto actual desde la base de datos
        $productoActual = $this->productoModel->find($id);

        // Si el nombre no ha cambiado, elimina la regla is_unique
        if ($data['nombre'] === $productoActual->nombre) {
            // Clonar las reglas de validación actuales
            $reglas = $this->productoModel->validationRules;
            // Remover la parte de is_unique de la regla 'nombre'
            // Por ejemplo, definir una nueva regla sin is_unique:
            $reglas['nombre'] = 'required|min_length[3]|max_length[255]';
            $this->productoModel->setValidationRules($reglas);
        }

        // Intentar actualizar el producto utilizando el método personalizado del modelo
        if ($this->productoModel->actualizarProducto($id, $data)) {
            // Redirigir a la vista de detalle del producto (incluyendo el ID) con mensaje de éxito
            return redirect()->to('admin/producto/' . $id)->with('mensaje', 'Producto modificado exitosamente!');
        } else {
            // Si hay errores, redirigir de vuelta al formulario conservando la información y los errores de validación
            return redirect()->back()->withInput()->with('errors', $this->productoModel->errors());
        }
    }

    public function delete($id)
    {

        $this->productoModel->eliminarProducto($id);

        return redirect()->to('admin/producto')->with('mensaje', 'Eliminacion exitosa!');
    }

    public function buscarProducto()
    {
        // Se leen los parámetros enviados por GET
        // Si no se envían, se asignan valores por defecto
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto  = $this->request->getGet('texto') ?? '';
        $estado = $this->request->getGet('estado') ?? 'todos';

        try {
            // Utiliza el modelo para obtener los productos filtrados y paginados.
            // Asegúrate de que el método filtrarProductos() en el modelo utilice el valor de $pagina.
            $productos = $this->productoModel->filtrarProductos($texto, $estado, $pagina);

            // Obtiene el total de páginas para la paginación, usando la misma búsqueda y filtro
            $totalPaginas = $this->productoModel->obtenerTotalPaginas($texto, $estado);

            // Se prepara un array con la información a retornar
            return $this->response->setJSON([
                'productos' => $productos,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            // En caso de error, se registra el error (opcional) y se retorna un mensaje JSON con status 500
            log_message('error', 'Error en buscarProductos: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar los productos. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
