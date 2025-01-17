<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of MarcaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class MarcaModel extends Model
{
    protected $table            = 'marcas';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion','estado'];
    protected $returnType       = 'object'; 
    protected $useTimestamps = false; 

    // Validación de datos (opcional)
    protected $validationRules    = [
        'nombre'      => 'required|min_length[3]|max_length[255]|is_unique[marcas.nombre]',
        'descripcion' => 'permit_empty',
        'estado'      => 'required|in_list[activo,inactivo]',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre de la marca es obligatorio.',
            'min_length' => 'El nombre de la marca debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre de la marca no puede superar los 255 caracteres.',
            'is_unique' => 'Ya existe una marca con ese nombre.',
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list' => 'El estado debe ser "activo" o "inactivo".'
        ],
    ];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'marca_id'); 
    }
}
