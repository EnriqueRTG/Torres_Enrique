<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Contacto extends Entity
{
    protected $attributes = [
        'id' => null,
        'nombre' => null,
        'email' => null,
        'asunto' => null,
        'mensaje' => null,
        'fecha' => null,
        'leido' => false, // Valor por defecto
    ];

    protected $datamap = [];
    protected $dates   = ['fecha'];
    protected $casts   = [];
}