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

    protected $productoModel;
    protected $categoriaModel;
    protected $cart;

    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $filtro = $this->request->getGet();
        $session = session();

        if ($this->request->getGet('limpiar_filtros')) {
            $session->remove(['filtro_categoria', 'filtro_precio_min', 'filtro_precio_max', 'filtro_orden']);
            return redirect()->to(route_to('web.catalogo'));
        }

        // Construir la consulta utilizando el Query Builder
        $builder = $this->productoModel->builder(); // Usar el builder del modelo para aprovechar las relaciones

        // Aplicar filtros (leer de la sesión si existen)
        if (!empty($filtro['categoria'])) {
            $builder->whereIn('productos.categoria_id', $filtro['categoria']); // Filtrar por 'categoria_id' en la tabla 'productos'
            $session->set('filtro_categoria', $filtro['categoria']);
        } elseif ($session->has('filtro_categoria')) {
            $filtro['categoria'] = $session->get('filtro_categoria');
            $builder->whereIn('productos.categoria_id', $filtro['categoria']);
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
        $productos = $this->productoModel->getProductosActivos($builder);

        // Obtener las categorías que tienen productos activos en stock
        $categorias = $this->obtenerCategoriasConProductosActivos();

        $data = [
            'titulo'     => 'Catalogo',
            'productos'  => $productos,
            'categorias' => $categorias,
            'filtro'     => $filtro,
            'cart'       => $this->cart,
        ];

        return view('layouts/header', $data)
            . view('web/catalogo', $data)
            . view('layouts/footer');
    }

    // Método privado para obtener categorías con productos activos
    private function obtenerCategoriasConProductosActivos()
    {
        return $this->categoriaModel->select('categorias.*')
            ->join('productos', 'productos.categoria_id = categorias.id')
            ->where('productos.estado', 'activo')
            ->where('productos.stock >', 0)
            ->groupBy('categorias.id')
            ->findAll();
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto'   => $productoModel->obtenerProductoPorId($id),
            'imagenes'   => $productoModel->obtenerImagenesProducto($id),
            'titulo'     => $productoModel->find($id)->nombre,
            'cart'       => $this->cart,
        ];

        return view('layouts/header', $data) . view('web/producto', $data) . view('layouts/footer');
    }
}
