<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DetalleCarrito extends Entity
{
    protected $attributes = [
        'id' => null,
        'carrito_id' => null,
        'producto_id' => null,
        'cantidad' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el carrito asociado a este detalle
    public function getCarrito()
    {
        $carritoModel = new \App\Models\CarritoModel();
        return $carritoModel->find($this->attributes['carrito_id']);
    }

    // Método para obtener el producto asociado a este detalle
    public function getProducto()
    {
        $productoModel = new \App\Models\ProductoModel();
        return $productoModel->find($this->attributes['producto_id']);
    }
}
