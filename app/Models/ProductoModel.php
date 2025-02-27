<?php

namespace App\Models;

use CodeIgniter\Model;

/**LISTO
 * Modelo para la gestión de productos.
 *
 * Este modelo administra las operaciones CRUD para los productos, incluyendo
 * validación de datos, filtrado, paginación y relaciones con marcas, categorías e imágenes.
 *
 * @package App\Models
 */
class ProductoModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'marca_id',
        'modelo',
        'peso',
        'dimensiones',
        'material',
        'color',
        'estado'
    ];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    // Reglas de validación para cada campo
    protected $validationRules = [
        'nombre'       => 'required|min_length[3]|max_length[255]|is_unique[productos.nombre,id,{id}]|regex_match[/^(?!.*[()]).+$/]',
        'descripcion'  => 'permit_empty',
        'precio'       => 'required|decimal|greater_than[0]',
        'stock'        => 'required|integer|is_natural_no_zero',
        'categoria_id' => 'required|integer',
        'marca_id'     => 'required|integer',
        'modelo'       => 'permit_empty|max_length[255]',
        'peso'         => 'permit_empty|max_length[255]',
        'dimensiones'  => 'permit_empty|max_length[255]',
        'material'     => 'permit_empty|max_length[255]',
        'color'        => 'permit_empty|max_length[255]',
        'estado'       => 'required|in_list[activo,inactivo]'
    ];

    // Mensajes personalizados para la validación
    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre del producto es obligatorio.',
            'min_length'  => 'El nombre del producto debe tener al menos 3 caracteres.',
            'max_length'  => 'El nombre del producto no puede superar los 255 caracteres.',
            'is_unique'   => 'Ya existe un producto con ese nombre.',
            'regex_match' => 'El nombre del producto no puede contener paréntesis.'
        ],
        'precio' => [
            'required'     => 'El precio es obligatorio.',
            'decimal'      => 'El precio debe ser un número decimal.',
            'greater_than' => 'El precio debe ser mayor a 0.'
        ],
        'stock' => [
            'required'           => 'El stock es obligatorio.',
            'integer'            => 'El stock debe ser un número entero.',
            'is_natural_no_zero' => 'El stock debe ser un número natural mayor a 0.'
        ],
        'categoria_id' => [
            'required' => 'La categoría es obligatoria.',
            'integer'  => 'La categoría debe ser un número entero.'
        ],
        'marca_id' => [
            'required' => 'La marca es obligatoria.',
            'integer'  => 'La marca debe ser un número entero.'
        ],
        'modelo' => [
            'max_length' => 'El modelo no puede superar los 255 caracteres.'
        ],
        'peso' => [
            'max_length' => 'El peso no puede superar los 255 caracteres.'
        ],
        'dimensiones' => [
            'max_length' => 'Las dimensiones no pueden superar los 255 caracteres.'
        ],
        'material' => [
            'max_length' => 'El material no puede superar los 255 caracteres.'
        ],
        'color' => [
            'max_length' => 'El color no puede superar los 255 caracteres.'
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list'  => 'El estado debe ser "activo" o "inactivo".'
        ]
    ];

    // --------------------------------------------------------------------------------
    // Métodos de Relaciones
    // --------------------------------------------------------------------------------

    /**
     * Obtiene la categoría asociada a un producto.
     *
     * @param int $productoId ID del producto.
     * @return object|null Objeto con la categoría o null si no se encuentra.
     */
    public function getCategoriaByProducto(int $productoId)
    {
        return $this->select('categorias.*')
            ->join('categorias', 'categorias.id = productos.categoria_id')
            ->where('productos.id', $productoId)
            ->first();
    }

    /**
     * Obtiene la marca asociada a un producto.
     *
     * @param int $productoId ID del producto.
     * @return object|null Objeto con la marca o null si no se encuentra.
     */
    public function getMarcaByProducto(int $productoId)
    {
        return $this->select('marcas.*')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->where('productos.id', $productoId)
            ->first();
    }

    /**
     * Obtiene las imágenes asociadas a un producto.
     *
     * @param int $productoId ID del producto.
     * @return array Array de imágenes asociadas.
     */
    public function getImagenesByProducto(int $productoId): array
    {
        $imagenModel = new \App\Models\ImagenProductoModel();
        return $imagenModel->where('producto_id', $productoId)->findAll();
    }

    // --------------------------------------------------------------------------------
    // Métodos CRUD
    // --------------------------------------------------------------------------------

    /**
     * Obtiene el producto por su ID con todos los detalles necesarios para la vista de producto,
     * incluyendo la marca, la categoría y todas las imágenes asociadas.
     *
     * Se realiza un JOIN con las tablas "marcas" y "categorias" para obtener los nombres correspondientes.
     * Luego se consulta el modelo de imágenes para agregar un array con todas las imágenes vinculadas al producto.
     * Se ordenan las imágenes por 'id' en orden ascendente para que la primera imagen aparezca primero.
     *
     * @param int $productoId El ID del producto a obtener.
     * @return object|null Devuelve el objeto producto con propiedades adicionales:
     *                     - marca_nombre: Nombre de la marca asociada.
     *                     - categoria_nombre: Nombre de la categoría asociada.
     *                     - imagenes: Array de objetos con las imágenes asociadas.
     *                     Retorna null si no se encuentra el producto.
     */
    public function obtenerProductoPorId(int $productoId)
    {
        // Reiniciar el query builder para asegurarnos de que no queden configuraciones previas.
        // (No existe resetSelect() en CI4, así que se utiliza el segundo parámetro "false" en select())
        $this->builder()->resetQuery();

        // Definir la selección de campos: todos los campos de 'productos' y los alias para marca y categoría.
        $this->select(
            'productos.*, marcas.nombre as marca_nombre, categorias.nombre as categoria_nombre',
            false
        )
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.id', $productoId);

        // Ejecutar la consulta y obtener el producto
        $producto = $this->get()->getRow();

        if ($producto) {
            // Instanciar el modelo de imágenes y obtener todas las imágenes asociadas,
            // ordenándolas por 'id' de forma ascendente (la primera imagen aparecerá primero)
            $imagenModel = new \App\Models\ImagenProductoModel();
            $producto->imagenes = $imagenModel->where('producto_id', $productoId)
                ->orderBy('id', 'ASC')
                ->findAll();

            // Opcional: Si no hay imágenes, se puede asignar una imagen por defecto
            if (empty($producto->imagenes)) {
                $producto->imagenes[] = (object) ['ruta_imagen' => 'uploads/productos/no-image.png'];
            }
        }

        return $producto;
    }


    /**
     * Actualiza los datos de un producto.
     *
     * Valida los datos ingresados y, si son correctos, actualiza el producto.
     *
     * @param int $id ID del producto.
     * @param array $data Datos a actualizar.
     * @return bool True si se actualizó correctamente, false en caso de error.
     */
    public function actualizarProducto($id, $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        return $this->update($id, $data);
    }

    /**
     * Da de baja un producto cambiando su estado a "inactivo".
     *
     * @param int $id ID del producto.
     * @return bool True si se actualizó correctamente, false en caso de error.
     */
    public function eliminarProducto($id)
    {
        $data['estado'] = 'inactivo';

        return $this->update($id, $data);
    }

    /**
     * Obtiene los productos activos junto con la primera imagen asociada,
     * el nombre de la marca y el nombre de la categoría, con soporte para paginación.
     *
     * Se filtra por productos con estado 'activo' y se ordenan por 'updated_at'
     * en orden descendente (los más recientes primero). Además, se utiliza una
     * subconsulta con COALESCE para obtener la ruta de la primera imagen asociada,
     * o devolver una ruta por defecto ('uploads/productos/no-image.png') si no existe.
     *
     * @param \CodeIgniter\Database\BaseBuilder|null $builder (Opcional) Instancia del Query Builder con filtros previos.
     * @param int|null $limit Cantidad de registros a retornar (para paginación).
     * @param int $offset Desplazamiento (para paginación).
     * @return array Lista de productos activos (como objetos) con los campos adicionales:
     *               - imagen_principal: ruta de la primera imagen (o la imagen por defecto si no existe).
     *               - marca_nombre: nombre de la marca.
     *               - categoria_nombre: nombre de la categoría.
     */
    public function getProductosActivos($builder = null, int $limit = null, int $offset = 0)
    {
        if ($builder === null) {
            $builder = $this->builder();
        }

        // Seleccionar campos y la subconsulta para la imagen principal
        $builder->select(
            "productos.*, 
         COALESCE(
             (SELECT ip.ruta_imagen 
              FROM imagenes_productos ip 
              WHERE ip.producto_id = productos.id 
              ORDER BY ip.id ASC LIMIT 1),
             'uploads/productos/no-image.png'
         ) AS imagen_principal, 
         marcas.nombre as marca_nombre, 
         categorias.nombre as categoria_nombre",
            false
        );

        // LEFT JOIN para obtener nombres de marca y categoría
        $builder->join('marcas', 'marcas.id = productos.marca_id', 'left');
        $builder->join('categorias', 'categorias.id = productos.categoria_id', 'left');

        // Filtrar solo productos activos
        $builder->where('productos.estado', 'activo');

        // Ordenar resultados por fecha de actualización (más recientes primero)
        $builder->orderBy('productos.updated_at', 'DESC');

        // Aplicar límite y offset para la paginación
        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResult();
    }

    /**
     * Crea un nuevo producto.
     *
     * Valida los datos del producto utilizando las reglas definidas en el modelo. Si los datos son válidos,
     * inserta el producto y retorna su ID. En caso contrario, retorna false.
     *
     * @param array $data Datos del producto a insertar.
     * @return int|false ID del producto insertado o false si la validación falla.
     */
    public function crearProducto(array $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        $this->insert($data);

        return $this->getInsertID();
    }

    // --------------------------------------------------------------------------------
    // Métodos para Filtrado y Paginación
    // --------------------------------------------------------------------------------

    /**
     * Obtiene los productos filtrados y paginados, incluyendo los nombres de la marca y la categoría.
     *
     * Aplica filtros de búsqueda en los campos "productos.nombre" y "productos.descripcion", y filtra por el
     * estado de los productos (si no es "todos"). Se realizan joins con las tablas "categorias" y "marcas" para
     * traer los nombres correspondientes. Los resultados se ordenan por "productos.updated_at" en orden descendente.
     *
     * La paginación se realiza utilizando el método paginate(), que toma el número de registros por página,
     * el grupo (por defecto "default") y la página actual ($pagina).
     *
     * @param string $estado   Estado a filtrar ("activo", "inactivo" o "todos").
     * @param string $busqueda Término de búsqueda para los campos "nombre" y "descripcion".
     * @param int $pagina      Página actual a mostrar.
     * @param int $perPage     Número de registros por página.
     * @return mixed           Array de productos filtrados; el pager se configura automáticamente.
     */
    public function obtenerProductosFiltrados(string $estado = 'todos', string $busqueda = '', int $pagina = 1, int $perPage = 10)
    {
        // Reiniciar el query builder para evitar interferencias de consultas previas
        $this->builder()->resetQuery();

        // Seleccionar los campos de productos y agregar alias para el nombre de la categoría y la marca
        $this->select('productos.*, categorias.nombre as categoria_nombre, marcas.nombre as marca_nombre');

        // Realizar los joins con las tablas de categorías y marcas (LEFT JOIN para incluir productos sin asignación)
        $this->join('categorias', 'categorias.id = productos.categoria_id', 'left');
        $this->join('marcas', 'marcas.id = productos.marca_id', 'left');

        // Aplicar filtro de búsqueda si se proporciona
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('productos.nombre', $busqueda)
                ->orLike('productos.descripcion', $busqueda)
                ->groupEnd();
        }

        // Aplicar filtro por estado si no es "todos"
        if ($estado !== 'todos') {
            $this->where('productos.estado', $estado);
        }

        // Ordenar los resultados por "productos.updated_at" de forma descendente
        $this->orderBy('productos.updated_at', 'DESC');

        // Retornar los resultados paginados, pasando el número de registros por página y la página actual
        return $this->paginate($perPage, 'default', $pagina);
    }

    /**
     * Obtiene el total de páginas para la paginación de productos según los filtros aplicados.
     *
     * Cuenta los registros que coinciden con el término de búsqueda y el estado (si no es "todos"),
     * y calcula el total de páginas basado en el número de registros por página.
     *
     * @param string $texto   Texto de búsqueda.
     * @param string $estado  Estado a filtrar ("activo", "inactivo" o "todos").
     * @param int $porPagina  Número de registros por página.
     * @return int Total de páginas.
     */
    public function obtenerTotalPaginas(string $texto = '', string $estado = 'todos', int $porPagina = 10): int
    {
        $builder = $this->builder();

        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('descripcion', $texto)
                ->groupEnd();
        }

        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        $totalRegistros = $builder->countAllResults();
        return (int) ceil($totalRegistros / $porPagina);
    }

    /**
     * Actualiza el stock de un producto restando la cantidad vendida.
     *
     * Obtiene el stock actual del producto, le resta la cantidad indicada (convertida a entero)
     * y actualiza el registro en la base de datos. Si el stock resultante es menor que cero, se ajusta a cero.
     * Si el nuevo stock es igual al stock actual (por ejemplo, si la cantidad es 0 o el stock ya es 0),
     * retorna true sin realizar la actualización.
     *
     * @param int $productoId ID del producto a actualizar.
     * @param int|string $cantidad Cantidad a restar del stock.
     * @return bool True si la actualización es exitosa o si no hay cambio, false en caso contrario.
     */
    public function actualizarStock($productoId, $cantidad)
    {
        // Convertir la cantidad a entero
        $cantidad = (int)$cantidad;

        // Obtener el producto actual
        $producto = $this->find($productoId);
        if (!$producto) {
            // Producto no encontrado
            return false;
        }

        // Convertir el stock actual a entero
        $currentStock = (int)$producto->stock;

        // Calcular el nuevo stock
        $nuevoStock = $currentStock - $cantidad;

        // Evitar que el stock quede negativo
        if ($nuevoStock < 0) {
            $nuevoStock = 0;
        }

        // Si el stock no cambia, retornar true
        if ($nuevoStock === $currentStock) {
            return true;
        }

        // Actualizar el stock en la base de datos
        return $this->update($productoId, ['stock' => $nuevoStock]);
    }

    /**
     * Busca productos activos cuyo nombre coincida (parcialmente) con el término dado.
     *
     * @param string $query Término de búsqueda.
     * @param int    $limite (Opcional) Cantidad máxima de sugerencias a retornar. Por defecto 10.
     *
     * @return array Lista de productos que coinciden.
     */
    public function buscarProductosPorNombre($query)
    {
        // Obtiene el builder
        $builder = $this->builder();
        // Aplica el filtro de búsqueda
        $builder->like('nombre', $query)
            ->where('estado', 'activo')
            ->where('stock >', 0);
        return $builder;
    }
}
