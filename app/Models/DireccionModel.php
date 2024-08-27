<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table            = 'direcciones';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'nombre_destinatario', 'calle', 'numero', 'piso', 'departamento', 'ciudad', 'provincia', 'codigo_postal', 'telefono'];
    protected $returnType       = 'object';
    protected $useTimestamps = false; // No necesitamos timestamps en este modelo

    // Validación de datos (opcional)
    protected $validationRules    = [
        'usuario_id'         => 'required|integer',
        'nombre_destinatario' => 'required|min_length[3]|max_length[255]',
        'calle'              => 'required|max_length[255]',
        'numero'             => 'required|max_length[10]',
        'piso'               => 'permit_empty|max_length[10]',
        'departamento'       => 'permit_empty|max_length[10]',
        'ciudad'             => 'required|max_length[255]',
        'provincia'          => 'required|max_length[255]',
        'codigo_postal'      => 'required|max_length[50]',
        'telefono'           => 'required|max_length[50]',
    ];
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
        ],
        'nombre_destinatario' => [
            'required' => 'El nombre del destinatario es obligatorio.',
            'min_length' => 'El nombre del destinatario debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del destinatario no puede superar los 255 caracteres.',
        ],
        'calle' => [
            'required' => 'La calle es obligatoria.',
            'max_length' => 'La calle no puede superar los 255 caracteres.',
        ],
        'numero' => [
            'required' => 'El número es obligatorio.',
            'max_length' => 'El número no puede superar los 10 caracteres.',
        ],
        'piso' => [
            'max_length' => 'El piso no puede superar los 10 caracteres.',
        ],
        'departamento' => [
            'max_length' => 'El departamento no puede superar los 10 caracteres.',
        ],
        'ciudad' => [
            'required' => 'La ciudad es obligatoria.',
            'max_length' => 'La ciudad no puede superar los 255 caracteres.',
        ],
        'provincia' => [
            'required' => 'La provincia es obligatoria.',
            'max_length' => 'La provincia no puede superar los 255 caracteres.',
        ],
        'codigo_postal' => [
            'required' => 'El código postal es obligatorio.',
            'max_length' => 'El código postal no puede superar los 50 caracteres.',
        ],
        'telefono' => [
            'required' => 'El teléfono es obligatorio.',
            'max_length' => 'El teléfono no puede superar los 50 caracteres.',
        ],
    ];
}
