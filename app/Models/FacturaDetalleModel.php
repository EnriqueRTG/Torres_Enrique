<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;
use CodeIgniter\Model;
/**
 * Description of FacturaDetalleModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class FacturaDetalleModel extends Model {
    protected $table            = 'facturas_detalles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id', 'factura_id', 'producto_id', 'cantidad', 'precio'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $skipValidation   = false;

    public function getDetalles($idParam = null, $id = null){
        $db = \Config\Database::connect();

        $buldier = $db->table('facturas_detalles');
        $buldier->select('*');
        $buldier->join('facturas', 'facturas.id = facturas_detalles.factura.id');
        $buldier->join('productos', 'productos.id = facturas_detalles.producto_id');
        $buldier->join('usuarios', 'usuarios.id = facturas.identificador_cliente');

        if($id != null){
            $buldier->where('facturas.id', $idParam);
        }

        $query = $buldier->get();
        return $query->getResultArray();
    }

}
