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
class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'precio', 'stock', 'marca_id', 'subcategoria_id', 'presentacion', 'baja'];
    protected $returnType = 'object';

    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function productosDetallados()
    {
        return $this->select('productos.*, marcas.nombre as marca, subcategorias.nombre as subcategoria, categorias.nombre as categoria')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->join('subcategorias', 'subcategorias.id = productos.subcategoria_id')
            ->join('categorias', 'categorias.id = subcategorias.categoria_id')
            ->find();
    }

    public function productoDetallado($id)
    {
        return $this->select('productos.*, marcas.nombre AS marca, subcategorias.nombre AS subcategoria, categorias.nombre AS categoria')
            ->join('marcas AS m', 'm.id = productos.marca_id')
            ->join('subcategorias AS sc', 'sc.id = productos.subcategoria_id')
            ->join('categorias AS c', 'c.id = sc.categoria_id')
            ->where('productos.id', $id)
            ->first();
    }

    public function getImagenById($id)
    {
        return $this->select("i.*")
            ->join('producto_imagen as pi', 'pi.producto_id = productos.id')
            ->join('imagenes as i', 'i.id = pi.imagen_id')
            ->where('productos.id', $id)
            ->find();
    }
}
