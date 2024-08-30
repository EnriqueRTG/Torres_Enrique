<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DetalleOrden extends Entity
{
    protected $attributes = [
        'id' => null,
        'orden_id' => null,
        'producto_id' => null,
        'cantidad' => null,
        'precio_unitario' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener la orden asociada a este detalle
    public function getOrden()
    {
        $ordenModel = new \App\Models\OrdenModel();
        return $ordenModel->find($this->attributes['orden_id']);
    }

    // Método para obtener el producto asociado a este detalle
    public function getProducto()
    {
        $productoModel = new \App\Models\ProductoModel();
        return $productoModel->find($this->attributes['producto_id']);
    }

    // Método para calcular el subtotal de este detalle
    public function getSubtotal()
    {
        return $this->attributes['cantidad'] * $this->attributes['precio_unitario'];
    }
}
