<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

/**
 * Controlador para la gestión de Categorías.
 *
 * Este controlador administra la visualización, creación, actualización, eliminación
 * y filtrado de categorías para la vista de administración.
 *
 * @package App\Controllers\Admin
 */
class Categoria extends BaseController
{
    /**
     * Instancia del modelo de Categorías.
     *
     * @var CategoriaModel
     */
    protected $categoriaModel;

    /**
     * Constructor.
     *
     * Inicializa la instancia del modelo de Categorías.
     */
    public function __construct()
    {
        // Instanciar el modelo de Categorías
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * Muestra la lista de categorías con filtros y paginación.
     *
     * Recoge los parámetros 'estado' y 'busqueda' de la solicitud GET, obtiene
     * las categorías filtradas y paginadas, configura el breadcrumb y otros datos necesarios
     * para la vista.
     *
     * @return string Vista renderizada.
     */
    public function index()
    {
        // Recoger filtros desde GET, asignando valores por defecto si no se especifican.
        $estado   = $this->request->getGet('estado') ?? 'todos';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $perPage  = 10;  // Número de registros por página

        // Obtener las categorías filtradas y paginadas usando el modelo.
        $categorias = $this->categoriaModel->obtenerCategoriasFiltradas($estado, $busqueda, $pagina, $perPage);

        // Configurar breadcrumbs para la navegación interna.
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de Categorías', 'url' => '']
        ];

        // Obtener conteos pendientes (por ejemplo, de mensajes pendientes) desde el método heredado en BaseController.
        $conteos = $this->getConteoPendientes();

        // Preparar los datos que se enviarán a la vista.
        $data = [
            'titulo'              => 'Administrar Categorías',
            'categorias'          => $categorias,
            'pager'               => $this->categoriaModel->pager,
            'estado'              => $estado,
            'busqueda'            => $busqueda,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/categoria/index', $data);
    }

    /**
     * Crea una nueva categoría.
     *
     * Recoge los datos enviados vía POST y utiliza el modelo para crear la categoría.
     * Si la creación es exitosa, redirige a la lista de categorías con un mensaje de éxito;
     * de lo contrario, redirige de vuelta con los datos ingresados y los errores.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la creación.
     */
    public function create()
    {
        $data = $this->request->getPost();

        if ($this->categoriaModel->crearCategoria($data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }
    }

    /**
     * Actualiza una categoría existente.
     *
     * Recoge los datos del formulario vía POST y actualiza la categoría identificada por $id.
     * Retorna un mensaje flash indicando el éxito o fallo de la operación.
     *
     * @param int|string $id ID de la categoría.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la actualización.
     */
    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->categoriaModel->actualizarCategoria($id, $data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }
    }

    /**
     * Elimina (da de baja) una categoría.
     *
     * En lugar de eliminar físicamente el registro, se actualiza su estado a "inactivo".
     *
     * @param int|string $id ID de la categoría.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la eliminación.
     */
    public function delete($id)
    {
        $this->categoriaModel->eliminarCategoria($id);
        return redirect()->to('admin/categoria')->with('mensaje', 'Eliminación exitosa!');
    }

    /**
     * Filtra y busca categorías mediante AJAX.
     *
     * Recoge los parámetros GET (página, texto y estado) y utiliza el modelo para obtener
     * las categorías filtradas y el total de páginas. Retorna los datos en formato JSON.
     *
     * @return \CodeIgniter\HTTP\Response JSON con las categorías, la página actual y el total de páginas.
     */
    public function buscarCategoria()
    {
        // Recoger parámetros GET con valores por defecto.
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $estado   = $this->request->getGet('estado') ?? 'todos';
        $perPage  = 10;

        try {
            // Obtener las categorías filtradas y paginadas utilizando el método del modelo.
            $categorias = $this->categoriaModel->obtenerCategoriasFiltradas($estado, $textoBusqueda, $pagina, $perPage);
            $totalPaginas = $this->categoriaModel->obtenerTotalPaginas($textoBusqueda   , $estado, $perPage);

            return $this->response->setJSON([
                'categorias'   => $categorias,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las categorías. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
