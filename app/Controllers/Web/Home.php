<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Home extends BaseController
{

    public function index()
    {
        $data = [
            'titulo'     => 'Home',
        ];

        $mensaje = session('mensaje');

        return view('layouts/header', $data) . view('web/home', ["mensaje" => $mensaje]) . view('layouts/footer');
    }
}
