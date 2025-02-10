<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

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

    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[255]|is_unique[productos.nombre,id,{id}]',
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
        'estado'       => 'required|in_list[activo,inactivo]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del producto es obligatorio.',
            'min_length' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del producto no puede superar los 255 caracteres.',
            'is_unique'  => 'Ya existe un producto con ese nombre.'
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
        ],
    ];

    // Métodos para relaciones

    public function getCategoriaByProducto(int $productoId)
    {
        return $this->select('categorias.*')
            ->join('categorias', 'categorias.id = productos.categoria_id')
            ->where('productos.id', $productoId)
            ->first();
    }

    public function getMarcaByProducto(int $productoId)
    {
        return $this->select('marcas.*')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->where('productos.id', $productoId)
            ->first();
    }

    public function getImagenesByProducto(int $productoId): array
    {
        $imagenModel = new \App\Models\ImagenProductoModel();
        return $imagenModel->where('producto_id', $productoId)->findAll();
    }

    /**
     * Actualiza los datos de un producto.
     *
     * Valida los datos ingresados y, si son válidos, actualiza el producto con el ID especificado.
     * Se forza el estado a 'activo' antes de la actualización.
     *
     * @param int   $id   ID del producto.
     * @param array $data Datos a actualizar.
     * @return bool Resultado de la actualización (true si se actualizó, false en caso de error).
     */
    public function actualizarProducto($id, $data)
    {
        // Valida los datos según las reglas definidas
        if (!$this->validate($data)) {
            return false;
        }

        // Forzar el estado a 'activo'
        $data['estado'] = 'activo';

        // Actualiza el producto y retorna el resultado
        return $this->update($id, $data);
    }

    // Eliminar Producto (dar de baja -> estado == 'inactivo')
    public function eliminarProducto($id)
    {
        $data['estado'] = 'inactivo';

        return $this->update($id, $data);
    }

    // Métodos para consultas personalizadas

    /**
     * Filtra los productos aplicando los parámetros de búsqueda y estado,
     * y devuelve los resultados paginados en un array asociativo.
     *
     * Se aplica la búsqueda en 'nombre' y 'descripcion' y se filtra por estado (salvo que sea 'todos').
     * Se utilizan joins para incluir los nombres de la categoría y de la marca (alias: categoria_nombre y marca_nombre).
     *
     * @param string $texto Término de búsqueda.
     * @param string $estado Valor del estado ('activo', 'inactivo' o 'todos').
     * @param int $pagina Número de página (para el offset).
     * @param int $porPagina Cantidad de registros por página.
     * @return array Lista de productos filtrados (como array asociativo) con los campos adicionales.
     */
    public function filtrarProductos($texto = '', $estado = 'todos', $pagina = 1, $porPagina = 10)
    {
        // Iniciar la consulta utilizando el Query Builder del modelo.
        $builder = $this->builder();

        // Para evitar que se concatenen campos de un select previo, definimos la cláusula SELECT de forma exclusiva.
        $builder->select('productos.*, categorias.nombre as categoria_nombre, marcas.nombre as marca_nombre', false);

        // Realizar los joins para traer los datos de categoría y marca.
        $builder->join('categorias', 'categorias.id = productos.categoria_id', 'left');
        $builder->join('marcas', 'marcas.id = productos.marca_id', 'left');

        // Aplicar filtro de texto (búsqueda) en 'nombre' y 'descripcion'
        if (!empty($texto)) {
            $builder->groupStart()
                ->like('productos.nombre', $texto)
                ->orLike('productos.descripcion', $texto)
                ->groupEnd();
        }

        // Aplicar filtro de estado, salvo que sea 'todos'
        if ($estado !== 'todos') {
            $builder->where('productos.estado', $estado);
        }

        // Ordenar por 'updated_at' en orden descendente (los más recientes primero)
        $builder->orderBy('productos.updated_at', 'DESC');

        // Calcular el offset para la paginación
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        // Ejecutar la consulta y devolver los resultados como un array asociativo
        return $builder->get()->getResultArray();
    }


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
     * Obtiene los productos filtrados y paginados, incluyendo los nombres de la marca y la categoría.
     *
     * Se filtran según el término de búsqueda (aplicado a 'productos.nombre' y 'productos.descripcion')
     * y el estado (si no es 'todos'). Los resultados se ordenan por 'productos.updated_at' en orden descendente.
     * Se utilizan joins para traer los nombres de la categoría y la marca.
     *
     * @param string $estado Valor del estado a filtrar (por ejemplo, 'activo' o 'inactivo'). Si es 'todos', no filtra.
     * @param string $busqueda Término de búsqueda para los campos 'nombre' y 'descripcion'.
     * @param int $perPage Número de registros por página.
     * @return array Lista de productos filtrados (como objetos) con los campos adicionales:
     *               - marca_nombre: nombre de la marca.
     *               - categoria_nombre: nombre de la categoría.
     */
    public function obtenerProductosFiltrados($estado = 'todos', $busqueda = '', $perPage = 10)
    {
        // Reinicia el query builder para evitar condiciones heredadas.
        $this->builder()->resetQuery();

        // Definir la selección de campos: todos los de productos y los alias para marca y categoría.
        $this->select('productos.*, categorias.nombre as categoria_nombre, marcas.nombre as marca_nombre');

        // Realizar los joins necesarios para traer los nombres de categoría y marca.
        $this->join('categorias', 'categorias.id = productos.categoria_id', 'left');
        $this->join('marcas', 'marcas.id = productos.marca_id', 'left');

        // Aplicar filtro de búsqueda si se define.
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('productos.nombre', $busqueda)
                ->orLike('productos.descripcion', $busqueda)
                ->groupEnd();
        }

        // Aplicar filtro por estado si éste no es 'todos'
        if ($estado !== 'todos') {
            $this->where('productos.estado', $estado);
        }

        // Ordenar los resultados por la fecha de actualización (los más recientes primero)
        $this->orderBy('productos.updated_at', 'DESC');

        // Devolver la paginación con el número de registros indicado
        return $this->paginate($perPage);
    }


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
     * Obtiene los productos activos junto con la primera imagen asociada,
     * el nombre de la marca y el nombre de la categoría.
     *
     * Se filtra por productos con estado 'activo' y se ordenan por 'updated_at'
     * en orden descendente (los más recientes primero). Además, se utiliza una subconsulta
     * para traer la ruta de la primera imagen asociada a cada producto.
     *
     * @param \CodeIgniter\Database\BaseBuilder|null $builder (Opcional) Instancia del Query Builder con filtros previos.
     * @return array Lista de productos activos (como objetos) con los campos adicionales:
     *               - imagen_principal: ruta de la primera imagen.
     *               - marca_nombre: nombre de la marca.
     *               - categoria_nombre: nombre de la categoría.
     */
    public function getProductosActivos($builder = null)
    {
        // Si no se pasa un objeto builder, se obtiene uno nuevo desde el modelo.
        if ($builder === null) {
            $builder = $this->builder();
        }

        // Definir la cláusula SELECT de forma exclusiva (sin concatenar selects previos)
        // El segundo parámetro "false" indica que se reemplaza cualquier selección previa.
        $builder->select(
            'productos.*, 
         (SELECT ip.ruta_imagen 
          FROM imagenes_productos ip 
          WHERE ip.producto_id = productos.id 
          ORDER BY ip.id ASC LIMIT 1) AS imagen_principal, 
         marcas.nombre as marca_nombre, 
         categorias.nombre as categoria_nombre',
            false
        );

        // Realizar los joins para obtener los nombres de la marca y la categoría.
        // Se usan LEFT JOIN para evitar excluir productos sin asignación.
        $builder->join('marcas', 'marcas.id = productos.marca_id', 'left');
        $builder->join('categorias', 'categorias.id = productos.categoria_id', 'left');

        // Filtrar para obtener únicamente los productos con estado 'activo'
        $builder->where('productos.estado', 'activo');

        // Ordenar los resultados por la fecha de actualización, de forma descendente.
        $builder->orderBy('productos.updated_at', 'DESC');

        // Ejecutar la consulta y devolver el resultado como un array de objetos.
        return $builder->get()->getResult();
    }
}
