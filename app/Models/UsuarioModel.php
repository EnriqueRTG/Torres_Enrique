<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of UsuarioModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'password', 'rol', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';



    // Métodos personalizados

    // Buscar usuario por email
    public function encontrarPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // Verificar si la contraseña es correcta
    public function verificarPassword($passwordIngresada, $passwordHash)
    {
        return password_verify($passwordIngresada, $passwordHash);
    }

    // Encriptar la contraseña del usuario
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Obtener todos los usuarios activos
    public function traerUsuariosActivos()
    {
        return $this->where('estado', 'activo')->findAll();
    }

    // Obtener los Clientes Activos
    public function traerClientesActivos()
    {
        return $this->where('estado', 'activo')
            ->where('rol', 'cliente')
            ->findAll();
    }

    // Obtener todos los usuarios administradores
    public function traerAdministradores()
    {
        return $this->where('rol', 'administrador')->findAll();
    }

    /* =========================================================================
       MÉTODOS PARA FILTRAR Y PAGINAR CLIENTES (ROL 'cliente')
       ========================================================================= */

    /**
     * Filtra los clientes en base a un término de búsqueda, estado, página y cantidad por página.
     *
     * @param string $texto Texto de búsqueda (se buscará en nombre, apellido y email).
     * @param string $estado Estado del cliente ('activo', 'inactivo' o 'todos').
     * @param int $pagina Número de la página actual.
     * @param int $porPagina Número de registros por página.
     * @return array Lista de clientes filtrados (arreglo de arrays).
     */
    public function filtrarClientes($texto = '', $estado = 'todos', $pagina = 1, $porPagina = 10)
    {
        // Inicia la consulta sobre la tabla de usuarios
        $builder = $this->db->table($this->table);
        // Filtrar solo los usuarios con rol 'cliente'
        $builder->where('rol', 'cliente');

        // Aplicar filtro de búsqueda si se proporcionó texto
        if (!empty($texto)) {
            $builder->groupStart()
                ->like('nombre', $texto)
                ->orLike('apellido', $texto)
                ->orLike('email', $texto)
                ->groupEnd();
        }


        // Filtrar por estado, si no se quiere mostrar "todos"
        if ($estado !== 'todos') {
            $builder->where('estado', $estado);
        }

        // Ordenar por la fecha de última actualización en orden descendente
        $builder->orderBy('updated_at', 'DESC');

        // Calcular el offset y limitar la cantidad de resultados
        $offset = ($pagina - 1) * $porPagina;
        $builder->limit($porPagina, $offset);

        // Ejecutar la consulta y devolver los resultados como un array asociativo
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
     * Obtiene los clientes filtrados utilizando el método de paginación de CodeIgniter.
     *
     * Este método es útil si deseas aprovechar la paginación automática que ofrece CodeIgniter.
     *
     * @param string $estado Estado de los clientes ('activo', 'inactivo' o 'todos').
     * @param string $busqueda Texto de búsqueda.
     * @param int $perPage Número de registros por página.
     * @return mixed Lista paginada de clientes.
     */
    public function obtenerClientesFiltrados($estado = 'todos', $busqueda = '', $perPage = 10)
    {
        // Filtrar solo clientes
        $this->where('rol', 'cliente');

        // Si se proporciona texto de búsqueda, aplicarlo
        if (!empty($busqueda)) {
            $this->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('apellido', $busqueda)
                ->orLike('email', $busqueda)
                ->groupEnd();
        }

        // Aplicar filtro de estado si no se desea mostrar "todos"
        if ($estado !== 'todos') {
            $this->where('estado', $estado);
        }

        // Ordenar por fecha de actualización descendente y aplicar la paginación
        return $this->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }
}
