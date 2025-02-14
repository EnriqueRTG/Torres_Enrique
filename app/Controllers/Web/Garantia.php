<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/**
 * Description of Garantia
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Garantia extends BaseController
{

    public function index()
    {
        $data = [
            'titulo' => 'Garantia',
            'cart'       => $cart = \Config\Services::cart(),
        ];

        return view('web/garantia', $data);
    }
}
