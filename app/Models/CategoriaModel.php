<?php

namespace App\Models;

use CodeIgniter\Model;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CategoriaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    // Validación de datos (opcional)
    protected $validationRules    = [
        'nombre'      => 'required|min_length[3]|max_length[255]',
        'descripcion' => 'permit_empty',
        'estado'      => 'in_list[activo,inactivo]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre de la categoría es obligatorio.',
            'min_length' => 'El nombre de la categoría debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre de la categoría no puede superar los 255 caracteres.',
        ],
        'estado' => [
            'in_list' => 'El estado de la categoría debe ser "activo" o "inactivo".',
        ],
    ];

    // Relación con productos
    public function productos()
    {
        return $this->hasMany(ProductoModel::class, 'categoria_id');
    }

    // Crear una categoria
    public function crearCategoria($data)
    {
        $data['estado'] = 'activo'; // Asignar estado 'activo' por defecto
        if (!$this->validate($data)) {
            return false;
        }

        return $this->save($data);
    }

    // Actualizar datos de categoria
    public function actualizarCategoria($id, $data)
    {
        if (!$this->validate($data)) {
            return false;
        }

        $data['estado'] = 'activo';
        return $this->update($id, $data);
    }

    // Listar las Categoria en orden descendente por fecha de modificacion
    public function obtenerCategoriasPorModificacion()
    {
        return $this->orderBy('updated_at', 'DESC')->findAll();
    }

    // Eliminar Categoria (dar de baja -> estado == 'inactivo')
    public function eliminarCategoria($id)
    {
        $data['estado'] = 'inactivo';

        return $this->update($id, $data);
    }

    // Listar las Categorias en base a un estado en especifio y ordenarlas por fecha de ultima modificacion
    public function obtenerCategoriasPorEstado($estado)
    {
        return $this->orderBy('updated_at', 'DESC')->where($estado, 'estado')->findAll();
    }

    // Obtener marcas con paginación y filtros
    public function obtenerCategoriasFiltradas($estado = 'todos', $busqueda = '', $perPage = 10)
    {
        // Limpiar cualquier consulta anterior
        $this->builder()->resetQuery();

        // Si hay término de búsqueda, aplicar la búsqueda primero
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('nombre', '%' . $busqueda . '%')
                ->orLike('descripcion', '%' . $busqueda . '%')
                ->groupEnd();
        }

        // Aplicar el filtro de estado después de la búsqueda
        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        // Aplicar el ordenamiento al final
        return $this->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Filtra las categorías según texto de búsqueda, estado y página.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado de las categorías ('activo', 'inactivo' o 'todos').
     * @param int $pagina Número de página.
     * @param int $porPagina Cantidad de registros por página.
     * @return array Lista de categorías filtradas y paginadas.
     */
    public function filtrarCategorias($texto = '', $estado = 'todos', $pagina = 1, $porPagina = 10)
    {
        // Iniciar la consulta
        $builder = $this->db->table($this->table);

        // Aplicar filtro de texto (búsqueda)
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

        // Ordenar por 'updated_at' en orden descendente
        $builder->orderBy('updated_at', 'DESC');

        // Paginación
        $offset = ($pagina - 1) * $porPagina; // Calcular el offset
        $builder->limit($porPagina, $offset);

        // Ejecutar la consulta y obtener los resultados
        $query = $builder->get();
        return $query->getResultArray();
    }

    /**
     * Obtiene el total de páginas para los filtros aplicados.
     *
     * @param string $texto Texto de búsqueda.
     * @param string $estado Estado de las categorías ('activo', 'inactivo' o 'todos').
     * @param int $porPagina Cantidad de registros por página.
     * @return int Total de páginas.
     */
    public function obtenerTotalPaginas($texto = '', $estado = 'todos', $porPagina = 10)
    {
        // Iniciar la consulta
        $builder = $this->db->table($this->table);

        // Aplicar filtro de texto (búsqueda)
        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto) // Buscar en el campo 'nombre'
                ->orLike('descripcion', $texto) // Buscar en el campo 'descripcion'
                ->groupEnd();
        }

        // Aplicar filtro de estado
        if ($estado !== 'todos') {
            $builder->where('estado', $estado); // Filtrar por estado
        }

        // Obtener el total de registros que coinciden con los filtros
        $totalRegistros = $builder->countAllResults();

        // Calcular el total de páginas
        return ceil($totalRegistros / $porPagina);
    }
}
