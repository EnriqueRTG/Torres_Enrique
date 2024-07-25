<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuario extends BaseController
{

    public function __construct(){
        helper(['url', 'form', 'session']);
    }

    public function login()
    {
        $data = [
            'titulo'    => 'Ingresar',
        ];

        echo view('plantilla/header', $data) . view('usuario/login') . view('plantilla/footer');
    }

    public function login_post()
    {
        if (!$this->validate('registros')) { // Validación usando el grupo 'registros'
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $usuarioModel = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $usuarioModel->select('id,nombre,apellido,email,password,direccion,telefono,rol_id')
            ->orWhere('email', $email)
            ->orWhere('password', $password)
            ->first();

        if (!$usuario) {
            return redirect()->back()->with('mensaje', 'Usuario y/o Contraseña invalida');
        }

        if ($usuarioModel->passwordVerificar($password, $usuario->password)) {
            unset($usuario->password);
            session()->set('usuario', $usuario);
            if ($usuario->rol_id == 1) {
                return redirect()->to('/dashboard/panel')->with('mensaje', "Bienvenid@ $usuario->Nombre");
            } else {
                return redirect()->to('/catalogo')->with('mensaje', "Bienvenid@ $usuario->Nombre");
            }
        }

        return redirect()->back()->with('mensaje', 'Usuario y/o Contraseña invalida');
    }

    public function register()
    {
        $data = [
            'titulo'    => 'Registrar',
        ];

        echo view('plantilla/header', $data) . view('usuario/register') . view('plantilla/footer');
    }

    /* 
    Guardar un nuevo usuario en la base de datos    
    */

    public function register_post()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'titulo'    => 'Registrar',
        ];

        $validacion = $this->validate('usuarios_create');

        if (!$validacion) {
            return view('plantilla/header', $data) . view('usuario/register', ['validacion' => $this->validator]) . view('plantilla/footer');
        }

        if (!$this->validate('usuarios_create')) {
            // Redirigir a la vista de registro con los errores
            session()->setFlashdata(['validation' => $this->validator]);
            return redirect()->back()->withInput();
        }

        // Procesar el registro del usuario (guardar en la base de datos, etc.)
        if ($this->validate('usuarios_create')) {
            $usuarioModel->insert([
                'nombre'               => $this->request->getPost('nombre'),
                'apellido'             => $this->request->getPost('apellido'),
                'email'                => $this->request->getPost('email'),
                'password'             => $usuarioModel->passwordHash($this->request->getPost('password')),
                'direccion'            => $this->request->getPost('direccion'),
                'telefono'             => $this->request->getPost('telefono'),
                'fecha_alta'           => date('Y-m-d H:m:s'),
                'fecha_actualizacion'  => date('Y-m-d H:m:s'),
            ]);
            return redirect()->to('/usuario/login')->with('mensaje', "Usuario registrado exitosamente");
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(route_to('usuario.login'));
    }

    public function crear_usuario()
    {
        $usuarioModel = new UsuarioModel();
        $usuarioModel->insert(
            [
                'nombre'    => 'Fulano',
                'apellido'  => 'Mengano',
                'email'     => 'admin@gmail.com',
                'password'  => $usuarioModel->passwordHash('12345'),
                'rol_id'    => 1,
                'direccion' => 'muy muy lejano 12345',
                'telefono'  => '080012345',
            ]
        );
    }

}
