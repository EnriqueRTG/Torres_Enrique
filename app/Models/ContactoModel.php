<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of ContactoModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ContactoModel extends Model
{
    protected $table            = 'contactos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'email', 'asunto', 'mensaje', 'leido'];
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha';
    protected $updatedField  = null;

    // Validación de datos (opcional)
    protected $validationRules    = [
        'nombre'      => 'required|min_length[3]|max_length[255]',
        'email'       => 'required|valid_email',
        'asunto'      => 'required|max_length[255]',
        'mensaje'     => 'required',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 255 caracteres.',
        ],
        'email' => [
            'required' => 'El email es obligatorio.',
            'valid_email' => 'El email debe ser válido.',
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
