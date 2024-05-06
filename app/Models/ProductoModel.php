<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;
use CodeIgniter\Model;

/**
 * Description of ProductoModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ProductoModel extends Model{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo_SKU', 'nombre', 'descripcion', 'precio', 'stock', 'marca_id', 'subcategoria_id', 'presentacion', 'fecha_alta', 'fecha_actualizacion', 'imagen', 'baja'];
    protected $returnType = 'object';

    public function traerDetalleProductoCompleto($id) {
        return $this->select('productos.*, marcas.nombre AS marca, subcategorias.nombre AS subcategoria, categorias.nombre AS categoria')
                    ->join('marcas', 'marcas.id = productos.marca_id')
                    ->join('subcategorias', 'subcategorias.id = productos.subcategoria_id')
                    ->join('categorias', 'categorias.id = subcategorias.categoria_id')
                    ->where('productos.id', $id)
                    ->first();
    }
    
}

