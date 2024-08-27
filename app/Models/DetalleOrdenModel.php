<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of DetalleModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class DetalleOrdenModel extends Model
{
    protected $table            = 'detalles_orden';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['orden_id', 'producto_id', 'cantidad', 'precio', 'total', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';

    public function getDetalles($ordenId)
    {
        return $this->select('detalles_orden.*, productos.nombre AS nombre_producto')
            ->join('productos', 'productos.id = detalles_orden.producto_id')
            ->where('detalles_orden.orden_id', $ordenId)
            ->findAll();
    }
}
