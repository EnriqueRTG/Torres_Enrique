<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ContactoModel;

/**
 * Description of Contacto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Contacto extends BaseController
{
    protected $contactoModel;

    public function __construct()
    {
        $this->contactoModel = new ContactoModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Contacto',
            'cart'       => $cart = \Config\Services::cart(),
        ];

        return  view('web/contacto', $data);
    }

    public function obtener_ubicacion()
    {
        return redirect()->to(base_url('contacto#ubicacion'));
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->contactoModel->crearContacto($data)) {
            return redirect()->to('web/contacto')->with('mensaje', 'Mensaje de contacto realizado con exito!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->contactoModel->errors())->with('validation', $this->validator);;
        }
    }
}
