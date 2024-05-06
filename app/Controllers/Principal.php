<?php

namespace App\Controllers;

class Principal extends BaseController {

    public function index($page = 'principal') {
        if (!is_file(APPPATH . 'Views/paginas/' . $page . '.php')) {
            // No se encontro la pagina.
            throw new PageNotFoundException($page);
        }
        
        $data = [
            'titulo'     => 'Prinicipal',
            
        ];

        $mensaje = session('mensaje');

        return view('/plantilla/header', $data) . view('/partials/navbar') . view('paginas/' . $page, ["mensaje" => $mensaje]) . view('/plantilla/footer');
    }

    public function fallo() {
        return view('/pages/fallo');
    }
}
