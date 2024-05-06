<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of Contacto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Contacto extends BaseController {

    public function index($page = 'contacto') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $data = [
            'titulo' => 'Contacto',
        ];

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('paginas/' . $page) . view('/plantilla/footer');
    }

    public function obtenerUbicacion() {
        return redirect()->to(base_url('contacto#ubicacion'));
    }
}
