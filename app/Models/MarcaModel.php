<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para gestionar las marcas de productos.
 *
 * Este modelo administra la creación, actualización, eliminación (dar de baja)
 * y filtrado de marcas. Además, define las reglas de validación y las relaciones (por ejemplo,
 * la relación con productos, si se utiliza).
 *
 * @package App\Models
 */
class MarcaModel extends Model
{
    // Configuración básica del modelo
    protected $table            = 'marcas';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    // Reglas de validación
    protected $validationRules = [
        'nombre'      => 'required|min_length[3]|max_length[255]',
        'descripcion' => 'permit_empty', // Campo opcional
        'estado'      => 'in_list[activo,inactivo]',
    ];

    // Mensajes personalizados para validaciones
    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre de la marca es obligatorio.',
            'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
            'max_length'  => 'El nombre no puede tener más de 255 caracteres.',
        ],
        'estado' => [
            'in_list'     => 'El estado debe ser "activo" o "inactivo".',
        ],
    ];

    /**
     * Relación con productos.
     * (Requiere que exista el modelo ProductoModel y la columna "marca_id" en la tabla de productos)
     *
     * @return \CodeIgniter\Model
     */
    public function productos()
    {
        // Nota: CodeIgniter 4 no tiene relaciones nativas; este método es ilustrativo si utilizas algún ORM adicional.
        return $this->hasMany(ProductoModel::class, 'marca_id');
    }

    /**
     * Crea una nueva marca.
     *
     * Asigna por defecto el estado "activo" y valida los datos. Si la validación falla,
     * retorna false.
     *
     * @param array $data Datos de la marca.
     * @return bool|int ID de la marca creada o false en caso de error.
     */
    public function crearMarca(array $data)
    {
        // Asigna estado activo por defecto
        $data['estado'] = 'activo';

        if (!$this->validate($data)) {
            return false;
        }

        // Se utiliza save() que inserta o actualiza según corresponda.
        return $this->save($data);
    }

    /**
     * Actualiza los datos de una marca existente.
     *
     * Valida los datos y, de ser válidos, actualiza la marca con el estado "activo" por defecto.
     *
     * @param int|string $id Identificador de la marca.
     * @param array $data Datos a actualizar.
     * @return bool True si la actualización fue exitosa, false de lo contrario.
     */
    public function actualizarMarca($id, array $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        // Se fuerza el estado activo al actualizar (puedes modificar esta lógica si es necesario)
        $data['estado'] = 'activo';

        return $this->update($id, $data);
    }

    /**
     * Elimina (da de baja) una marca.
     *
     * Se actualiza el estado a "inactivo", en lugar de eliminar físicamente el registro.
     *
     * @param int|string $id Identificador de la marca.
     * @return bool True si la operación fue exitosa, false de lo contrario.
     */
    public function eliminarMarca($id)
    {
        $data['estado'] = 'inactivo';
        return $this->update($id, $data);
    }

    /**
     * Obtiene las marcas filtradas y paginadas utilizando la paginación nativa de CodeIgniter.
     *
     * Este método aplica filtros de búsqueda en los campos "nombre" y "descripcion", y filtra
     * por el estado de la marca (si no es "todos"). Luego, ordena los resultados por "updated_at"
     * en forma descendente y utiliza el método paginate() para retornar los resultados paginados.
     *
     * @param string $estado   Estado a filtrar ("activo", "inactivo" o "todos").
     * @param string $busqueda Texto de búsqueda.
     * @param int $pagina      Página actual a mostrar.
     * @param int $perPage     Número de registros por página.
     * @return mixed           Array de marcas paginadas; el pager se configura automáticamente.
     */
    public function obtenerMarcasFiltradas(string $estado = 'todos', string $busqueda = '', int $pagina = 1, int $perPage = 10)
    {
        // Reinicia el query builder para evitar interferencias de consultas previas
        $this->builder()->resetQuery();

        // Aplica filtro de búsqueda si se proporciona
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('descripcion', $busqueda)
                ->groupEnd();
        }

        // Aplica filtro de estado si no es "todos"
        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        // Ordena por 'updated_at' en forma descendente y pagina,
        // pasando $pagina como la página actual; el grupo de paginación se deja por defecto ("default").
        return $this->orderBy('updated_at', 'DESC')
            ->paginate($perPage, 'default', $pagina);
    }


    /**
     * Obtiene el total de páginas para los filtros aplicados.
     *
     * Calcula el total de registros que coinciden con los filtros y divide entre $porPagina.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado ("activo", "inactivo" o "todos").
     * @param int $porPagina Cantidad de registros por página.
     * @return int Total de páginas.
     */
    public function obtenerTotalPaginas(string $texto = '', string $estado = 'todos', int $porPagina = 10): int
    {
        $builder = $this->db->table($this->table);

        // Aplicar búsqueda en "nombre" y "descripcion"
        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('descripcion', $texto)
                ->groupEnd();
        }

        // Aplicar filtro de estado
        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        $totalRegistros = $builder->countAllResults();
        return ceil($totalRegistros / $porPagina);
    }
}
