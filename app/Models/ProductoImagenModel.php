<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoImagenModel extends Model
{
    protected $table            = 'productos_imagenes';
    protected $primaryKey       = ['producto_id', 'imagen_id']; // Clave primaria compuesta
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['producto_id', 'imagen_id', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';

    /**
     * Obtiene todas las imágenes asociadas a un producto.
     *
     * @param int $productoId ID del producto.
     * @return object[] Colección de objetos con las imágenes asociadas.
     */
    public function getImagenesByProductoId(int $productoId)
    {
        return $this->select('imagenes.*')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id')
            ->where('productos_imagenes.producto_id', $productoId)
            ->findAll();
    }

    /**
     * Obtiene todos los productos asociados a una imagen.
     *
     * @param int $imagenId ID de la imagen.
     * @return object[] Colección de objetos con los productos asociados.
     */
    public function getProductosByImagenId(int $imagenId)
    {
        return $this->select('productos.*')
            ->join('productos', 'productos.id = productos_imagenes.producto_id')
            ->where('productos_imagenes.imagen_id', $imagenId)
            ->findAll();
    }

    /**
     * Agrega una imagen a un producto.
     *
     * @param int $productoId ID del producto.
     * @param int $imagenId ID de la imagen.
     * @return bool Resultado de la operación.
     */
    public function addImagenToProducto(int $productoId, int $imagenId)
    {
        return $this->insert([
            'producto_id' => $productoId,
            'imagen_id' => $imagenId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Elimina una imagen de un producto.
     *
     * @param int $productoId ID del producto.
     * @param int $imagenId ID de la imagen.
     * @return bool Resultado de la operación.
     */
    public function removeImagenFromProducto(int $productoId, int $imagenId)
    {
        return $this->where('producto_id', $productoId)
            ->where('imagen_id', $imagenId)
            ->delete();
    }
}
