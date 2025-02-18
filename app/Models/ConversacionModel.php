<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\MensajeModel;

class ConversacionModel extends Model
{
    protected $table         = 'conversaciones';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['usuario_id', 'nombre', 'email', 'asunto', 'tipo_conversacion', 'estado'];
    protected $returnType    = 'object';
    protected $useTimestamps = true; // Habilita created_at y updated_at
    protected $dateFormat    = 'datetime';

    // Reglas de validación para la conversación
    protected $validationRules = [
        'usuario_id'           => 'permit_empty|integer',
        'nombre'               => 'required|min_length[3]|max_length[255]',
        'email'                => 'required|valid_email|max_length[255]',
        'asunto'               => 'required|max_length[255]',
        'tipo_conversacion'    => 'required|in_list[consulta,contacto]',
        'estado'               => 'required|in_list[abierto,cerrado]',
    ];

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
            'in_list'  => 'El estado debe ser "abierto" o "cerrado".',
        ],
    ];

    /**
     * Crea una nueva conversación.
     *
     * @param array $data Datos de la conversación a insertar.
     * @return int|false El ID de la conversación o false si falla la validación.
     */
    public function crearConversacion(array $data)
    {
        if (!$this->validate($data)) {
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
    public function obtenerConversacionConMensajes($conversacionId)
    {
        $conversacion = $this->find($conversacionId);
        if ($conversacion) {
            // Instanciamos el modelo de mensajes para recuperar los mensajes de la conversación
            $mensajeModel = new MensajeModel();
            $conversacion->mensajes = $mensajeModel->where('conversacion_id', $conversacionId)
                ->orderBy('created_at', 'ASC')
                ->findAll();
        }
        return $conversacion;
    }

    /**
     * Obtiene las conversaciones asociadas a un cliente específico.
     *
     * @param int $clienteId ID del cliente.
     * @return array Arreglo de objetos conversación.
     */
    public function obtenerConversacionesCliente($clienteId)
    {
        return $this->where('usuario_id', $clienteId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    /**
     * Trae las conversaciones filtradas según el tipo de conversación.
     *
     * @param string $tipo El tipo de conversación a filtrar (por ejemplo, 'consulta' o 'contacto').
     * @return array Arreglo de objetos conversación filtrados por el tipo indicado.
     */
    public function traerConversacionesSegunTipo($tipo)
    {
        return $this->where('tipo_conversacion', $tipo)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Actualiza el estado de una conversación en la base de datos.
     *
     * Este método recibe el identificador de la conversación y el nuevo estado,
     * y utiliza el método update del modelo para modificar el campo "estado" del registro correspondiente.
     *
     * @param int|string $conversacionId El ID de la conversación a actualizar.
     * @param string $nuevoEstado El nuevo estado que se asignará a la conversación.
     *                            Por ejemplo: 'abierto' o 'cerrado'.
     * @return bool|int Retorna el resultado de la operación update:
     *                  - Retorna true/1 si la actualización se realizó correctamente.
     *                  - Retorna false/0 si ocurrió algún error.
     */
    public function actualizarEstadoConversacion($conversacionId, $nuevoEstado)
    {
        // Actualiza el campo 'estado' de la conversación identificada por $conversacionId.
        return $this->update($conversacionId, ['estado' => $nuevoEstado]);
    }


    /**
     * Filtra las conversaciones según el texto de búsqueda, estado, página y tipo de conversación.
     *
     * @param string $texto  Texto a buscar en el nombre y asunto.
     * @param string $estado Estado a filtrar ('todos', 'pendiente' o 'respondido').
     * @param int $pagina    Número de página actual (para la paginación).
     * @param string $tipo   Tipo de conversación ('consulta' o 'contacto').
     * @return array         Arreglo de objetos con las conversaciones filtradas.
     */
    public function filtrarConversaciones(string $texto, string $estado, int $pagina, string $tipo)
    {
        // Obtener el objeto query builder para la tabla actual.
        $builder = $this->builder();

        // Filtrar por tipo de conversación.
        if (!empty($tipo)) {
            $builder->where('tipo_conversacion', $tipo);
        }

        // Filtrar por estado, solo si se especifica algo distinto de 'todos'.
        // Convertimos el filtro visual:
        // 'pendiente' se corresponde con 'abierto'
        // 'respondido' se corresponde con 'cerrado'
        if ($estado !== 'todos') {
            if ($estado === 'pendiente') {
                $estado = 'abierto';
            } elseif ($estado === 'respondido') {
                $estado = 'cerrado';
            }
            $builder->where('estado', $estado);
        }

        // Filtrar por búsqueda en los campos "nombre" y "asunto".
        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        // Ordenar los resultados de forma descendente por fecha de creación.
        $builder->orderBy('created_at', 'DESC');

        // Aplicar paginación.
        $porPagina = 10; // Número de registros por página.
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        // Ejecutar la consulta y retornar los resultados.
        $query = $builder->get();
        return $query->getResult();
    }

    /**
     * Obtiene el número total de páginas para las conversaciones filtradas.
     *
     * Se cuenta el total de registros que cumplen con los filtros y se divide entre
     * la cantidad de registros por página.
     *
     * @param string $texto     Texto a buscar en el nombre y asunto.
     * @param string $estado    Estado a filtrar ('todos', 'pendiente' o 'respondido').
     * @param int $porPagina    Número de registros por página.
     * @param string $tipo      Tipo de conversación ('consulta' o 'contacto').
     * @return int              Número total de páginas.
     */
    public function obtenerTotalPaginasConversaciones(string $texto, string $estado, int $porPagina, string $tipo)
    {
        // Obtener el objeto query builder para la tabla actual.
        $builder = $this->builder();

        // Filtrar por tipo de conversación.
        if (!empty($tipo)) {
            $builder->where('tipo_conversacion', $tipo);
        }

        // Filtrar por estado, solo si no es 'todos'.
        if ($estado !== 'todos') {
            if ($estado === 'pendiente') {
                $estado = 'abierto';
            } elseif ($estado === 'respondido') {
                $estado = 'cerrado';
            }
            $builder->where('estado', $estado);
        }

        // Filtrar por búsqueda en "nombre" y "asunto".
        if (!empty($texto)) {
            $builder->groupStart();
            $builder->like('nombre', $texto);
            $builder->orLike('asunto', $texto);
            $builder->groupEnd();
        }

        // Contar todos los registros que cumplen con las condiciones.
        $total = $builder->countAllResults();

        // Calcular el total de páginas (redondeando hacia arriba).
        $totalPaginas = (int) ceil($total / $porPagina);
        return $totalPaginas;
    }
}
