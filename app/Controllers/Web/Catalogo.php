<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

use App\Models\ProductoModel;
use App\Models\ImagenModel;
use App\Models\ProductoImagenModel;

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

        $data = [
            'titulo'    => 'Catalogo',
            'productos' => $productoModel->find(), // generar query de productos activos
        ];

        return view('layouts/header', $data) . view('web/catalogo') . view('layouts/footer');
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto' => $productoModel->productoDetallado($id),
            'imagenes' => $productoModel->getImangenById($id),
            'titulo' => $productoModel->find($id)->nombre,
        ];

        return view('layouts/header', $data) . view('web/producto') . view('layouts/footer');
    }
}
