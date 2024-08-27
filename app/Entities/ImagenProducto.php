<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ImagenProducto extends Entity
{
    protected $attributes = [
        'id' => null,
        'producto_id' => null,
        'ruta_imagen' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el producto asociado a esta imagen
    public function getProducto()
    {
        $productoModel = new \App\Models\ProductoModel();
        return $productoModel->find($this->attributes['producto_id']);
    }
}
