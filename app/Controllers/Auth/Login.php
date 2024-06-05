<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use Config\Services;

class Login extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data = [
            'titulo'    => 'Ingresar',
        ];

        // Si el usuario ya está logueado, redirígelo según su rol
        if (session()->get('usuario')) {
            if (session()->get('usuario')->rol_id === 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('web.home');
            }
        }

        return view('layouts/header', $data) . view('auth/login') . view('layouts/footer'); // Muestra la vista del formulario de login
    }

    public function login_post()
    {
        if (!$this->validate('login')) { // Validación usando el grupo 'login'
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $usuario = $this->usuarioModel->where('email', $email)->first();

        if (!$usuario) {
            return redirect()->back()->with('mensaje', 'Usuario y/o Contraseña invalida');
        }

        if ($usuario && $this->usuarioModel->passwordVerificar($password, $usuario->password)) {
            unset($usuario->password); // elimino la password del conjunto de datos traidos del usuario
            $this->setUsuarioSesion($usuario); // guardo los datos del usuario en la sesion
            return $this->redirectBasedOnRole($usuario->rol_id); // redirijo a algun modulo de la aplicion en funcion al rol del usuario
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas. Por favor, inténtalo de nuevo.');
        }
    }

    private function setUsuarioSesion($usuario)
    {
        session()->set('usuario', $usuario);
    }

    private function redirectBasedOnRole($rol_id)
    {
        if ($rol_id == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('web.catalogo');
        }
    }

    public function logout()
    {
        session()->destroy(); // Destruye todos los datos de la sesión
        return redirect()->route('login'); // Redirige a la página de login
    }
}
