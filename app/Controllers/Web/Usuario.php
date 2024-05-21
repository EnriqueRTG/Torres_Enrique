<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuario extends BaseController
{
    public function login()
    {
        $data = [
            'titulo'    => 'Ingresar',
        ];
        
        echo view('plantilla/header', $data). view('usuario/login'). view('plantilla/footer');
    }

    public function login_post()
    {
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
            return redirect()->to('/dashboard/panel')->with('mensaje', "Bienvenid@ $usuario->Nombre");
        }

        return redirect()->back()->with('mensaje', 'Usuario y/o Contraseña invalida');
    }

    public function register()
    {
        $data = [
            'titulo'    => 'Registrar',
        ];

        echo view('plantilla/header', $data). view('usuario/register'). view('plantilla/footer');
    }

    public function register_post()
    {
        $usuarioModel = new UsuarioModel();
        if ($this->validate('usuarios_create')) {
            $usuarioModel->insert([
                'nombre'      => $this->request->getPost('nombre'),
                'apellido'    => $this->request->getPost('apellido'),
                'email'       => $this->request->getPost('email'),
                'password'    => $usuarioModel->passwordHash($this->request->getPost('password')),
                'direccion'   => $this->request->getPost('direccion'),
                'telefono'    => $this->request->getPost('telefono'),
            ]);
            return redirect()->to(route_to('usuario.login'))->with('mensaje', "Usuario registrado exitosamente");
        }

        session()->setFlashdata([
            'validation' => $this->validator
        ]);

        return redirect()->back()->withInput();
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

    public function probar_password()
    {
        $usuarioModel = new UsuarioModel();
        var_dump($usuarioModel->passwordVerificar('12345', '$2y$10$0yGV3Ym3EPaH8lXeJj2yaO6u1sU1PyzbsrM3pZtcrqIgeTnyLZ80W'));
    }
}
