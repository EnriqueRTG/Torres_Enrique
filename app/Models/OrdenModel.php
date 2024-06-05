<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of OrdenModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class OrdenModel extends Model
{
    protected $table = 'ordenes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario_id', 'estado', 'baja'];
    protected $returnType = 'object';
    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
