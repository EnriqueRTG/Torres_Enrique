<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of UsuarioModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class UsuarioModel extends Model {

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'password', 'direccion', 'telefono', 'fecha_alta', 'fecha_actualizacion', 'baja'];
    protected $returnType = 'object';

    function password_hash($passwordPlana) {
        return $this->password_hash($passwordPlana, PASSWORD_DEFAULT);
    }

    function passwordVerificar($passwordPlana, $passwordHash) {
        return password_verify($passwordPlana, $passwordHash);
    }
}
