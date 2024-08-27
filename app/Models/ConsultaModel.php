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
    protected $table      = 'consultas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['usuario_id', 'asunto', 'mensaje', 'leido', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $validationRules    = 'consultas';  // Referencia a la configuración en Validation.php
    protected $skipValidation     = false;
}
