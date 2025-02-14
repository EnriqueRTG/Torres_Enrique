<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Home extends BaseController
{

    public function index()
    {
        $data = [
            'titulo'     => 'Home',
            'cart'       => $cart = \Config\Services::cart(),
            'mensaje' => session('mensaje')
        ];

        return view('web/home', $data);
    }
}
