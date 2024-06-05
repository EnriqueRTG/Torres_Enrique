<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/**
 * Description of Terminos
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Terminos extends BaseController
{

    public function index()
    {
        $data = [
            'titulo' => 'Terminos',
        ];

        return view('layouts/header', $data) . view('web/terminos') . view('layouts/footer');
    }
}
