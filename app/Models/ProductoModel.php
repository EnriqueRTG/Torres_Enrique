<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of ProductoModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ProductoModel extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombre', 'descripcion', 'precio', 'stock', 'marca_id', 'modelo', 'peso', 'dimensiones', 'material', 'color', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps = false;
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = 'fecha_actualizacion';
    protected $skipValidation   = false;

    /**
     * Obtiene todos los productos, incluyendo su marca asociada, la primera imagen y todas las categorías.
     *
     * Esta función realiza una consulta a la base de datos para obtener todos los productos,
     * junto con el nombre de la marca correspondiente, la URL de la primera imagen asociada
     * y todas las categorías a las que pertenece.
     *
     * @return array Un array de objetos, donde cada objeto representa un producto y contiene
     *              las siguientes propiedades:
     *              - id: Identificador único del producto.
     *              - nombre: Nombre del producto.
     *              - marca_id: Identificador de la marca asociada.
     *              - nombre_marca: Nombre de la marca asociada.
     *              - imagen_url: URL de la primera imagen asociada.
     *              - categorias: Un array con los nombres de todas las categorías a las que pertenece.
     *              - ... (otras propiedades de la tabla productos)
     */
    public function obtenerTodosLosProductos()
    {
        return $this->select('productos.*, marcas.nombre AS nombre_marca, imagenes.url AS imagen_url, categorias.nombre AS categoria')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->join('productos_imagenes', 'productos_imagenes.producto_id = productos.id')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id')
            ->join('productos_categorias', 'productos_categorias.producto_id = productos.id')
            ->join('categorias', 'categorias.id = productos_categorias.categoria_id')
            ->groupBy('productos.id')
            ->get()
            ->getResult();
    }

    /**
     * Obtiene todos los productos activos (no dados de baja), incluyendo sus detalles.
     *
     * Esta función realiza una consulta a la base de datos para obtener todos los productos
     * que no están marcados como 'baja', junto con sus marcas asociadas, imágenes y categorías.
     * La cláusula `groupBy('productos.id')` se utiliza para evitar duplicados de productos
     * en caso de que un producto tenga múltiples imágenes o categorías.
     *
     * @return array Un array de objetos, donde cada objeto representa un producto activo y contiene
     *              las siguientes propiedades:
     *              - id: Identificador único del producto.
     *              - nombre: Nombre del producto.
     *              - marca_id: Identificador de la marca asociada.
     *              - nombre_marca: Nombre de la marca asociada.
     *              - imagen_url: URL de la primera imagen asociada.
     *              - categorias: Un array con los nombres de todas las categorías a las que pertenece.
     *              - ... (otras propiedades de la tabla productos)
     */
    public function obtenerProductosActivos($builder = null, $perPage = null, $offset = null)
    {
        if ($builder === null) {
            $builder = $this->builder();
        }

        $builder->select('productos.*, marcas.nombre AS nombre_marca, imagenes.url AS imagen_url, GROUP_CONCAT(categorias.nombre) AS categorias')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->join('productos_imagenes', 'productos_imagenes.producto_id = productos.id', 'left')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id', 'left')
            ->join('productos_categorias', 'productos_categorias.producto_id = productos.id')
            ->join('categorias', 'categorias.id = productos_categorias.categoria_id')
            ->where('productos.baja', 0)
            ->groupBy('productos.id');

        if ($perPage !== null && $offset !== null) {
            $builder->limit($perPage, $offset);
        }

        return $builder->get()->getResult(); // Eliminamos la segunda aplicación de limit y offset
    }

    /**
     * Obtiene un producto específico por su ID, junto con sus detalles asociados.
     *
     * Esta función realiza una consulta a la base de datos para obtener un producto
     * específico, incluyendo su marca, imágenes y categorías asociadas. Utiliza varias
     * uniones para relacionar las tablas de productos, marcas, imágenes y categorías.
     *
     * @param int $id El ID del producto a buscar.
     * @return object|null Un objeto que representa el producto, o null si no se encuentra.
     */
    public function obtenerProductoPorId($id)
    {
        return $this->select('productos.*, marcas.nombre AS nombre_marca, categorias.nombre AS categoria, imagenes.url AS imagen_url')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->join('productos_categorias', 'productos_categorias.producto_id = productos.id')
            ->join('categorias', 'categorias.id = productos_categorias.categoria_id')
            ->join('productos_imagenes', 'productos_imagenes.producto_id = productos.id')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id')
            ->where('productos.id', $id)
            ->groupBy('productos.id') // Agrupar por producto para evitar duplicados
            ->first();
    }

    public function obtenerImagenesProducto($id)
    {
        $builder = $this->db->table('productos_imagenes');
        return $builder->select('imagenes.url')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id')
            ->where('productos_imagenes.producto_id', $id)
            ->get()
            ->getResultObject(Imagen::class);
    }

    public function obtenerCategorias($productoId)
    {
        $builder = $this->db->table('productos_categorias');
        $builder->select('categorias.*');
        $builder->join('categorias', 'categorias.id = productos_categorias.categoria_id');
        $builder->where('productos_categorias.producto_id', $productoId);
        return $builder->get()->getResultObject('Categoria');
    }

    public function actualizarStock($productoId, $nuevaCantidad)
    {
        // Validar que el producto exista
        $producto = $this->find($productoId);
        if (!$producto) {
            return false; // O lanzar una excepción si prefieres
        }
        // Validar que la nueva cantidad sea válida (puedes agregar más validaciones según tus necesidades)
        if (!is_numeric($nuevaCantidad) || $nuevaCantidad < 0) {
            return false; // O lanzar una excepción
        }
        // Actualizar el stock en la base de datos
        $this->update($productoId, ['stock' => $nuevaCantidad]);
        return true;
    }
}
