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
    protected $allowedFields    = ['nombre', 'descripcion', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    // Validación de datos
    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[255]',
        'descripcion' => 'permit_empty', // La descripción es opcional
        'estado' => 'in_list[activo,inactivo]', // Estado como ENUM
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre de la marca es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede tener más de 255 caracteres.',
        ],
        'estado' => [
            'in_list' => 'El estado debe ser "activo" o "inactivo".',
        ],
    ];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'marca_id');
    }

    // Crear Marca
    public function crearMarca($data)
    {
        $data['estado'] = 'activo'; // Asignar estado 'activo' por defecto

        if (!$this->validate($data)) {
            return false;
        }

        return $this->save($data);
    }

    // Actualizar datos de la marca
    public function actualizarMarca($id, $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        return $this->update($id, $data);
    }

    // Obtener marcas segun Modificacion
    public function obtenerMarcasPorModifiacion()
    {
        return $this->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    // Obtener marcas inactivas y por modificacion mas reciente
    public function obtenerMarcasInactivasOrdenadasPorModificacion()
    {
        return $this->where('estado', 'inactivo')
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }
}
