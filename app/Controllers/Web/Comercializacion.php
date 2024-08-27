<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/**
 * Description of Comercializacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Comercializacion extends BaseController
{

    public function index()
    {
        $data = [
            'titulo' => 'Comercializacion',
            'cart'       => $cart = \Config\Services::cart(),
        ];

        return view('layouts/header', $data) . view('web/comercializacion') . view('layouts/footer');
    }

    public function obtener_metodos()
    {
        return redirect()->to(base_url('comercializacion#formas-de-pago'));
    }
}
