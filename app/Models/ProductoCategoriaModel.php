<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoCategoriaModel extends Model
{
    protected $table            = 'productos_categorias';
    protected $primaryKey       = ['producto_id', 'categoria_id']; // Clave primaria compuesta
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['producto_id', 'categoria_id'];
    protected $useTimestamps    = false;
    
    /**
     * Obtiene todas las categorías asociadas a un producto específico.
     *
     * @param int $productoId ID del producto
     * @return array Array de objetos con las categorías asociadas
     */
    public function getCategoriasByProducto(int $productoId)
    {
        return $this->select('categorias.*')
                    ->join('categorias', 'categorias.id = productos_categorias.categoria_id')
                    ->where('productos_categorias.producto_id', $productoId)
                    ->findAll();
    }

    /**
     * Obtiene todos los productos asociados a una categoría específica.
     *
     * @param int $categoriaId ID de la categoría
     * @return array Array de objetos con los productos asociados
     */
    public function getProductosByCategoria(int $categoriaId)
    {
        return $this->select('productos.*')
                    ->join('productos', 'productos.id = productos_categorias.producto_id')
                    ->where('productos_categorias.categoria_id', $categoriaId)
                    ->findAll();
    }

    /**
     * Agrega una asociación entre un producto y una categoría.
     *
     * @param int $productoId ID del producto
     * @param int $categoriaId ID de la categoría
     * @return bool Resultado de la operación
     */
    public function addAssociation(int $productoId, int $categoriaId): bool
    {
        return $this->insert([
            'producto_id' => $productoId,
            'categoria_id' => $categoriaId
        ]);
    }

    /**
     * Elimina una asociación entre un producto y una categoría.
     *
     * @param int $productoId ID del producto
     * @param int $categoriaId ID de la categoría
     * @return bool Resultado de la operación
     */
    public function deleteAssociation(int $productoId, int $categoriaId): bool
    {
        return $this->where([
            'producto_id' => $productoId,
            'categoria_id' => $categoriaId
        ])->delete();
    }

    /**
     * Verifica si existe una asociación entre un producto y una categoría.
     *
     * @param int $productoId ID del producto
     * @param int $categoriaId ID de la categoría
     * @return bool Resultado de la verificación
     */
    public function associationExists(int $productoId, int $categoriaId): bool
    {
        return $this->where([
            'producto_id' => $productoId,
            'categoria_id' => $categoriaId
        ])->countAllResults() > 0;
    }
}
