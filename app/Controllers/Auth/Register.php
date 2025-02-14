<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Register extends BaseController
{

    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        // Si el usuario ya está logueado, redirígelo según su rol
        if (session()->get('usuario')) {
            if (session()->get('usuario')->rol_id == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('web.home');
            }
        }

        $data = [
            'titulo'    => 'Registrar',
        ];

        return view('auth/register', $data);
    }

    /* 
    Guardar un nuevo usuario en la base de datos    
    */

    public function register_post()
    {
        if (!$this->validate('registros')) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $passwordHash = $this->usuarioModel->passwordHash($this->request->getPost('password'));

        $data = [
            'nombre' => $this->request->getVar('nombre'),
            'apellido' => $this->request->getVar('apellido'),
            'email' => $this->request->getVar('email'),
            'password' => $passwordHash,
            'direccion' => $this->request->getVar('direccion'),
        ];

        try {
            $this->usuarioModel->insert($data);
            return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage()); // Registra el error en el log
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.');
        }
    }
}
