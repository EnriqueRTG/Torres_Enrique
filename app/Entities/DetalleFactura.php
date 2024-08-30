<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class DetalleFactura extends Entity
{
    protected $attributes = [
        'id' => null,
        'factura_id' => null,
        'producto_id' => null,
        'cantidad' => null,
        'precio_unitario' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener la factura asociada a este detalle
    public function getFactura()
    {
        $facturaModel = new \App\Models\FacturaModel();
        return $facturaModel->find($this->attributes['factura_id']);
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
