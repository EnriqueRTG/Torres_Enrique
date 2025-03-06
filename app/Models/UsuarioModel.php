<?php

namespace App\Models;

use CodeIgniter\Model;

/** LISTO
 * Modelo para la gestión de usuarios.
 *
 * Este modelo administra operaciones CRUD para los usuarios, además de operaciones 
 * específicas para clientes y administradores. También incluye métodos para validación, 
 * encriptación de contraseñas y filtrado/paginación de clientes.
 *
 * @package App\Models
 * @author  
 */
class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'password', 'rol', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;       // Habilitar marcas de tiempo (created_at, updated_at)
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    /**
     * Reglas de validación para los campos del usuario.
     *
     * Estas reglas se aplican cuando se valida la entrada de datos.
     *
     * @var array
     */
    protected $validationRules = [
        'nombre'   => 'required|min_length[2]|max_length[255]',
        'apellido' => 'required|min_length[2]|max_length[255]',
        'email'    => 'required|valid_email|max_length[255]',
        'password' => 'required|min_length[6]|max_length[255]',
        'rol'      => 'required|in_list[cliente,administrador]',
        'estado'   => 'required|in_list[activo,inactivo]',
    ];

    /**
     * Mensajes personalizados para cada regla de validación.
     *
     * @var array
     */
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede superar los 255 caracteres.',
        ],
        'apellido' => [
            'required'   => 'El apellido es obligatorio.',
            'min_length' => 'El apellido debe tener al menos 2 caracteres.',
            'max_length' => 'El apellido no puede superar los 255 caracteres.',
        ],
        'email' => [
            'required'    => 'El email es obligatorio.',
            'valid_email' => 'Debes ingresar un email válido.',
            'max_length'  => 'El email no puede superar los 255 caracteres.',
        ],
        'password' => [
            'required'   => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
            'max_length' => 'La contraseña no puede superar los 255 caracteres.',
        ],
        'rol' => [
            'required' => 'El rol es obligatorio.',
            'in_list'  => 'El rol debe ser "cliente" o "administrador".',
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list'  => 'El estado debe ser "activo" o "inactivo".',
        ],
    ];

    // --------------------------------------------------------------
    // Métodos personalizados para operaciones específicas
    // --------------------------------------------------------------

    /**
     * Busca un usuario por su email.
     *
     * @param string $email Email del usuario.
     * @return object|null Objeto usuario o null si no se encuentra.
     */
    public function encontrarPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Verifica si la contraseña ingresada coincide con el hash almacenado.
     *
     * @param string $passwordIngresada Contraseña ingresada.
     * @param string $passwordHash Hash de la contraseña almacenado.
     * @return bool True si la contraseña es correcta, false en caso contrario.
     */
    public function verificarPassword($passwordIngresada, $passwordHash)
    {
        return password_verify($passwordIngresada, $passwordHash);
    }

    /**
     * Encripta la contraseña utilizando el algoritmo predeterminado.
     *
     * @param string $password Contraseña en texto plano.
     * @return string Hash de la contraseña.
     */
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Obtiene todos los usuarios activos.
     *
     * @return array Lista de usuarios activos.
     */
    public function traerUsuariosActivos()
    {
        return $this->where('estado', 'activo')->findAll();
    }

    /**
     * Obtiene todos los clientes activos.
     *
     * @return array Lista de clientes activos.
     */
    public function traerClientesActivos()
    {
        return $this->where('estado', 'activo')
            ->where('rol', 'cliente')
            ->findAll();
    }

    /**
     * Obtiene todos los usuarios administradores.
     *
     * @return array Lista de administradores.
     */
    public function traerAdministradores()
    {
        return $this->where('rol', 'administrador')->findAll();
    }

    /**
     * Crea un nuevo cliente.
     *
     * Este método recibe un array asociativo con los datos del cliente y realiza las siguientes operaciones:
     * - Fuerza el rol "cliente" y asigna un estado por defecto ("activo") si no se proporciona.
     * - Verifica que se haya enviado una contraseña y la encripta.
     * - Verifica que el email no esté registrado previamente.
     * - Valida los datos utilizando las reglas definidas en el modelo.
     * - Inserta el registro en la base de datos y retorna el ID del nuevo cliente.
     *
     * @param array $datosCliente Datos del cliente.
     * @return int|false ID del cliente insertado o false en caso de error.
     */
    public function crearCliente(array $datosCliente)
    {
        // Forzar el rol a "cliente"
        $datosCliente['rol'] = 'cliente';

        // Asignar estado por defecto si no se proporciona
        if (!isset($datosCliente['estado']) || empty($datosCliente['estado'])) {
            $datosCliente['estado'] = 'activo';
        }

        // Verificar que se haya proporcionado una contraseña
        if (empty($datosCliente['password'])) {
            return false;
        }

        // Encriptar la contraseña
        $datosCliente['password'] = $this->passwordHash($datosCliente['password']);

        // Verificar que el email no esté registrado previamente
        if ($this->encontrarPorEmail($datosCliente['email'])) {
            return false;
        }

        // Validar los datos utilizando las reglas definidas en el modelo
        if (!$this->validate($datosCliente)) {
            return false;
        }

        // Insertar el nuevo cliente en la base de datos
        $this->insert($datosCliente);

        // Retornar el ID del nuevo cliente
        return $this->getInsertID();
    }

    // --------------------------------------------------------------
    // Métodos para filtrar y paginar clientes (Rol 'cliente')
    // --------------------------------------------------------------

    /**
     * Filtra los clientes en base a un término de búsqueda, estado, página y cantidad por página.
     *
     * Se buscará en los campos: nombre, apellido y email.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado del cliente ('activo', 'inactivo' o 'todos').
     * @param int $pagina Número de la página actual.
     * @param int $porPagina Número de registros por página.
     * @return array Lista de clientes filtrados (arreglo asociativo).
     */
    public function filtrarClientes($texto = '', $estado = 'todos', $pagina = 1, $porPagina = 10)
    {
        // Inicia la consulta sobre la tabla de usuarios
        $builder = $this->db->table($this->table);
        // Filtrar solo usuarios con rol 'cliente'
        $builder->where('rol', 'cliente');

        // Aplicar filtro de búsqueda si se proporciona texto
        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('apellido', $texto)
                ->orLike('email', $texto)
                ->groupEnd();
        }

        // Filtrar por estado, a menos que se quiera mostrar todos
        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        // Ordenar por la fecha de última actualización en orden descendente
        $builder->orderBy('updated_at', 'DESC');

        // Calcular el offset y limitar los resultados
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        return $builder->get()->getResultArray();
    }

    /**
     * Calcula el total de páginas para la paginación de clientes según los filtros aplicados.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado ('activo', 'inactivo' o 'todos').
     * @param int $porPagina Número de registros por página.
     * @return int Total de páginas.
     */
    public function obtenerTotalPaginasClientes($texto = '', $estado = 'todos', $porPagina = 10)
    {
        $builder = $this->db->table($this->table);
        $builder->where('rol', 'cliente');

        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('apellido', $texto)
                ->orLike('email', $texto)
                ->groupEnd();
        }

        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        $totalRegistros = $builder->countAllResults();
        return ceil($totalRegistros / $porPagina);
    }

    /**
     * Obtiene los clientes filtrados utilizando la paginación automática de CodeIgniter.
     *
     * Este método aprovecha la función paginate() del modelo para obtener una lista paginada de clientes.
     *
     * @param string $estado Estado de los clientes ('activo', 'inactivo' o 'todos').
     * @param string $busqueda Texto de búsqueda.
     * @param int $perPage Número de registros por página.
     * @return mixed Lista paginada de clientes.
     */
    public function obtenerClientesFiltrados($estado = 'todos', $busqueda = '', $perPage = 10)
    {
        // Filtrar solo usuarios con rol 'cliente'
        $this->where('rol', 'cliente');

        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('apellido', $busqueda)
                ->orLike('email', $busqueda)
                ->groupEnd();
        }

        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        return $this->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Actualiza los datos del usuario con rol cliente.
     *
     * Este método actualiza únicamente los campos "nombre" y "apellido" del usuario, ignorando cualquier otro dato.
     *
     * Se espera que la información sensible (correo, contraseña, rol, etc.) no sea modificada aquí.
     *
     * @param int   $id   ID del usuario a actualizar.
     * @param array $data Array asociativo con las claves "nombre" y "apellido".
     * @return bool True si la actualización es exitosa, false en caso contrario.
     */
    public function actualizarCliente(int $id, array $data): bool
    {
        // Extraer solo los campos permitidos
        $updateData = [
            'nombre'   => isset($data['nombre']) ? trim($data['nombre']) : '',
            'apellido' => isset($data['apellido']) ? trim($data['apellido']) : '',
        ];

        // Validar los datos extraídos según las reglas definidas
        if (!$this->validate($updateData)) {
            return false;
        }

        // Actualizar el registro en la base de datos
        return $this->update($id, $updateData);
    }

    /**
     * Obtiene un cliente por su ID.
     *
     * @param int $id ID del cliente.
     * @return object|null Objeto cliente o null si no se encuentra o si el usuario no es de rol 'cliente'.
     */
    public function obtenerClientePorId(int $id)
    {
        return $this->where('id', $id)
            ->where('rol', 'cliente')
            ->first();
    }
}
