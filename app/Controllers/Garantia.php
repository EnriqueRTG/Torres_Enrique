<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of Garantia
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Garantia extends BaseController {

    public function index($page = 'garantia') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

       $data = [
            'titulo' => 'Garantia',
        ];

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('paginas/' . $page) . view('/plantilla/footer');
    }
}
