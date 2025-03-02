<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\MensajeModel;

class ConversacionModel extends Model
{
    // Configuración básica del modelo
    protected $table         = 'conversaciones';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['usuario_id', 'nombre', 'email', 'asunto', 'tipo_conversacion', 'estado'];
    protected $returnType    = 'object';
    protected $useTimestamps = true; // Se encargará de 'created_at' y 'updated_at'
    protected $dateFormat    = 'datetime';

    // Reglas de validación para la conversación
    protected $validationRules = [
        'usuario_id'        => 'permit_empty|integer',
        'nombre'            => 'required|min_length[3]|max_length[255]',
        'email'             => 'required|valid_email|max_length[255]',
        'asunto'            => 'required|max_length[255]',
        'tipo_conversacion' => 'required|in_list[consulta,contacto]',
        'estado'            => 'required|in_list[abierta,cerrada]',
    ];

    // Mensajes personalizados para las validaciones
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 255 caracteres.',
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Debes ingresar un correo electrónico válido.',
            'max_length'  => 'El correo electrónico no puede superar los 255 caracteres.',
        ],
        'asunto' => [
            'required'   => 'El asunto es obligatorio.',
            'max_length' => 'El asunto no puede superar los 255 caracteres.',
        ],
        'tipo_conversacion' => [
            'required' => 'El tipo de conversación es obligatorio.',
            'in_list'  => 'El tipo debe ser "consulta" o "contacto".',
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list'  => 'El estado debe ser "abierta" o "cerrada".',
        ],
    ];

    /**
     * Instancia del modelo de mensajes para evitar múltiples instanciaciones.
     *
     * @var MensajeModel
     */
    protected $mensajeModel;

    /**
     * Constructor: se inicializa la instancia del MensajeModel.
     */
    public function __construct()
    {
        parent::__construct();
        $this->mensajeModel = new MensajeModel();
    }

    /**
     * Crea una nueva conversación.
     *
     * @param array $data Datos de la conversación a insertar.
     * @return int|false El ID de la conversación o false si falla la validación.
     */
    public function crearConversacion(array $data)
    {
        if (!$this->validate($data)) {
            // Opcional: Puedes registrar o retornar los errores para depurar.
            return false;
        }
        $this->insert($data);
        return $this->getInsertID();
    }

    /**
     * Obtiene una conversación y sus mensajes asociados, ordenados cronológicamente.
     *
     * @param int $conversacionId ID de la conversación.
     * @return object|null Objeto conversación con atributo "mensajes" o null si no se encuentra.
     */
    public function obtenerConversacionConMensajes(int $conversacionId)
    {
        $conversacion = $this->find($conversacionId);
        if ($conversacion) {
            $conversacion->mensajes = $this->mensajeModel
                ->where('conversacion_id', $conversacionId)
                ->orderBy('created_at', 'ASC')
                ->findAll();
        }
        return $conversacion;
    }

    /**
     * Obtiene las conversaciones asociadas a un cliente y carga sus mensajes.
     *
     * Para cada conversación se realiza una consulta al modelo de mensajes, de modo
     * que cada objeto conversación contendrá una propiedad "mensajes" con un array
     * de todos los mensajes ordenados por fecha de creación (ascendente).
     *
     * @param int $clienteId ID del cliente.
     * @return array Lista de objetos conversación con la propiedad "mensajes".
     */
    public function obtenerConversacionesClienteConMensajes(int $clienteId): array
    {
        // Obtener todas las conversaciones del cliente ordenadas por fecha de actualización
        $conversaciones = $this->where('usuario_id', $clienteId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        // Instanciar el modelo de mensajes
        $mensajeModel = new \App\Models\MensajeModel();

        // Para cada conversación, agregar la propiedad 'mensajes'
        foreach ($conversaciones as $conversacion) {
            $conversacion->mensajes = $mensajeModel->where('conversacion_id', $conversacion->id)
                ->orderBy('created_at', 'ASC')
                ->findAll();
        }

        return $conversaciones;
    }

    /**
     * Trae las conversaciones filtradas según el tipo de conversación.
     *
     * @param string $tipo Tipo de conversación ('consulta' o 'contacto').
     * @return array Lista de objetos conversación.
     */
    public function traerConversacionesSegunTipo(string $tipo): array
    {
        return $this->where('tipo_conversacion', $tipo)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Actualiza el estado de una conversación.
     *
     * @param int|string $conversacionId ID de la conversación a actualizar.
     * @param string $nuevoEstado Nuevo estado ('abierta' o 'cerrada').
     * @return bool|int Resultado de la operación update.
     */
    public function actualizarEstadoConversacion($conversacionId, string $nuevoEstado)
    {
        // Validamos que el nuevo estado esté entre los permitidos.
        if (!in_array($nuevoEstado, ['abierta', 'cerrada'])) {
            return false;
        }
        return $this->update($conversacionId, ['estado' => $nuevoEstado]);
    }

    /**
     * Filtra las conversaciones de tipo "contacto" según texto, estado y página.
     *
     * Parámetros para $estado:
     * - 'todas': sin filtro por estado.
     * - 'pendiente': conversaciones abiertas.
     * - 'cerrada': conversaciones cerradas.
     *
     * @param string $texto Texto a buscar en nombre o asunto.
     * @param string $estado Estado ('todas', 'pendiente' o 'cerrada').
     * @param int $pagina Número de página.
     * @return array Lista de conversaciones de tipo "contacto".
     */
    public function filtrarConversacionesContacto(string $texto, string $estado, int $pagina): array
    {
        $builder = $this->builder();

        // Filtro por tipo de conversación (contacto)
        $builder->where('tipo_conversacion', 'contacto');

        // Filtrado por estado
        if ($estado !== 'todas') {
            if ($estado === 'pendiente') {
                $builder->where('estado', 'abierta');
            } elseif ($estado === 'cerrada') {
                $builder->where('estado', 'cerrada');
            }
        }

        // Filtro por texto en nombre o asunto
        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        // Orden y paginación
        $builder->orderBy('created_at', 'DESC');
        $porPagina = 10;
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtiene el número total de páginas para las conversaciones filtradas.
     *
     * @param string $texto Texto a buscar en nombre o asunto.
     * @param string $estado Estado del filtro ('todas', 'pendiente', 'respondida' o 'cerrada').
     * @param int $porPagina Número de registros por página.
     * @param string $tipo Tipo de conversación ('consulta' o 'contacto').
     * @return int Número total de páginas.
     */
    public function obtenerTotalPaginasConversacionesContacto(string $texto, string $estado, int $porPagina): int
    {
        $builder = $this->builder();

        // Filtro por tipo de conversación (contacto)
        $builder->where('tipo_conversacion', 'contacto');

        if ($estado !== 'todas') {
            if ($estado === 'pendiente') {
                $estado = 'abierta';
            } elseif ($estado === 'cerrada') {
                $estado = 'cerrada';
            }
            $builder->where('estado', $estado);
        }

        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults();
        return (int) ceil($total / $porPagina);
    }

    /**
     * Filtra las conversaciones de tipo "consulta" según texto, estado y página.
     *
     * Parámetros para $estado:
     * - "todas": Devuelve todas las conversaciones de tipo "consulta" sin filtrar por último mensaje.
     * - "pendiente": Conversaciones abiertas (estado "abierta") cuyo último mensaje es del cliente.
     * - "respondida": Conversaciones abiertas (estado "abierta") cuyo último mensaje es del administrador.
     * - "cerrada" o "eliminada": Conversaciones con estado "cerrada".
     *
     * Además, se aplica un filtro de búsqueda en los campos "nombre" y "asunto".
     *
     * @param string $texto     Término de búsqueda para "nombre" o "asunto".
     * @param string $estado    Filtro de estado ("todas", "pendiente", "respondida", "cerrada" o "eliminada").
     * @param int $pagina       Número de página.
     * @param int $porPagina    Número de registros por página (por defecto 10).
     * @return array            Lista de conversaciones de tipo "consulta" que cumplen los filtros.
     */
    public function filtrarConversacionesConsulta(string $texto, string $estado, int $pagina, $porPagina = 10): array
    {
        $builder = $this->builder();

        // Filtro por tipo de conversación (contacto)
        $builder->where('tipo_conversacion', 'consulta');

        // Filtrado por estado
        if ($estado !== 'todas') {
            if ($estado === 'pendiente' || $estado === 'respondida') {
                $builder->where('estado', 'abierta');
            } elseif ($estado === 'eliminada') {
                $builder->where('estado', 'cerrada');
            }
        }

        // Filtro por texto en nombre o asunto
        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        // Orden y paginación
        $builder->orderBy('updated_at', 'DESC');
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtiene el número total de páginas para las conversaciones filtradas.
     *
     * @param string $texto Texto a buscar en nombre o asunto.
     * @param string $estado Estado del filtro ('todas', 'pendiente', 'respondida' o 'cerrada').
     * @param int $porPagina Número de registros por página.
     * @param string $tipo Tipo de conversación ('consulta' o 'contacto').
     * @return int Número total de páginas.
     */
    public function obtenerTotalPaginasConversacionesConsulta(string $texto, string $estado, int $porPagina): int
    {
        $builder = $this->builder();

        // Filtro por tipo de conversación (contacto)
        $builder->where('tipo_conversacion', 'consulta');

        if ($estado !== 'todas') {
            if ($estado === 'pendiente' || $estado === 'respondida') {
                $estado = 'abierta';
            } elseif ($estado === 'cerrada') {
                $estado = 'cerrada';
            }
            $builder->where('estado', $estado);
        }

        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults();
        return (int) ceil($total / $porPagina);
    }

    /**
     * Cuenta la cantidad de conversaciones para un tipo y estado específico.
     *
     * @param string $tipo Tipo de conversación ('consulta' o 'contacto').
     * @param string $estado Estado ('abierta' o 'cerrada').
     * @return int Total de conversaciones que cumplen los criterios.
     */
    public function contarConversacionesPorTipoYEstado(string $tipo, string $estado): int
    {
        return $this->where('tipo_conversacion', $tipo)
            ->where('estado', $estado)
            ->countAllResults();
    }

    /**
     * Filtra las conversaciones de tipo "consulta" para un cliente específico, 
     * aplicando un filtro por texto, estado y paginación.
     *
     * @param string $textoBusqueda Término de búsqueda para "asunto" o "nombre".
     * @param string $estado        Filtro de estado ("todas", "activa" o "inactiva").
     * @param int    $pagina        Número de página.
     * @param int    $clienteId     ID del cliente.
     * @return array                Lista de conversaciones (con sus mensajes) que cumplen los filtros.
     */
    public function filtrarConversacionesCliente(string $textoBusqueda, string $estado, int $pagina, int $porPagina = 10, int $clienteId): array
    {
        $builder = $this->builder();

        // Filtrar por cliente y por tipo de conversación "consulta"
        $builder->where('usuario_id', $clienteId)
            ->where('tipo_conversacion', 'consulta');

        // Filtrado por estado
        if ($estado !== 'todas') {
            if ($estado === 'pendiente' || $estado === 'respondida') {
                $builder->where('estado', 'abierta');
            } elseif ($estado === 'eliminada') {
                $builder->where('estado', 'cerrada');
            }
        }

        // Filtro por texto en campos "asunto" o "nombre"
        if (!empty($textoBusqueda)) {
            $builder->groupStart();
            $builder->like('asunto', $textoBusqueda);
            $builder->groupEnd();
        }

        // Ordenar por fecha de actualización (más recientes primero)
        $builder->orderBy('updated_at', 'DESC');

        // Configuración de paginación (fijamos 10 registros por página)
        $porPagina = 10;
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        $query = $builder->get();
        $conversaciones = $query->getResult();

        // Para cada conversación, cargar sus mensajes ordenados por fecha de creación (ascendente)
        $mensajeModel = new \App\Models\MensajeModel();
        foreach ($conversaciones as $conv) {
            $conv->mensajes = $mensajeModel->where('conversacion_id', $conv->id)
                ->orderBy('created_at', 'ASC')
                ->findAll();
        }

        return $conversaciones;
    }

    /**
     * Obtiene el número total de páginas para las conversaciones de tipo "consulta"
     * de un cliente específico, filtradas según un texto y estado.
     *
     * @param string $textoBusqueda Término de búsqueda en "asunto" o "nombre".
     * @param string $estado        Filtro de estado ("todas", "activa" o "inactiva").
     * @param int    $porPagina     Número de registros por página.
     * @param int    $clienteId     ID del cliente.
     * @return int                  Número total de páginas.
     */
    public function obtenerTotalPaginasConversacionesCliente(string $textoBusqueda, string $estado, int $porPagina, int $clienteId): int
    {
        $builder = $this->builder();

        // Filtrar por cliente y tipo de conversación "consulta"
        $builder->where('usuario_id', $clienteId)
            ->where('tipo_conversacion', 'consulta');

        if ($estado !== 'todas') {
            $builder->where('estado', $estado);
        }

        if (!empty($textoBusqueda)) {
            $builder->groupStart();
            $builder->like('asunto', $textoBusqueda);
            $builder->groupEnd();
        }

        $total = $builder->countAllResults();
        return (int) ceil($total / $porPagina);
    }
}
