<?php

namespace App\Models;

use CodeIgniter\Model;

/** LISTO
 * Modelo para la gestión de imágenes de productos.
 *
 * Este modelo administra las operaciones CRUD para la tabla "imagenes_productos", que almacena
 * las imágenes asociadas a los productos. Además, incluye reglas de validación para garantizar la 
 * integridad de los datos y un método personalizado para obtener las imágenes asociadas a un producto.
 *
 * @package App\Models
 */
class ImagenProductoModel extends Model
{
    // Configuración básica del modelo
    protected $table            = 'imagenes_productos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'producto_id', 'ruta_imagen'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;       // Habilitar marcas de tiempo (created_at y updated_at)
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    /**
     * Reglas de validación para los campos de la imagen del producto.
     *
     * Estas reglas se aplican antes de insertar o actualizar registros en la base de datos.
     *
     * @var array
     */
    protected $validationRules = [
        'nombre'       => 'required|max_length[255]',
        'producto_id'  => 'required|integer',
        'ruta_imagen'  => 'required|max_length[255]',
    ];

    /**
     * Mensajes personalizados para las reglas de validación.
     *
     * @var array
     */
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la imagen es obligatorio.',
            'max_length' => 'El nombre de la imagen no puede superar los 255 caracteres.',
        ],
        'producto_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'integer'  => 'El ID del producto debe ser un número entero.',
        ],
        'ruta_imagen' => [
            'required'   => 'La ruta de la imagen es obligatoria.',
            'max_length' => 'La ruta de la imagen no puede superar los 255 caracteres.',
        ],
    ];

    /**
     * Obtiene todas las imágenes asociadas a un producto específico.
     *
     * @param int $productoId ID del producto.
     * @return array Lista de imágenes (objetos) asociadas al producto.
     */
    public function getImagenesPorProducto(int $productoId): array
    {
        return $this->where('producto_id', $productoId)->findAll();
    }

    /**
     * Método ilustrativo para establecer una relación con el producto.
     *
     * Nota: CodeIgniter 4 no implementa relaciones de forma automática como otros ORM, 
     * por lo que este método es solo un ejemplo de cómo podrías recuperar el producto 
     * asociado manualmente.
     *
     * @return object|null Objeto del producto asociado o null si no se encuentra.
     */
    public function producto()
    {
        // Ejemplo: retorna el producto asociado a esta imagen.
        // Se asume que el producto tiene un modelo "ProductoModel" correctamente configurado.
        return (new \App\Models\ProductoModel())->find($this->producto_id);
    }
}
