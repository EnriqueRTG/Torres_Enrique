<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of ConsultaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ConsultaModel extends Model
{
    protected $table            = 'consultas';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'asunto', 'mensaje', 'leido'];
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha';
    protected $updatedField  = null;

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'usuario_id' => 'required|integer',
        'asunto'     => 'required|max_length[255]',
        'mensaje'    => 'required',
    ];
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
        ],
        'asunto' => [
            'required' => 'El asunto es obligatorio.',
            'max_length' => 'El asunto no puede superar los 255 caracteres.',
        ],
        'mensaje' => [
            'required' => 'El mensaje es obligatorio.',
        ],
    ];
}
