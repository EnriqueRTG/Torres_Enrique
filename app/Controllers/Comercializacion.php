<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of Comercializacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Comercializacion extends BaseController {

    public function index($page = 'comercializacion') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }

        $data = [
            'titulo' => 'Comercializacion',
        ];

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('paginas/' . $page) . view('/plantilla/footer');
    }

    public function obtenerMetodos() {
        return redirect()->to(base_url('comercializacion#formas-de-pago'));
    }
}
