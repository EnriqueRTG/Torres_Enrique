<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/**
 * Description of Contacto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Contacto extends BaseController
{
    public function index()
    {
        $data = [
            'titulo' => 'Contacto',
        ];

        return view('layouts/header', $data) . view('web/contacto') . view('layouts/footer');
    }

    public function obtener_ubicacion()
    {
        return redirect()->to(base_url('contacto#ubicacion'));
    }

    public function enviar_contacto()
    {
        $data = [
            'titulo' => 'Contacto',
        ];

        return view('layouts/header', $data) . view('web/contacto') . view('layouts/footer');
    }
}
