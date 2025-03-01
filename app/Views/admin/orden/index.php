<!-- Vista: app/Views/admin/ordenes/index.php -->

<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>
<?= view("partials/_navbar-admin") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión (alertas de error o confirmación) -->
    <div class="alert-info text-center">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Órdenes</h1>
        <p class="lead">Listado de <strong>órdenes</strong> registradas de clientes.</p>
    </header>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoOrden" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoOrden" name="estado" aria-label="Filtrar órdenes por estado">
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <option value="completada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'completada') ? 'selected' : '' ?>>Completadas</option>
                <option value="cancelada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'cancelada') ? 'selected' : '' ?>>Canceladas</option>
                <option value="todas" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
            </select>
        </div>
        <!-- Buscador por número de orden o nombre de usuario -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por número de orden o nombre de usuario:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese número de orden o nombre de usuario" value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Sección: Lista de órdenes y paginación -->
    <section class="my-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div id="spinner" class="text-center d-none m-5" aria-live="polite">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <!-- Tabla de órdenes (cargada dinámicamente por AJAX) -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaOrdenes">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th>Orden #</th>
                        <th>Nombres Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Dirección Envío</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Los registros se cargarán dinámicamente mediante AJAX -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Paginación (se actualiza dinámicamente) -->
    <div class="text-center" id="paginacion">
        <?= isset($pager) ? $pager->links() : '' ?>
    </div>
</main>

<!-- Modal genérico para confirmar acciones (cancelar o completar) -->
<div class="modal fade" id="confirmarAccionModal" tabindex="-1" aria-labelledby="confirmarAccionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarAccionModalLabel">Confirmar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="confirmActionMessage">¿Está seguro de realizar esta acción?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmAction" class="btn btn-primary">Confirmar</a>
            </div>
        </div>
    </div>
</div>

<?= view("layouts/footer-admin") ?>

