<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of Nosotros
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Nosotros extends BaseController {

    public function index($page = 'nosotros') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $data = [
            'titulo' => 'Nosotros',
        ];

        $data['title'] = ucfirst($page); //Capitaliza la primera letra

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('paginas/' . $page) . view('/plantilla/footer');
    }
}
