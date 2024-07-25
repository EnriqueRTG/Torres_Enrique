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
class UsuarioModel extends Model
{

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'password', 'direccion', 'telefono', 'baja'];
    protected $returnType = 'object';
    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function passwordHash($passwordPlana)
    {
        return password_hash($passwordPlana, PASSWORD_DEFAULT);
    }

    public function passwordVerificar($passwordPlana, $passwordHash)
    {
        return password_verify($passwordPlana, $passwordHash);
    }

    public function clientes()
    {
        return $this->select('usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.direccion, usuarios.telefono, usuarios.baja, usuarios.created_at, usuarios.updated_at')
            ->where('usuarios.rol_id', 2)
            ->find();
    }

    public function getOrdenesById($id)
    {
        return $this->select('o.*')
            ->join('ordenes as o', 'o.usuario_id = usuarios.id')
            ->where('usuarios.id', $id)
            ->find();
    }
}
