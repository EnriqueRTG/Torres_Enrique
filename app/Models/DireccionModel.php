<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table            = 'direcciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['calle', 'numero', 'piso', 'departamento', 'ciudad', 'provincia', 'codigo_postal', 'pais', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';

    // Obtiene todas las direcciones
    public function getAllDirecciones()
    {
        return $this->findAll(); // Devuelve una colección de objetos
    }

    // Obtiene una dirección por ID
    public function getDireccionById(int $id)
    {
        return $this->find($id); // Devuelve un objeto
    }

    // Obtiene todas las direcciones con un estado de baja específico
    public function getDireccionesByBajaStatus(bool $status)
    {
        return $this->where('baja', $status)->findAll(); // Devuelve una colección de objetos
    }

    // Agrega una nueva dirección
    public function addDireccion(array $data)
    {
        return $this->insert($data);
    }

    // Actualiza una dirección existente
    public function updateDireccion(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    // Elimina una dirección por ID
    public function deleteDireccion(int $id)
    {
        return $this->delete($id);
    }

    // Relaciona una dirección con usuarios a través de la tabla intermedia
    public function getUsuariosByDireccionId(int $direccionId)
    {
        return $this->db->table('usuarios_direcciones')
            ->select('usuarios.*')
            ->join('usuarios', 'usuarios.id = usuarios_direcciones.usuario_id')
            ->where('usuarios_direcciones.direccion_id', $direccionId)
            ->get()
            ->getResult(); // Devuelve una colección de objetos
    }
}
