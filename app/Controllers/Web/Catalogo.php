<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\SubcategoriaModel;
use App\Models\MarcaModel;

/**
 * Description of Comercializacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Catalogo extends BaseController
{

    public function index()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        $subcategoriaModel = new SubcategoriaModel();
        $marcasModel = new MarcaModel();

        $filtro = $this->request->getGet();

        $builder = $productoModel->select('productos.*, marcas.nombre AS nombre_marca, categorias.nombre AS nombre_categoria, subcategorias.nombre AS nombre_subcategoria, imagenes.ruta AS imagen_ruta')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('subcategorias', 'subcategorias.id = productos.subcategoria_id', 'left')
            ->join('categorias', 'categorias.id = subcategorias.categoria_id', 'left')
            ->join('producto_imagen', 'producto_imagen.producto_id = productos.id', 'left')
            ->join('imagenes', 'imagenes.id = producto_imagen.imagen_id', 'left')
            ->groupBy('productos.id');

        // Aplicar filtros
        if (!empty($filtro['categoria'])) {
            $builder->where('categorias.id', $filtro['categoria']);
        }

        if (!empty($filtro['subcategoria'])) {
            $builder->where('subcategorias.id', $filtro['subcategoria']);
        }

        if (!empty($filtro['marca'])) {
            $builder->where('marcas.id', $filtro['marca']);
        }

        if (!empty($filtro['orden'])) {
            if ($filtro['orden'] == 'precio_asc') {
                $builder->orderBy('productos.precio', 'ASC');
            } elseif ($filtro['orden'] == 'precio_desc') {
                $builder->orderBy('productos.precio', 'DESC');
            } elseif ($filtro['orden'] == 'novedades') {
                $builder->orderBy('productos.created_at', 'DESC'); // Asegúrate de que el nombre del campo sea correcto
            }
        } else {
            // Ordenar por defecto por fecha de creación descendente
            $builder->orderBy('productos.created_at', 'DESC'); 
        }

        // Obtener los productos después de aplicar los filtros
        $productos = $builder->get()->getResult();

        $data = [
            'titulo' => 'Catalogo',
            'productos' => $productos,
            'categorias' => $categoriaModel->find(),
            'subcategorias' => $subcategoriaModel->find(),
            'marcas' => $marcasModel->find(),
            'filtro' => $filtro,
        ];

        return view('layouts/header', $data)
            . view('web/catalogo', $data)
            . view('layouts/footer');
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto' => $productoModel->productoDetallado($id),
            'imagenes' => $productoModel->getImagenById($id),
            'titulo' => $productoModel->find($id)->nombre,
        ];

        return view('layouts/header', $data) . view('web/producto', $data) . view('layouts/footer');
    }
}
