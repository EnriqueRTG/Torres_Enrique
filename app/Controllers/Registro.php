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
class Registro extends BaseController {

    public function index($page = 'registro') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $data = [
            'titulo'    => 'Registro',
        ];

        return view('/plantilla/header', $data). view('paginas/' . $page) . view('/plantilla/footer');
    }

   
}