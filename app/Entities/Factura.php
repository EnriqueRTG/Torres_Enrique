<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Factura extends Entity
{
    protected $attributes = [
        'id' => null,
        'orden_id' => null,
        'fecha_emision' => null,
        'numero_factura' => null,
        'total' => null,
    ];

    protected $datamap = [];
    protected $dates   = ['fecha_emision'];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener la orden asociada a esta factura
    public function getOrden()
    {
        $ordenModel = new \App\Models\OrdenModel();
        return $ordenModel->find($this->attributes['orden_id']);
    }

    // Método para obtener los detalles de la factura
    public function getDetalles()
    {
        $detalleFacturaModel = new \App\Models\DetalleFacturaModel();
        return $detalleFacturaModel->where('factura_id', $this->attributes['id'])
            ->findAll();
    }
}
