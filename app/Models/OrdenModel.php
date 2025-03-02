<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la gestión de órdenes de compra.
 *
 * Administra la creación, actualización, consulta y cancelación (eliminación lógica)
 * de las órdenes. Incluye validaciones para garantizar la integridad de los datos.
 *
 * @package App\Models
 */
class OrdenModel extends Model
{
    protected $table            = 'ordenes';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'estado', 'total', 'direccion_envio_id'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    /**
     * Reglas de validación para los campos de la orden.
     *
     * @var array
     */
    protected $validationRules = [
        'usuario_id'         => 'required|integer',
        'estado'             => 'required|in_list[pendiente,procesanda,enviada,completada,cancelada]',
        'total'              => 'required|decimal|greater_than_equal_to[0]',
        'direccion_envio_id' => 'required|integer',
    ];

    /**
     * Mensajes personalizados para la validación de la orden.
     *
     * @var array
     */
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer'  => 'El ID de usuario debe ser un número entero.',
        ],
        'estado' => [
            'required' => 'El estado de la orden es obligatorio.',
            'in_list'  => 'El estado de la orden debe ser uno de los siguientes: pendiente, procesanda, enviada, completada, cancelada.',
        ],
        'total' => [
            'required'              => 'El total de la orden es obligatorio.',
            'decimal'               => 'El total debe ser un número decimal.',
            'greater_than_equal_to' => 'El total no puede ser negativo.',
        ],
        'direccion_envio_id' => [
            'required' => 'La dirección de envío es obligatoria.',
            'integer'  => 'El ID de la dirección de envío debe ser un número entero.',
        ],
    ];

    // --------------------------------------------------------------------------
    // Métodos personalizados para órdenes
    // --------------------------------------------------------------------------

    /**
     * Crea una nueva orden de compra.
     *
     * Valida los datos de la orden según las reglas definidas. Si la validación falla, retorna false.
     * Si la validación es exitosa, inserta la orden en la base de datos y retorna el ID de la orden.
     *
     * @param array $data Datos de la orden a insertar.
     * @return int|false ID de la orden insertada o false si falla la validación.
     */
    public function crearOrden(array $data)
    {
        // Validar los datos usando las reglas definidas en el modelo
        if (!$this->validate($data)) {
            // Se pueden obtener los errores con $this->errors()
            return false;
        }
        // Insertar la orden y retornar el ID insertado
        $this->insert($data);

        return $this->getInsertID();
    }

    /**
     * Actualiza los datos de una orden existente.
     *
     * Valida los datos proporcionados conforme a las reglas definidas en el modelo.
     * Si la validación falla, retorna false; de lo contrario, actualiza la orden y retorna true.
     *
     * @param int $id ID de la orden a actualizar.
     * @param array $data Array asociativo con los datos a actualizar.
     * @return bool True si la actualización es exitosa, false en caso de fallo.
     */
    public function actualizarOrden(int $id, array $data): bool
    {
        // Validar los datos usando las reglas del modelo
        if (!$this->validate($data)) {
            return false;
        }
        // Actualizar la orden en la base de datos
        return $this->update($id, $data);
    }

    /**
     * Cancela una orden de forma lógica.
     *
     * En lugar de eliminar físicamente la orden, este método actualiza el campo "estado"
     * a "cancelada". Retorna true si la operación es exitosa.
     *
     * @param int $id ID de la orden a cancelar.
     * @return bool True si la orden se actualizó a "cancelada", false en caso de fallo.
     */
    public function cancelarOrden(int $id): bool
    {
        // Actualizar el estado de la orden a "cancelada"
        return $this->update($id, ['estado' => 'cancelada']);
    }

    /**
     * Obtiene las órdenes de un usuario específico.
     *
     * @param int $usuarioId ID del usuario.
     * @return array Lista de órdenes del usuario.
     */
    public function obtenerOrdenesPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Obtiene las órdenes pendientes.
     *
     * @return array Lista de órdenes con estado "pendiente".
     */
    public function obtenerOrdenesPendientes()
    {
        return $this->where('estado', 'pendiente')->findAll();
    }

    /**
     * Obtiene las órdenes procesadas.
     *
     * @return array Lista de órdenes con estado "procesanda".
     */
    public function obtenerOrdenesProcesadas()
    {
        return $this->where('estado', 'procesanda')->findAll();
    }

    /**
     * Obtiene las órdenes enviadas.
     *
     * @return array Lista de órdenes con estado "enviada".
     */
    public function obtenerOrdenesEnviadas()
    {
        return $this->where('estado', 'enviada')->findAll();
    }

    /**
     * Obtiene las órdenes completadas.
     *
     * @return array Lista de órdenes con estado "completada".
     */
    public function obtenerOrdenesCompletadas()
    {
        return $this->where('estado', 'completada')->findAll();
    }

    /**
     * Obtiene las órdenes canceladas.
     *
     * @return array Lista de órdenes con estado "cancelada".
     */
    public function obtenerOrdenesCanceladas()
    {
        return $this->where('estado', 'cancelada')->findAll();
    }

    /**
     * Obtiene información detallada de una orden específica.
     *
     * Realiza joins con las tablas de usuarios y direcciones para obtener información adicional.
     * Además, carga los detalles de la orden (productos, cantidades, precios).
     *
     * @param int $ordenId ID de la orden.
     * @return object|null Objeto con la información detallada de la orden o null si no se encuentra.
     */
    public function obtenerOrdenDetallada($ordenId)
    {
        $orden = $this->select([
            'ordenes.*',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario',
            'usuarios.email as email_usuario',
            'direcciones.nombre_destinatario',
            'direcciones.calle',
            'direcciones.numero',
            'direcciones.piso',
            'direcciones.departamento',
            'direcciones.ciudad',
            'direcciones.provincia',
            'direcciones.codigo_postal',
            'direcciones.telefono'
        ])
            ->join('usuarios', 'usuarios.id = ordenes.usuario_id')
            ->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id')
            ->where('ordenes.id', $ordenId)
            ->first();

        if ($orden) {
            $detalleOrdenModel = new \App\Models\DetalleOrdenModel();
            $orden->detalles = $detalleOrdenModel->select([
                'detalle_orden.*',
                'productos.nombre as nombre_producto'
            ])
                ->join('productos', 'productos.id = detalle_orden.producto_id')
                ->where('detalle_orden.orden_id', $ordenId) // Especificar el alias aquí
                ->findAll();
        } else {
            return null;
        }

        return $orden;
    }

    public function obtenerOrdenesDetalladas()
    {
        $orden = $this->select([
            'ordenes.*',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario',
            'usuarios.email as email_usuario',
            'direcciones.nombre_destinatario',
            'direcciones.calle',
            'direcciones.numero',
            'direcciones.piso',
            'direcciones.departamento',
            'direcciones.ciudad',
            'direcciones.provincia',
            'direcciones.codigo_postal',
            'direcciones.telefono'
        ])
            ->join('usuarios', 'usuarios.id = ordenes.usuario_id')
            ->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id')
            ->orderBy('ordenes.created_at', 'DESC')
            ->findAll();

        return $orden;
    }

    /**
     * Obtiene las órdenes filtradas y paginadas según el estado y un término de búsqueda.
     *
     * Este método realiza un join con las tablas "usuarios" y "direcciones" para obtener
     * información adicional del cliente y de la dirección de envío. La búsqueda se puede
     * realizar tanto por el ID de la orden (si el término es numérico) como por el nombre
     * o apellido del cliente.
     *
     * - Si el parámetro $estado es distinto de "todas", se filtran las órdenes según ese estado.
     * - Si se proporciona un término de búsqueda en $busqueda, se agrupan las condiciones para:
     *      - Buscar por un ID exacto de la orden (si $busqueda es numérico).
     *      - Buscar por coincidencias parciales en los campos "nombre" o "apellido" del cliente.
     * - Los resultados se ordenan por fecha de creación en orden descendente y se paginan.
     *
     * @param string $estado    Estado a filtrar (por ejemplo: "pendiente", "completada", "cancelada" o "todas").
     * @param string $busqueda  Término de búsqueda (puede ser parte del ID de la orden o del nombre/apellido del cliente).
     * @param int    $pagina    Número de página actual.
     * @param int    $porPagina Número de registros por página.
     * @return array            Array de órdenes filtradas y paginadas.
     */
    public function obtenerOrdenesFiltradas(string $estado = 'pendiente', string $busqueda = '', int $pagina = 1, int $porPagina = 10)
    {
        // Inicializar el query builder para la tabla "ordenes"
        $builder = $this->builder();

        // Seleccionar campos específicos de las tablas involucradas
        $builder->select('
            ordenes.id,
            ordenes.estado AS orden_estado,
            ordenes.total,
            ordenes.created_at,
            usuarios.nombre AS nombre_cliente,
            usuarios.apellido AS apellido_cliente,
            direcciones.calle,
            direcciones.numero,
            direcciones.ciudad,
            direcciones.provincia
        ');

        // Unir la tabla "usuarios" para obtener datos del cliente
        $builder->join('usuarios', 'usuarios.id = ordenes.usuario_id', 'left');

        // Unir la tabla "direcciones" para obtener la información de envío
        $builder->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id', 'left');

        // Si se proporcionó un término de búsqueda, aplicar condiciones adicionales
        if (!empty($busqueda)) {
            // Agrupar las condiciones para que se combinen correctamente con AND/OR
            $builder->groupStart();
            if (is_numeric($busqueda)) {
                // Si el término es numérico, buscar por ID exacto
                $builder->orWhere('ordenes.id', $busqueda);
            }
            // Buscar por coincidencias parciales en nombre o apellido del cliente
            $builder->orLike('usuarios.nombre', $busqueda)
                ->orLike('usuarios.apellido', $busqueda);
            $builder->groupEnd();
        }

        // Filtrar por estado si éste es distinto de "todas"
        if ($estado !== 'todas') {
            $builder->where('ordenes.estado', $estado);
        }

        // Ordenar los resultados por fecha de creación de forma descendente
        $builder->orderBy('ordenes.created_at', 'DESC');

        // Retornar los resultados paginados usando el método paginate de CodeIgniter 4
        return $this->paginate($porPagina, 'default', $pagina);
    }

    /**
     * Calcula el total de páginas para las órdenes filtradas.
     *
     * Realiza la misma lógica de filtrado que en obtenerOrdenesFiltradas() y cuenta el total de registros.
     * Luego, divide el total entre el número de registros por página para obtener el total de páginas.
     *
     * @param string $busqueda Término de búsqueda.
     * @param string $estado Estado a filtrar ("pendiente", "completada", "cancelada" o "todas").
     * @param int $porPagina Número de registros por página.
     * @return int Total de páginas calculado.
     */
    public function obtenerTotalPaginas(string $busqueda = '', string $estado = 'pendiente', int $porPagina = 10): int
    {
        // Iniciar el query builder sobre la tabla "ordenes" con alias para mayor claridad
        $builder = $this->db->table($this->table . ' AS ordenes');

        // Join con la tabla de usuarios para filtrar por nombre o apellido
        $builder->join('usuarios', 'usuarios.id = ordenes.usuario_id', 'left');

        // Join con la tabla de usuarios para filtrar por nombre o apellido
        $builder->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id', 'left');

        // Aplicar filtro de búsqueda
        if (!empty($busqueda)) {
            $builder->groupStart()
                ->like('CAST(ordenes.id AS CHAR)', $busqueda)
                ->orLike('usuarios.nombre', $busqueda)
                ->orLike('usuarios.apellido', $busqueda)
                ->groupEnd();
        }

        // Filtrar por estado si no es "todas"
        if ($estado !== 'todas') {
            $builder->where('ordenes.estado', $estado);
        }

        // Contar el total de registros filtrados
        $totalRegistros = $builder->countAllResults();

        return (int) ceil($totalRegistros / $porPagina);
    }

    /**
     * Obtiene las órdenes filtradas y paginadas según el estado, un término de búsqueda y el ID del cliente.
     *
     * Realiza un join con las tablas "usuarios" y "direcciones" para obtener información adicional del cliente
     * y de la dirección de envío. La búsqueda se puede realizar tanto por el ID de la orden (si el término es numérico)
     * como por el nombre o apellido del cliente.
     *
     * - Si el parámetro $estado es distinto de "todas", se filtran las órdenes según ese estado.
     * - Si se proporciona un término de búsqueda en $busqueda, se agrupan las condiciones para:
     *      - Buscar por un ID exacto de la orden (si $busqueda es numérico).
     *      - Buscar por coincidencias parciales en los campos "nombre" o "apellido" del cliente.
     * - Solo se obtienen las órdenes cuyo usuario_id coincida con $clienteId.
     * - Los resultados se ordenan por fecha de creación en orden descendente y se paginan.
     *
     * @param string $estado    Estado a filtrar (por ejemplo: "pendiente", "completada", "cancelada" o "todas").
     * @param string $busqueda  Término de búsqueda (parte del ID de la orden o del nombre/apellido del cliente).
     * @param int    $pagina    Número de página actual.
     * @param int    $porPagina Número de registros por página.
     * @param int    $clienteId ID del cliente.
     * @return array            Array de órdenes filtradas y paginadas.
     */
    public function obtenerOrdenesFiltradasCliente(string $estado = 'todas', string $busqueda = '', int $pagina = 1, int $porPagina = 10, int $clienteId)
    {
        // Inicializar el query builder para la tabla "ordenes"
        $builder = $this->builder();

        // Seleccionar campos específicos de las tablas involucradas
        $builder->select('
        ordenes.id,
        ordenes.estado AS orden_estado,
        ordenes.total,
        ordenes.created_at,
        usuarios.nombre AS nombre_cliente,
        usuarios.apellido AS apellido_cliente,
        direcciones.calle,
        direcciones.numero,
        direcciones.ciudad,
        direcciones.provincia
    ');

        // Unir la tabla "usuarios" para obtener datos del cliente
        $builder->join('usuarios', 'usuarios.id = ordenes.usuario_id', 'left');

        // Unir la tabla "direcciones" para obtener la información de envío
        $builder->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id', 'left');

        // Filtrar solo las órdenes del cliente especificado
        $builder->where('ordenes.usuario_id', $clienteId);

        // Si se proporcionó un término de búsqueda, aplicar condiciones adicionales
        if (!empty($busqueda)) {
            if (is_numeric($busqueda)) {
                // Buscar por ID exacto si el término es numérico
                $builder->orWhere('ordenes.id', $busqueda);
            }
        }

        // Filtrar por estado si éste es distinto de "todas"
        if ($estado !== 'todas') {
            $builder->where('ordenes.estado', $estado);
        }

        // Ordenar los resultados por fecha de creación de forma descendente
        $builder->orderBy('ordenes.created_at', 'DESC');

        // Retornar los resultados paginados utilizando el método paginate de CodeIgniter 4
        return $this->paginate($porPagina, 'default', $pagina);
    }

    /**
 * Calcula el total de páginas para las órdenes filtradas de un cliente específico.
 *
 * Realiza la misma lógica de filtrado que en obtenerOrdenesFiltradas() y cuenta el total de registros,
 * luego divide el total entre el número de registros por página para obtener el total de páginas.
 *
 * @param string $busqueda Término de búsqueda.
 * @param string $estado   Estado a filtrar ("pendiente", "completada", "cancelada" o "todas").
 * @param int    $porPagina Número de registros por página.
 * @param int    $clienteId ID del cliente.
 * @return int              Número total de páginas.
 */
public function obtenerTotalPaginasCliente(string $busqueda = '', string $estado = 'todas', int $porPagina = 10, int $clienteId): int
{
    // Iniciar el query builder sobre la tabla "ordenes" con alias para mayor claridad
    $builder = $this->db->table($this->table . ' AS ordenes');

    // Join con la tabla de usuarios para obtener datos del cliente
    $builder->join('usuarios', 'usuarios.id = ordenes.usuario_id', 'left');

    // Join con la tabla de direcciones para obtener la información de envío
    $builder->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id', 'left');

    // Filtrar solo las órdenes del cliente especificado
    $builder->where('ordenes.usuario_id', $clienteId);

    // Aplicar filtro de búsqueda si se ha ingresado un término
    if (!empty($busqueda)) {
        $builder->groupStart()
                ->like('CAST(ordenes.id AS CHAR)', $busqueda)
                ->groupEnd();
    }

    // Filtrar por estado si no es "todas"
    if ($estado !== 'todas') {
        $builder->where('ordenes.estado', $estado);
    }

    // Contar el total de registros filtrados
    $totalRegistros = $builder->countAllResults();

    return (int) ceil($totalRegistros / $porPagina);
}

}
