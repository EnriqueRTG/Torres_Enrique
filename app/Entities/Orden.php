<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Orden extends Entity
{
    protected $attributes = [
        'id' => null,
        'usuario_id' => null,
        'fecha' => null,
        'estado' => 'pendiente', // Valor por defecto
        'total' => null,
        'direccion_envio_id' => null,
    ];

    protected $datamap = [];
    protected $dates   = ['fecha'];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el usuario asociado a esta orden
    public function getUsuario()
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        return $usuarioModel->find($this->attributes['usuario_id']);
    }

    // Método para obtener la dirección de envío asociada a esta orden
    public function getDireccionEnvio()
    {
        $direccionModel = new \App\Models\DireccionModel();
        return $direccionModel->find($this->attributes['direccion_envio_id']);
    }

    // Método para obtener los detalles de la orden (productos)
    public function getDetalles()
    {
        $detalleOrdenModel = new \App\Models\DetalleOrdenModel();
        return $detalleOrdenModel->where('orden_id', $this->attributes['id'])
            ->findAll();
    }

    // Método para obtener la factura asociada a esta orden (si existe)
    public function getFactura()
    {
        $facturaModel = new \App\Models\FacturaModel();
        return $facturaModel->where('orden_id', $this->attributes['id'])
            ->first();
    }
}
