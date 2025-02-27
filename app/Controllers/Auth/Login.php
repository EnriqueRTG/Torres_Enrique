<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

/** LISTO
 * Controlador para la autenticación de usuarios.
 *
 * Este controlador gestiona la visualización del formulario de login, el procesamiento de las credenciales,
 * el establecimiento de la sesión y el cierre de sesión. Dependiendo del rol del usuario autenticado, redirige
 * al dashboard de administración o a la sección pública.
 *
 * @package App\Controllers\Auth
 */
class Login extends BaseController
{
    /**
     * Instancia del modelo de usuarios.
     *
     * @var UsuarioModel
     */
    protected $usuarioModel;

    /**
     * Constructor.
     *
     * Carga los helpers necesarios y crea una instancia de UsuarioModel.
     */
    public function __construct()
    {
        helper(['form', 'url']);
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Muestra el formulario de login.
     *
     * Si el usuario ya está autenticado, redirige según su rol:
     * - Administrador: Dashboard de administración.
     * - Cliente: Sección pública (por ejemplo, catálogo).
     *
     * @return string Vista del formulario de login.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Ingresar',
        ];

        // Si ya hay un usuario autenticado, redirige según su rol
        $usuario = session()->get('usuario');
        if ($usuario) {
            if ($usuario->rol === 'administrador') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('web.home');
            }
        }

        return view('auth/login', $data);
    }

    /**
     * Procesa el login de un usuario.
     *
     * Valida los datos de entrada utilizando el grupo de validación "login". Si la validación falla,
     * redirige de vuelta con los errores y los datos ingresados. Si la validación es exitosa, se busca
     * el usuario por email y se verifica la contraseña. En caso de éxito, se establece la sesión y se redirige
     * según el rol; de lo contrario, se redirige con un mensaje de error.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la página correspondiente.
     */
    public function login_post()
    {
        // Validar los datos de entrada usando el grupo "login"
        if (!$this->validate('login')) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Obtener email y contraseña desde la solicitud POST
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Buscar el usuario por email
        $usuario = $this->usuarioModel->where('email', $email)->first();

        // Si no se encuentra el usuario, redirigir con mensaje de error
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario y/o Contraseña inválida');
        }

        // Verificar la contraseña
        if ($usuario && $this->usuarioModel->verificarPassword($password, $usuario->password)) {
            // Eliminar el campo password del objeto por seguridad
            unset($usuario->password);
            // Establecer la sesión del usuario
            $this->setUsuarioSesion($usuario);
            // Redirigir según el rol del usuario
            return $this->redirigirEnBaseAlRol($usuario->rol, $usuario->nombre, $usuario->apellido);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Establece la sesión del usuario autenticado.
     *
     * Guarda el objeto del usuario en la sesión para mantener la autenticación.
     *
     * @param object $usuario Objeto del usuario autenticado.
     */
    private function setUsuarioSesion($usuario)
    {
        session()->set('usuario', $usuario);
    }

    /**
     * Redirige al usuario en función de su rol.
     *
     * Si el usuario es administrador, lo redirige al dashboard de administración;
     * si es cliente, lo redirige a la sección pública (por ejemplo, catálogo).
     *
     * @param string $rol Rol del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $apellido Apellido del usuario.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección según el rol.
     */
    private function redirigirEnBaseAlRol($rol, $nombre, $apellido)
    {
        if ($rol === 'administrador') {
            return redirect()->route('admin.dashboard')->with('mensaje', 'Bienvenido al Dashboard, Usuario Administrador');
        } else {
            return redirect()->route('web.catalogo')->with('mensaje', 'Bienvenido ' . $nombre . ' ' . $apellido);
        }
    }

    /**
     * Cierra la sesión del usuario.
     *
     * Destruye todos los datos de la sesión y redirige al formulario de login.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la página de login.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->route('login');
    }
}
