<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;
use CodeIgniter\Model;
/**
 * Description of FacturaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class FacturaModel extends Model{
    protected $table            = 'facturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['orden_id', 'total', 'fecha_emision', 'identificador_cliente', 'nombre_empresa', 'direccion_empresa', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $skipValidation   = false;
}
