<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Categoria extends Entity
{
    protected $attributes = [
        'id' => null,
        'nombre' => null,
        'descripcion' => null,
        'estado' => 'activo', // Valor por defecto
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Método para obtener los productos asociados a esta categoría
    public function getProductos()
    {
        // Aquí deberías utilizar tu modelo ProductoModel para obtener los productos relacionados
        // Ejemplo (asumiendo que tienes un método getProductosPorCategoria en tu ProductoModel):
        $productoModel = new \App\Models\ProductoModel();
        return $productoModel->getProductosPorCategoria($this->attributes['id']);
    }
}