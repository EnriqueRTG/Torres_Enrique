<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of Terminos
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Terminos extends BaseController {

    public function index($page = 'terminos') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $data = [
            'titulo' => 'Terminos',
        ];

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('/paginas/terminos', $data) . view('/plantilla/footer');
    }
}
