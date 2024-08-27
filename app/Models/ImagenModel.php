<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of FacturaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ImagenModel extends Model
{
    protected $table            = 'imagenes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'url', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $skipValidation   = false;

    /**
     * Obtener todas las imágenes asociadas a un producto específico.
     *
     * @param int $productoId ID del producto.
     * @return object[] Lista de objetos de imagen.
     */
    public function getImagenesByProductoId(int $productoId)
    {
        return $this->db->table('imagenes')
            ->select('imagenes.*')
            ->join('productos_imagenes', 'productos_imagenes.imagen_id = imagenes.id', 'left')
            ->where('productos_imagenes.producto_id', $productoId)
            ->get()
            ->getResult(); // Devuelve una colección de objetos
    }

    /**
     * Obtener todos los productos asociados a una imagen específica.
     *
     * @param int $imagenId ID de la imagen.
     * @return object[] Lista de objetos de producto.
     */
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'imagen_id');
    }

    /**
     * Obtener todos los productos junto con sus imágenes asociadas.
     *
     * @return object[] Lista de objetos de producto con información de imagen.
     */
    public function getProductosConImagenes()
    {
        return $this->db->table('productos')
            ->select('productos.*, imagenes.url AS imagen_url')
            ->join('productos_imagenes', 'productos_imagenes.producto_id = productos.id', 'left')
            ->join('imagenes', 'imagenes.id = productos_imagenes.imagen_id', 'left')
            ->get()
            ->getResult(); // Devuelve una colección de objetos
    }

    /**
     * Agregar una nueva imagen.
     *
     * @param array $data Datos de la nueva imagen.
     * @return int ID de la nueva imagen.
     */
    public function addImagen(array $data)
    {
        return $this->insert($data); // Devuelve el ID de la nueva imagen
    }

    /**
     * Actualizar una imagen existente.
     *
     * @param int $id ID de la imagen.
     * @param array $data Datos actualizados de la imagen.
     * @return bool|int Resultado de la operación de actualización.
     */
    public function updateImagen(int $id, array $data)
    {
        return $this->update($id, $data); // Devuelve true si la actualización es exitosa o false si no lo es
    }

    /**
     * Eliminar una imagen.
     *
     * @param int $id ID de la imagen.
     * @return bool Resultado de la operación de eliminación.
     */
    public function deleteImagen(int $id)
    {
        return $this->delete($id); // Devuelve true si la eliminación es exitosa o false si no lo es
    }

    /**
     * Obtener imágenes con filtros específicos.
     *
     * @param array $filters Filtros para la consulta.
     * @return object[] Lista de objetos de imagen.
     */
    public function getImagenesByFilters(array $filters)
    {
        return $this->db->table('imagenes')
            ->where($filters)
            ->get()
            ->getResult(); // Devuelve una colección de objetos
    }

    /**
     * Contar cuántas imágenes están asociadas a un producto.
     *
     * @param int $productoId ID del producto.
     * @return int Número total de imágenes asociadas.
     */
    public function countImagenesByProductoId(int $productoId)
    {
        return $this->db->table('productos_imagenes')
            ->where('producto_id', $productoId)
            ->countAllResults(); // Devuelve el número total de imágenes asociadas
    }

    /**
     * Obtiene imágenes según su estado de baja.
     *
     * @param bool $status Estado de baja a filtrar (`true` para inactivas, `false` para activas).
     * @return object[] Colección de objetos con imágenes que coinciden con el estado dado.
     */
    public function getImagenesByBajaStatus(bool $status)
    {
        return $this->where('baja', $status)
            ->findAll(); // Devuelve una colección de objetos
    }
}
