<?php

namespace App\Models;

use CodeIgniter\Model;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CategoriaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion', 'estado'];
    protected $returnType       = 'object'; // Devolver objetos por defecto
    protected $useTimestamps = false; // No necesitamos timestamps en este modelo

    // Validación de datos (opcional)
    protected $validationRules    = [
        'nombre'      => 'required|min_length[3]|max_length[255]|is_unique[categorias.nombre]',
        'descripcion' => 'permit_empty',
        'estado'      => 'required|in_list[activo,inactivo]',
    ];
    
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre de la categoría es obligatorio.',
            'min_length' => 'El nombre de la categoría debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre de la categoría no puede superar los 255 caracteres.',
            'is_unique' => 'Ya existe una categoría con ese nombre.',
        ],
        'estado' => [
            'required' => 'El estado de la categoría es obligatorio.',
            'in_list' => 'El estado de la categoría debe ser "activo" o "inactivo".',
        ],
    ];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'categoria_id');
    }
}
