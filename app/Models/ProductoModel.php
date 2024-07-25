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
        return $this->select('productos.*, marcas.nombre AS nombre_marca, subcategorias.nombre AS nombre_subcategoria, categorias.nombre AS nombre_categoria, imagenes.ruta AS imagen_ruta')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('subcategorias', 'subcategorias.id = productos.subcategoria_id', 'left')
            ->join('producto_imagen', 'producto_imagen.producto_id = productos.id', 'left')
            ->join('imagenes', 'imagenes.id = producto_imagen.imagen_id', 'left')
            ->groupBy('productos.id')
            ->get() // Cambiamos find() por get() para obtener todos los resultados
            ->getResult();
    }

    public function productoDetallado($id)
    {
        return $this->select('productos.*, marcas.nombre AS nombre_marca, categorias.nombre AS nombre_categoria, subcategorias.nombre AS nombre_subcategoria')
            ->join('marcas', 'marcas.id = productos.marca_id')
            ->join('subcategorias', 'subcategorias.id = productos.subcategoria_id')
            ->join('categorias', 'categorias.id = subcategorias.categoria_id') // Asumiendo que la relación es subcategoría -> categoría
            ->where('productos.id', $id)
            ->first();
    }

    public function getImagenById($id)
    {
        return $this->select("i.*")
            ->join('producto_imagen as pi', 'pi.producto_id = productos.id')
            ->join('imagenes as i', 'i.id = pi.imagen_id')
            ->where('productos.id', $id)
            ->findAll();
    }
}
