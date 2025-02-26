<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

/** LISTO
 * Controlador para el registro de clientes.
 *
 * Este controlador gestiona la visualización del formulario de registro y el procesamiento del mismo.
 * Se valida la entrada de datos utilizando un grupo de validación predefinido ("registros"), se crea un nuevo
 * cliente (forzando el rol "cliente" y encriptando la contraseña) mediante el método personalizado del modelo
 * y se redirige al usuario según el resultado.
 *
 * @package App\Controllers\Auth
 */
class Register extends BaseController
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
     * Inicializa la instancia del modelo de usuarios.
     */
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Muestra el formulario de registro.
     *
     * Si ya hay un usuario autenticado, redirige según su rol.
     *
     * @return string Vista del formulario de registro.
     */
    public function index()
    {
        // Si el usuario ya está autenticado, redirige según su rol.
        if (session()->get('usuario')) {
            if (session()->get('usuario')->rol_id == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('web.home');
            }
        }

        $data = [
            'titulo' => 'Registrar'
        ];

        return view('auth/register', $data);
    }

    /**
     * Procesa el registro de un nuevo cliente.
     *
     * Este método realiza las siguientes acciones:
     * 1. Valida los datos del formulario utilizando el grupo de validación "registros".
     * 2. Si la validación falla, redirige de vuelta con los datos ingresados y los errores correspondientes.
     * 3. Si la validación es exitosa, se crea el cliente mediante el método 'crearCliente()' del modelo UsuarioModel,
     *    que se encarga de forzar el rol "cliente" y encriptar la contraseña.
     * 4. Si ocurre algún error (por ejemplo, email duplicado), se redirige con un mensaje de error.
     * 5. En caso de éxito, se redirige a la ruta de login con un mensaje de confirmación.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la página correspondiente con mensajes de error o éxito.
     */
    public function register_post()
    {
        // Validar la entrada usando el grupo de validación "registros"
        if (!$this->validate('registros')) {
            // Si la validación falla, redirige de vuelta con los datos ingresados y los mensajes de error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Obtener los datos del formulario enviados vía POST
        $data = $this->request->getPost();

        try {
            // Intentar crear el cliente utilizando el método personalizado del modelo.
            // Este método se encarga de forzar el rol "cliente", encriptar la contraseña, y validar nuevamente si es necesario.
            $nuevoClienteId = $this->usuarioModel->crearCliente($data);

            // Si 'crearCliente' retorna false, significa que hubo un error (por ejemplo, email duplicado)
            if (!$nuevoClienteId) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No se pudo registrar el usuario. Verifica que el email no exista y que los datos sean correctos.');
            }

            // Registro exitoso: redirige al login con un mensaje de éxito
            return redirect()->route('login')->with('mensaje', 'Registro exitoso. Ahora puedes iniciar sesión.');
        } catch (\Exception $e) {
            // Registrar la excepción en el log y redirigir de vuelta con un mensaje genérico de error
            log_message('error', $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.');
        }
    }
}
