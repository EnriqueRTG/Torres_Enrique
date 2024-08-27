<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Consulta extends Entity
{
    protected $attributes = [
        'id' => null,
        'usuario_id' => null,
        'asunto' => null,
        'mensaje' => null,
        'leido' => false, 
        'fecha' => null,
    ];

    protected $datamap = [];
    protected $dates   = ['fecha'];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el usuario asociado a esta consulta
    public function getUsuario()
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        return $usuarioModel->find($this->attributes['usuario_id']); 
    }
}