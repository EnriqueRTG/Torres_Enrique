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

    // Obtener marcas con paginación y filtros
    public function obtenerMarcasFiltradas($estado = 'todos', $busqueda = '', $perPage = 10)
    {
        // Limpiar cualquier consulta anterior
        $this->builder()->resetQuery();

        // Si hay término de búsqueda, aplicar la búsqueda primero
        if (!empty($busqueda)) {
            $this->groupStart()
                 ->like('nombre', '%'.$busqueda.'%')
                 ->orLike('descripcion', '%'.$busqueda.'%')
                 ->groupEnd();
        }

        // Aplicar el filtro de estado después de la búsqueda
        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        // Aplicar el ordenamiento al final
        return $this->orderBy('updated_at', 'DESC')
                    ->paginate($perPage);
    }

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

        $data['estado'] = 'activo';
        return $this->update($id, $data);
    }

    // Obtener marcas segun Modificacion
    public function obtenerMarcasPorModificacion()
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
