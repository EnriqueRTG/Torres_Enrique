<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

use App\Models\ProductoModel;

/**
 * Description of Comercializacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Catalogo extends BaseController
{

    public function index($page = 'catalogo')
    {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $productoModel = new ProductoModel();

        $data = [
            'titulo'    => 'Catalogo',
            'productos' => $productoModel->find(),
        ];

        return view('/plantilla/header', $data) . view('paginas/' . $page) . view('/plantilla/footer');
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto' => $productoModel->traerDetalleProductoCompleto($id),
            'titulo' => $productoModel->find($id)->nombre,
        ];

        return view('/plantilla/header', $data) . view('paginas/producto') . view('/plantilla/footer');
    }
}
