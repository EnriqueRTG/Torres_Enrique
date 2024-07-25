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
        ];

        return view('layouts/header', $data) . view('web/contacto') . view('layouts/footer');
    }

    public function obtener_ubicacion()
    {
        return redirect()->to(base_url('contacto#ubicacion'));
    }

    public function contacto_post()
    {
        if (!$this->validate('contactos')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getVar('nombre'),
            'email' => $this->request->getVar('email'),
            'asunto' => $this->request->getVar('asunto'),
            'mensaje' => $this->request->getVar('mensaje'),
        ];

        try {
            $this->contactoModel->insert($data);
            return redirect()->to('contacto')->with('success', 'Mensaje enviado correctamente');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage()); // Registra el error en el log
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.');
        }
    }
}
