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
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'password', 'telefono', 'rol_id', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $validationRules  = 'usuarios'; // Referencia a las reglas en Validation.php
    protected $skipValidation   = false;

    /**
     * Hash a plain text password.
     *
     * @param string $passwordPlana
     * @return string
     */
    public function passwordHash($passwordPlana)
    {
        return password_hash($passwordPlana, PASSWORD_DEFAULT);
    }

    /**
     * Verify a plain text password against a hashed password.
     *
     * @param string $passwordPlana
     * @param string $passwordHash
     * @return bool
     */
    public function passwordVerificar($passwordPlana, $passwordHash)
    {
        return password_verify($passwordPlana, $passwordHash);
    }

    /**
     * Obtiene todos los clientes, incluyendo los dados de baja.
     *
     * @return array Un array de objetos que representan a los clientes.
     */
    public function obtenerTodosLosClientes()
    {
        return $this->select('usuarios.*, GROUP_CONCAT(CONCAT(direcciones.calle, " ", direcciones.numero, IFNULL(CONCAT(", ", direcciones.piso), ""), IFNULL(CONCAT(", Dpto. ", direcciones.departamento), ""))) as direcciones')
            ->join('usuarios_direcciones', 'usuarios_direcciones.usuario_id = usuarios.id', 'left')
            ->join('direcciones', 'direcciones.id = usuarios_direcciones.direccion_id', 'left')
            ->where('usuarios.rol_id', 2) // Asumiendo que el rol_id 2 es para clientes
            ->groupBy('usuarios.id')
            ->findAll();
    }

    /**
     * Obtiene todos los clientes activos (no dados de baja).
     *
     * @return array Un array de objetos que representan a los clientes activos.
     */
    public function obtenerClientesActivos()
    {
        return $this->select('usuarios.*, GROUP_CONCAT(direcciones.direccion) as direcciones')
            ->join('clientes_direcciones', 'clientes_direcciones.cliente_id = usuarios.id', 'left')
            ->join('direcciones', 'direcciones.id = clientes_direcciones.direccion_id', 'left')
            ->where('usuarios.rol_id', 2)
            ->where('usuarios.baja', 0)
            ->groupBy('usuarios.id')
            ->findAll();
    }

    /**
     * Obtiene las órdenes de compra de un cliente específico.
     *
     * @param int $clienteId El ID del cliente.
     * @return array Un array de objetos que representan las órdenes de compra del cliente.
     */
    public function obtenerOrdenesCompraPorCliente($clienteId)
    {
        return $this->db->table('detalles_orden')
            ->where('cliente_id', $clienteId)
            ->get()
            ->getResult();
    }
}
