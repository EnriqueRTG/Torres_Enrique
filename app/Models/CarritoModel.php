<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table            = 'carritos';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['id_usuario', 'id_producto', 'cantidad'];
    protected $returnType       = 'objet';

    // Dates
    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function obtenerCarrito($idUsuario)
    {
        $builder = $this->db->table($this->table); // Accede al builder de consultas

        // Realiza un JOIN con la tabla de productos para obtener sus detalles
        $builder->select('carritos.*, productos.nombre, productos.precio');
        $builder->join('productos', 'productos.id = carritos.id_producto');

        // Filtra por el id_usuario
        $builder->where('carritos.id_usuario', $idUsuario);

        // Obtiene los resultados y los devuelve como un array
        $query = $builder->get();
        return $query->getResultArray();
    }
}
