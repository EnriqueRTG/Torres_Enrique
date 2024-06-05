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
    protected $allowedFields = ['usuario_id', 'asunto', 'mensaje', 'leido', 'baja'];
    protected $returnType = 'object';

    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