<!-- Script para el manejo dinámico de la tabla, filtros y modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarOrdenesDinamicamente();
    });

    /**
     * Inicializa tooltips en elementos que utilizan data-bs-toggle.
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Delegar eventos para los botones de acción (cancelar y completar).
     */
    function delegarEventosModales() {
        document.addEventListener('click', function(event) {
            const btnCancelar = event.target.closest('.btn-cancelar');
            const btnCompletar = event.target.closest('.btn-completar');
            if (btnCancelar) {
                abrirModalGenerico(btnCancelar);
            }
            if (btnCompletar) {
                abrirModalGenerico(btnCompletar);
            }
        });
    }

    /**
     * Abre el modal genérico y configura su contenido y URL de confirmación.
     * Actualiza el título, mensaje y la URL del botón de confirmación según la acción.
     *
     * @param {HTMLElement} btn - Botón que dispara la acción.
     */
    function abrirModalGenerico(btn) {
        event.preventDefault();
        const accion = btn.getAttribute('data-accion'); // "cancelar" o "completar"
        const ordenId = btn.getAttribute('data-bs-id');
        const estadoFinal = btn.getAttribute('data-estado');

        // Configurar el título y el mensaje del modal
        const modalTitle = document.getElementById('confirmarAccionModalLabel');
        const modalMessage = document.getElementById('confirmActionMessage');
        modalTitle.textContent = `Confirmar ${accion.charAt(0).toUpperCase() + accion.slice(1)}`;
        modalMessage.textContent = `¿Está seguro de marcar la Orden #${ordenId} como ${estadoFinal}?`;

        // Configurar la URL de confirmación en función de la acción
        let url = '';
        if (accion === 'cancelar') {
            url = `<?= base_url('admin/ordenes/cancelar') ?>/${ordenId}`;
        } else if (accion === 'completar') {
            url = `<?= base_url('admin/ordenes/completar') ?>/${ordenId}`;
        }
        document.getElementById('btnConfirmAction').setAttribute('href', url);

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('confirmarAccionModal'));
        modal.show();
    }

    /**
     * Aplica el filtro de búsqueda y estado mediante AJAX para actualizar la tabla de órdenes.
     *
     * @param {number} pagina - Número de página actual.
     * @param {string} textoBusqueda - Término de búsqueda.
     * @param {string} estado - Filtro de estado.
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'pendiente') {
        const url = '<?= base_url("admin/orden/buscarOrden") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            busqueda: textoBusqueda,
            estado: estado
        });


        // Mostrar el spinner de carga
        document.getElementById('spinner').classList.remove('d-none');

        fetch(`${url}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                actualizarTablaOrdenes(data.ordenes);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las órdenes. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza el cuerpo de la tabla con los datos de las órdenes recibidas.
     *
     * @param {Array} ordenes - Array de objetos de orden.
     */
    function actualizarTablaOrdenes(ordenes) {
        const tbody = document.querySelector('#tablaOrdenes tbody');
        tbody.innerHTML = '';

        if (ordenes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No se encontraron órdenes.</td></tr>';
            return;
        }

        ordenes.forEach(orden => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${orden.id}</td>
                <td>${orden.nombre_cliente} ${orden.apellido_cliente}</td>
                <td>${orden.created_at}</td>
                <td>
                    <span class="badge ${orden.orden_estado === 'pendiente' ? 'bg-warning' : (orden.orden_estado === 'completada' ? 'bg-success' : 'bg-danger')}">
                        ${orden.orden_estado.charAt(0).toUpperCase() + orden.orden_estado.slice(1)}
                    </span>
                </td>
                <td>$${Number(orden.total).toFixed(2)}</td>
                <td>
                    ${orden.calle} ${orden.numero}<br>
                    ${orden.ciudad} - ${orden.provincia}
                </td>
                <td class="text-start">
                    <!-- Botón para ver el detalle de la orden, siempre visible -->
                    <a href="<?= base_url('admin/ordenes/show/') ?>${orden.id}" class="btn btn-outline-primary btn-sm mx-1 mb-2 mb-md-0" title="Ver Detalle"
                    data-bs-toggle="tooltip"
                    >
                        <i class="bi bi-eye"></i>
                    </a>
                    ${
                    // Si la orden está pendiente, se muestran botones para cancelar o completar.
                    orden.orden_estado === 'pendiente'
                    ? `
                        <a href="#" class="btn btn-outline-danger btn-sm mx-1 mb-2 mb-md-0 btn-cancelar" data-accion="cancelar" data-bs-id="${orden.id}" data-estado="CANCELADA" title="Cancelar Orden"
                        data-bs-toggle="tooltip"
                        >
                            <i class="bi bi-x-circle"></i>
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm mx-1 mb-2 mb-md-0 btn-completar" data-accion="completar" data-bs-id="${orden.id}" data-estado="COMPLETADA" title="Completar Orden"
                        data-bs-toggle="tooltip"
                        >
                            <i class="bi bi-check-circle"></i>
                        </a>
                        `
                    : (
                        // Si la orden está completada, se muestra el botón para descargar el comprobante.
                        orden.orden_estado === 'completada'
                        ? `<a href="<?= base_url('admin/ordenes/comprobante/') ?>${orden.id}" class="btn btn-outline-secondary btn-sm mx-1 mb-2 mb-md-0" title="Descargar Comprobante"
                        data-bs-toggle="tooltip"
                        >
                                <i class="bi bi-download"></i>
                        </a>`
                        : `<span class="text-muted">Sin acciones</span>`
                    )
                    }
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Re-inicializar tooltips para los nuevos elementos
        inicializarTooltips();
    }

    /**
     * Genera la paginación de la tabla.
     *
     * @param {number} paginaActual - Página actual.
     * @param {number} totalPaginas - Total de páginas.
     * @param {string} textoBusqueda - Término de búsqueda.
     * @param {string} estado - Filtro de estado.
     */
    function generarPaginacion(paginaActual, totalPaginas, textoBusqueda, estado) {
        const container = document.getElementById('paginacion');
        container.innerHTML = '';

        const fragment = document.createDocumentFragment();
        paginaActual = parseInt(paginaActual, 10);
        totalPaginas = parseInt(totalPaginas, 10);
        const maxPaginasVisibles = 5;
        let paginaInicial = Math.max(1, paginaActual - Math.floor(maxPaginasVisibles / 2));
        let paginaFinal = Math.min(totalPaginas, paginaInicial + maxPaginasVisibles - 1);

        if (paginaFinal - paginaInicial < maxPaginasVisibles - 1) {
            paginaInicial = Math.max(1, paginaFinal - maxPaginasVisibles + 1);
        }

        if (paginaActual > 1) {
            fragment.appendChild(crearBotonPaginacion('Anterior', paginaActual - 1, textoBusqueda, estado));
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            fragment.appendChild(crearBotonPaginacion(i, i, textoBusqueda, estado, i === paginaActual));
        }

        if (paginaActual < totalPaginas) {
            fragment.appendChild(crearBotonPaginacion('Siguiente', paginaActual + 1, textoBusqueda, estado));
        }

        container.appendChild(fragment);
    }

    /**
     * Crea un botón de paginación.
     *
     * @param {string|number} texto - Texto o número a mostrar en el botón.
     * @param {number} pagina - Página destino.
     * @param {string} textoBusqueda - Término de búsqueda actual.
     * @param {string} estado - Filtro de estado actual.
     * @param {boolean} activo - Indica si es la página actual.
     * @returns {HTMLElement} El botón de paginación.
     */
    function crearBotonPaginacion(texto, pagina, textoBusqueda, estado, activo = false) {
        const btn = document.createElement('a');
        btn.href = '#';
        btn.textContent = texto;
        btn.classList.add('btn', 'btn-outline-primary', 'm-1');
        if (activo) btn.classList.add('active');

        btn.addEventListener('click', function(event) {
            event.preventDefault();
            aplicarFiltro(pagina, textoBusqueda, estado);
        });

        return btn;
    }

    /**
     * Carga dinámicamente las órdenes utilizando el filtro almacenado en localStorage.
     */
    function cargarOrdenesDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_orden') || 'pendiente';
        document.getElementById('filtroEstadoOrden').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Actualiza el filtro al cambiar el select y al escribir en el buscador
    document.getElementById('filtroEstadoOrden').addEventListener('change', function() {
        localStorage.setItem('estado_orden', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoOrden').value);
    });
</script>