<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MarcaModel;

/** 
 * Controlador para la gestión de Marcas.
 *
 * Este controlador administra la visualización, creación, actualización, eliminación y
 * filtrado/paginación de las marcas en el panel de administración.
 *
 * @package App\Controllers\Admin
 */
class Marca extends BaseController
{
    /**
     * Instancia del modelo de marcas.
     *
     * @var MarcaModel
     */
    protected $marcaModel;

    /**
     * Constructor.
     *
     * Se instancia el modelo de Marcas para que esté disponible en todos los métodos.
     */
    public function __construct()
    {
        $this->marcaModel = new MarcaModel();
    }

    /**
     * Muestra la lista de marcas.
     *
     * Recoge los parámetros de filtrado y búsqueda desde la solicitud GET,
     * obtiene las marcas filtradas y paginadas a través del modelo, y configura
     * datos adicionales (breadcrumbs, conteos pendientes) para la vista.
     *
     * @return string Vista renderizada.
     */
    public function index()
    {
        // Recoger parámetros GET con valores por defecto.
        $estado   = $this->request->getGet('estado') ?? 'todos';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $perPage  = 10;  // Número de registros por página

        // Obtener las marcas filtradas y paginadas utilizando el método del modelo.
        $marcas = $this->marcaModel->obtenerMarcasFiltradas($estado, $busqueda, $pagina, $perPage);

        // Configurar el breadcrumb para la navegación interna.
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de Marcas', 'url' => '']
        ];

        // Obtener los conteos de mensajes pendientes (método heredado de BaseController).
        $conteos = $this->getConteoPendientes();

        // Preparar los datos que se enviarán a la vista.
        $data = [
            'titulo'              => 'Administrar Marcas',
            'marcas'              => $marcas,
            'pager'               => $this->marcaModel->pager,
            'estado'              => $estado,
            'busqueda'            => $busqueda,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/marca/index', $data);
    }

    /**
     * Crea una nueva marca.
     *
     * Recoge los datos enviados mediante POST y utiliza el modelo para crear la marca.
     * Si la operación es exitosa, redirige a la lista de marcas con un mensaje de éxito;
     * de lo contrario, redirige de vuelta con los datos ingresados y los errores.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la creación.
     */
    public function create()
    {
        $data = $this->request->getPost();

        if ($this->marcaModel->crearMarca($data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->marcaModel->errors());
        }
    }

    /**
     * Actualiza una marca existente.
     *
     * Recoge los datos del formulario enviados vía POST y actualiza la marca identificada por $id.
     * Retorna un mensaje flash indicando el éxito o fallo de la operación.
     *
     * @param int|string $id ID de la marca.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la actualización.
     */
    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->marcaModel->actualizarMarca($id, $data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->marcaModel->errors());
        }
    }

    /**
     * Elimina (da de baja) una marca.
     *
     * En lugar de eliminar físicamente el registro, se actualiza su estado a "inactivo".
     * Redirige a la lista de marcas con un mensaje flash.
     *
     * @param int|string $id ID de la marca.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la eliminación.
     */
    public function delete($id)
    {
        $this->marcaModel->eliminarMarca($id);
        return redirect()->to('admin/marca')->with('mensaje', 'Eliminación exitosa!');
    }

    /**
     * Filtra y busca marcas mediante AJAX.
     *
     * Recoge los parámetros GET (página, término de búsqueda y estado), utiliza el modelo para obtener
     * las marcas filtradas y el total de páginas, y retorna los datos en formato JSON.
     *
     * @return \CodeIgniter\HTTP\Response JSON con:
     *         - 'marcas': Array de marcas filtradas.
     *         - 'paginaActual': Página actual.
     *         - 'totalPaginas': Total de páginas disponibles.
     */
    public function buscarMarca()
    {
        // Recoger parámetros GET con valores por defecto.
        $estado   = $this->request->getGet('estado') ?? 'todos';
        $busqueda = $this->request->getGet('textoBusqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $perPage  = 10;

        try {
            // Obtener marcas filtradas y paginadas.
            $marcas = $this->marcaModel->obtenerMarcasFiltradas($estado, $busqueda, $pagina, $perPage);
            $totalPaginas = $this->marcaModel->obtenerTotalPaginas($busqueda, $estado, $perPage);

            return $this->response->setJSON([
                'marcas'       => $marcas,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las marcas. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
