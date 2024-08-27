<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Marca extends Entity
{
    protected $attributes = [
        'id' => null,
        'nombre' => null,
        'logo' => null,
        'descripcion' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Método para obtener los productos asociados a esta marca
    public function getProductos()
    {
        // Aquí deberías utilizar tu modelo ProductoModel para obtener los productos relacionados
        // Ejemplo (asumiendo que tienes un método getProductosPorMarca en tu ProductoModel):
        $productoModel = new \App\Models\ProductoModel();
        return $productoModel->getProductosPorMarca($this->attributes['id']);
    }
}