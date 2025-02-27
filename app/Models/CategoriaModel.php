<?php

namespace App\Models;

use CodeIgniter\Model;

/** LISTO
 * Modelo para gestionar las Categorías de productos.
 *
 * Este modelo permite crear, actualizar, dar de baja (eliminar) y filtrar categorías.
 * Además, define las reglas de validación, mensajes personalizados y una relación (ilustrativa)
 * con los productos.
 *
 * @package App\Models
 */
class CategoriaModel extends Model
{
    // Configuración básica del modelo
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    // Reglas de validación
    protected $validationRules = [
        'nombre'      => 'required|min_length[3]|max_length[255]',
        'descripcion' => 'permit_empty',
        'estado'      => 'in_list[activo,inactivo]',
    ];

    // Mensajes personalizados para la validación
    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la categoría es obligatorio.',
            'min_length' => 'El nombre de la categoría debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre de la categoría no puede superar los 255 caracteres.',
        ],
        'estado' => [
            'in_list'    => 'El estado de la categoría debe ser "activo" o "inactivo".',
        ],
    ];

    /**
     * Relación con productos.
     *
     * Retorna los productos asociados a esta categoría.
     * Nota: CodeIgniter 4 no implementa relaciones nativas; este método es ilustrativo.
     *
     * @return mixed
     */
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'categoria_id');
    }

    /**
     * Crea una nueva categoría.
     *
     * Establece el estado por defecto en "activo" y valida los datos.
     * Retorna el ID de la categoría creada o false si falla la validación.
     *
     * @param array $data Datos de la categoría.
     * @return bool|int
     */
    public function crearCategoria(array $data)
    {
        // Asigna estado activo por defecto
        $data['estado'] = 'activo';

        if (!$this->validate($data)) {
            return false;
        }

        // Save inserta el registro y retorna el ID
        return $this->save($data);
    }

    /**
     * Actualiza una categoría existente.
     *
     * Valida los datos y, de ser válidos, actualiza la categoría. Se fuerza el estado "activo".
     *
     * @param int|string $id ID de la categoría.
     * @param array $data Datos actualizados.
     * @return bool
     */
    public function actualizarCategoria($id, array $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        // Forzar estado activo en la actualización
        $data['estado'] = 'activo';

        return $this->update($id, $data);
    }

    /**
     * Elimina (da de baja) una categoría.
     *
     * En lugar de eliminar físicamente el registro, se actualiza su estado a "inactivo".
     *
     * @param int|string $id ID de la categoría.
     * @return bool
     */
    public function eliminarCategoria($id)
    {
        $data['estado'] = 'inactivo';
        return $this->update($id, $data);
    }

    /**
     * Obtiene las categorías filtradas y paginadas utilizando la paginación nativa de CodeIgniter.
     *
     * Aplica filtros de búsqueda en los campos 'nombre' y 'descripcion', y filtra por estado
     * (si no es "todos"). La paginación se realiza utilizando paginate(), que toma el número de registros
     * por página, el grupo (por defecto 'default') y la página actual ($pagina).
     *
     * @param string $estado Estado a filtrar ("activo", "inactivo" o "todos").
     * @param string $busqueda Texto de búsqueda.
     * @param int $pagina Página actual.
     * @param int $perPage Número de registros por página.
     * @return mixed Array de categorías paginadas; el pager se configura automáticamente.
     */
    public function obtenerCategoriasFiltradas(string $estado = 'todos', string $busqueda = '', int $pagina = 1, int $perPage = 10)
    {
        // Reiniciar el query builder para evitar interferencias de consultas previas
        $this->builder()->resetQuery();

        // Aplicar filtro de búsqueda si se proporciona
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('descripcion', $busqueda)
                ->groupEnd();
        }

        // Aplicar filtro de estado si no es "todos"
        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        // Ordenar por 'updated_at' en orden descendente y paginar,
        // pasando $pagina como la página actual a mostrar.
        return $this->orderBy('updated_at', 'DESC')
            ->paginate($perPage, 'default', $pagina);
    }

    /**
     * Calcula el total de páginas para los filtros aplicados.
     *
     * Cuenta los registros que coinciden con el texto de búsqueda y el estado, y
     * divide el total entre el número de registros por página.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado ("activo", "inactivo" o "todos").
     * @param int $porPagina Cantidad de registros por página.
     * @return int Total de páginas.
     */
    public function obtenerTotalPaginas(string $texto = '', string $estado = 'todos', int $porPagina = 10): int
    {
        $builder = $this->db->table($this->table);

        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('descripcion', $texto)
                ->groupEnd();
        }

        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        $totalRegistros = $builder->countAllResults();
        return ceil($totalRegistros / $porPagina);
    }

    /**
     * Obtiene las categorías que tienen productos activos en stock.
     *
     * Este método consulta la base de datos para obtener todas las categorías relacionadas con productos
     * que están en estado "activo" y que tienen stock mayor a 0. Se efectúa un join con la tabla "productos"
     * y se agrupa por el ID de la categoría para evitar registros duplicados.
     *
     * @return array Lista de categorías con productos activos.
     */
    public function obtenerCategoriasConProductosActivos()
    {
        return $this->select('categorias.*')          // Selecciona todos los campos de la tabla "categorias"
            ->join('productos', 'productos.categoria_id = categorias.id')  // Realiza el join con la tabla "productos" usando la relación de categorías
            ->where('productos.estado', 'activo')  // Filtra para obtener solo productos activos
            ->where('productos.stock >', 0)        // Filtra para obtener solo productos que tengan stock mayor a 0
            ->groupBy('categorias.id')             // Agrupa por ID de categoría para evitar duplicados en el resultado
            ->findAll();                           // Retorna todos los registros obtenidos
    }
}
