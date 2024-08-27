<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

/**
 * Description of Comercializacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Catalogo extends BaseController
{
    
    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $session = session();
        $cart = \Config\Services::cart();
        $cart->contents();
    }

    public function index()
    {

        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        $filtro = $this->request->getGet();
        $session = session();

        if ($this->request->getGet('limpiar_filtros')) {
            // Limpiar la sesión de filtros
            $session = session();
            $session->remove('filtro_categoria');
            $session->remove('filtro_precio_min');
            $session->remove('filtro_precio_max');
            $session->remove('filtro_orden');

            // Redirigir sin filtros (usando route_to para generar la URL correcta)
            return redirect()->to(route_to('web.catalogo'));
        }

        // Construir la consulta utilizando el Query Builder
        $builder = $productoModel->builder(); // Usar el builder del modelo para aprovechar las relaciones

        // Aplicar filtros (leer de la sesión si existen)
        if (!empty($filtro['categoria'])) {
            $builder->whereIn('productos_categorias.categoria_id', $filtro['categoria']);
            $session->set('filtro_categoria', $filtro['categoria']);
        } elseif ($session->has('filtro_categoria')) {
            $filtro['categoria'] = $session->get('filtro_categoria');
            $builder->whereIn('productos_categorias.categoria_id', $filtro['categoria']);
        }

        if (!empty($filtro['precio_min'])) {
            $builder->where('productos.precio >=', $filtro['precio_min']);
            $session->set('filtro_precio_min', $filtro['precio_min']);
        } elseif ($session->has('filtro_precio_min')) {
            $builder->where('productos.precio >=', $session->get('filtro_precio_min'));
        }

        if (!empty($filtro['precio_max'])) {
            $builder->where('productos.precio <=', $filtro['precio_max']);
            $session->set('filtro_precio_max', $filtro['precio_max']);
        } elseif ($session->has('filtro_precio_max')) {
            $builder->where('productos.precio <=', $session->get('filtro_precio_max'));
        }

        // Ordenar por
        if (!empty($filtro['orden'])) {
            $session->set('filtro_orden', $filtro['orden']); // Guardar el orden en la sesión
        } else {
            // Si no hay filtro de orden en la petición, verificar si existe en la sesión
            if ($session->has('filtro_orden')) {
                $filtro['orden'] = $session->get('filtro_orden'); // Leer el orden de la sesión
            } else {
                // Si no hay filtro en la petición ni en la sesión, ordenar por defecto por 'fecha_creacion' DESC
                $filtro['orden'] = 'fecha_registro';
            }
        }

        // Aplicar ordenamiento basado en el valor de $filtro['orden']
        switch ($filtro['orden']) {
            case 'precio_asc':
                $builder->orderBy('productos.precio', 'ASC');
                break;
            case 'precio_desc':
                $builder->orderBy('productos.precio', 'DESC');
                break;
            case 'novedades': // Asegúrate de usar 'novedades' si es el valor correcto en tu vista
            default: // Ordenar por 'fecha_creacion' DESC por defecto si el valor no es válido
                $builder->orderBy('productos.fecha_registro', 'DESC');
                break;
        }

        // Obtener los productos después de aplicar los filtros
        $productos = $productoModel->getProductosActivos($builder);

        $data = [
            'titulo'     => 'Catalogo',
            'productos'  => $productos,
            'categorias' => $categoriaModel->find(),
            'filtro'     => $filtro,
            'cart'       => $cart = \Config\Services::cart(),
        ];

        return view('layouts/header', $data)
            . view('web/catalogo', $data)
            . view('layouts/footer');
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto'   => $productoModel->obtenerProductoPorId($id),
            'imagenes'   => $productoModel->obtenerImagenesProducto($id),
            'categorias' => $productoModel->obtenerCategorias($id),
            'titulo'     => $productoModel->find($id)->nombre,
            'cart'       => $cart = \Config\Services::cart(),
        ];

        return view('layouts/header', $data) . view('web/producto', $data) . view('layouts/footer');
    }
}
