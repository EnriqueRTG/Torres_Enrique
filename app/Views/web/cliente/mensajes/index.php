<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de error o confirmación -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb" class="mb-4">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado: Título y botón "Redactar" -->
    <div class="d-flex flex-column mb-4">
        <h1 class="h3 mb-1 text-white">Mis Mensajes</h1>
        <div class="mt-2">
            <a href="<?= site_url('cliente/mensajes/redactar') ?>" class="btn btn-redactar text-white">
                <i class="bi bi-pencil-square"></i> Redactar
            </a>
        </div>
    </div>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoConversacion" class="form-label text-white">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoConversacion" name="estado" aria-label="Filtrar por estado">
                <!-- Se preserva la selección utilizando GET -->
                <option value="todas" <?= (!isset($_GET['estado']) || $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <option value="respondida" <?= (isset($_GET['estado']) && $_GET['estado'] == 'respondida') ? 'selected' : '' ?>>Respondidas</option>
            </select>
        </div>
        <!-- Buscador: filtra por nombre y/o asunto -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label text-white">Buscar por asunto:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda"
                placeholder="Ingrese asunto"
                value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-buscar-outline w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Spinner de carga (oculto por defecto) -->
    <div id="spinner" class="text-center d-none my-3">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Contenedor para la tabla de conversaciones (se actualizará via AJAX) -->
    <div id="listaConversaciones">
        <div class="table-responsive" id="tablaConversaciones">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr class="text-center align-middle">
                        <th scope="col">Asunto</th>
                        <th scope="col">Fecha de Inicio</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">

                </tbody>
            </table>
        </div>
        <!-- Paginación (si aplica) -->
        <?php if (isset($pager)): ?>
            <div class="d-flex justify-content-center">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Controles de paginación -->
    <div class="d-flex justify-content-center" id="paginacion"></div>
</main>

<!-- Modal de Confirmación para Cerrar Conversación -->
<div class="modal fade" id="cerrarConversacionModal" tabindex="-1" aria-labelledby="cerrarConversacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrarConversacionModalLabel">Confirmar Eliminacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="eliminarConversacionForm" method="post" action="">
                <div class="modal-body">
                    ¿Estás seguro de eliminar esta conversación?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Conversación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>

<!-- Scripts -->
<script>
    // Inicialización al cargar el DOM
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        abrirModalEliminar();
        cargarConversacionesDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos que tengan el atributo data-bs-toggle="tooltip".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    function abrirModalEliminar() {
        document.addEventListener('click', function(e) {
            const btnEliminar = e.target.closest('.btn-eliminar');
            if (btnEliminar) {
                e.preventDefault();
                // Obtener el ID de la conversación
                const conversacionId = btnEliminar.getAttribute('data-conv-id');
                // Actualizar la acción del formulario en el modal
                const formulario = document.getElementById('eliminarConversacionForm');
                formulario.action = '<?= base_url("cliente/mensajes/cerrar") ?>/' + conversacionId;
                // Mostrar el modal de confirmación
                const modalEl = document.getElementById('cerrarConversacionModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }

    /**
     * Realiza una solicitud AJAX para obtener las consultas filtradas según los parámetros,
     * y actualiza la tabla y la paginación.
     *
     * @param {number} pagina - Página actual a cargar (por defecto 1).
     * @param {string} busqueda - Texto de búsqueda (por defecto cadena vacía).
     * @param {string} estado - Filtro de estado ('todas', 'pendiente', 'respondida' o 'cerrada').
     */
    function aplicarFiltro(pagina = 1, busqueda = '', estado = 'todas') {
        // Construir la URL con parámetros
        const url = '<?= base_url("cliente/mensaje/buscarMensaje") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            busqueda: busqueda,
            estado: estado
        });

        // Mostrar el spinner mientras se carga la información
        document.getElementById('spinner').classList.remove('d-none');

        fetch(`${url}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                actualizarTablaConversaciones(data.conversaciones);
                generarPaginacion(data.paginaActual, data.totalPaginas, busqueda, estado);
                inicializarTooltips(); 
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las conversaciones. Inténtalo de nuevo.');
            })
            .finally(() => {
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza el cuerpo de la tabla de consultas con los datos recibidos vía AJAX.
     * Se asignan clases y badges según el estado de cada consulta:
     * - "Pendiente": Conversación abierta y último mensaje del cliente (o sin mensaje).
     * - "Respondida": Conversación abierta y último mensaje del administrador.
     * - "Cerrada": Conversación marcada como cerrada.
     *
     * @param {Array} consultas - Array de objetos consulta.
     */
    function actualizarTablaConversaciones(conversaciones) {
        const tbody = document.querySelector('#tablaConversaciones tbody');
        tbody.innerHTML = '';

        if (conversaciones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron conversaciones.</td></tr>';
            return;
        }

        conversaciones.forEach(conversacion => {
            let estadoVisual = '';
            let claseFila = '';
            let badgeClass = '';

            // Determinar el estado visual basado en el campo 'estado' y el último mensaje (si existe)
            if (conversacion.estado === 'cerrada') {
                estadoVisual = 'Cerrada';
                claseFila = 'table-secondary';
                badgeClass = 'bg-secondary';
            } else if (conversacion.ultimoMensaje && conversacion.ultimoMensaje.tipo_remitente === 'administrador') {
                estadoVisual = 'Respondida';
                claseFila = 'table-success';
                badgeClass = 'bg-success';
            } else {
                estadoVisual = 'Pendiente';
                claseFila = 'table-warning';
                badgeClass = 'bg-warning text-dark';
            }

            // Crear la fila de la tabla con los datos de la consulta
            const tr = document.createElement('tr');
            tr.className = claseFila;
            // Dentro de la creación de la fila (template literal)
            tr.innerHTML = `
                        <td>${conversacion.asunto}</td>
                        <td>${new Date(conversacion.created_at).toLocaleString()}</td>
                        <td>
                            <span class="badge ${badgeClass}">
                                ${estadoVisual}
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('cliente/mensajes/ver') ?>/${conversacion.id}" 
                            class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Ver conversación"> 
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger btn-eliminar" data-conv-id="${conversacion.id}" data-bs-toggle="tooltip" title="Eliminar conversación">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </td>
                        `;
            tbody.appendChild(tr);
        });
    }

    /**
     * Genera los controles de paginación basados en la página actual y el total de páginas.
     *
     * @param {number} paginaActual - Página actual.
     * @param {number} totalPaginas - Total de páginas.
     * @param {string} textoBusqueda - Texto de búsqueda aplicado.
     * @param {string} estado - Filtro de estado aplicado.
     */
    function generarPaginacion(paginaActual, totalPaginas, busqueda, estado) {
        const paginacionContainer = document.getElementById('paginacion');
        paginacionContainer.innerHTML = '';

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
            fragment.appendChild(crearBotonPaginacion('Anterior', paginaActual - 1, busqueda, estado));
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            fragment.appendChild(crearBotonPaginacion(i, i, busqueda, estado, i === paginaActual));
        }

        if (paginaActual < totalPaginas) {
            fragment.appendChild(crearBotonPaginacion('Siguiente', paginaActual + 1, busqueda, estado));
        }

        paginacionContainer.appendChild(fragment);
    }

    /**
     * Crea un botón de paginación.
     *
     * @param {string|number} texto - Texto o número a mostrar en el botón.
     * @param {number} pagina - Página a la que redirige el botón.
     * @param {string} textoBusqueda - Texto de búsqueda a conservar.
     * @param {string} estado - Filtro de estado a conservar.
     * @param {boolean} activo - Indica si el botón corresponde a la página actual.
     * @returns {HTMLElement} Botón de paginación.
     */
    function crearBotonPaginacion(texto, pagina, busqueda, estado, activo = false) {
        const btn = document.createElement('a');
        btn.href = '#';
        btn.textContent = texto;
        btn.classList.add('btn', 'btn-outline-primary', 'm-1');
        if (activo) btn.classList.add('active');

        btn.addEventListener('click', function(event) {
            event.preventDefault();
            aplicarFiltro(pagina, busqueda, estado);
        });

        return btn;
    }

    /**
     * Carga las consultas de forma dinámica utilizando el valor guardado en localStorage.
     *
     * Se utiliza la clave "estado_consulta" para preservar la selección en esta vista.
     */
    function cargarConversacionesDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_mensaje') || 'todas';
        document.getElementById('filtroEstadoConversacion').value = estadoGuardado;
        aplicarFiltro(1, document.getElementById('busqueda').value, estadoGuardado);
    }

    // Actualizar el filtro cuando se cambia el select de estado
    document.getElementById('filtroEstadoConversacion').addEventListener('change', function() {
        localStorage.setItem('estado_mensaje', this.value);
        aplicarFiltro(1, document.getElementById('busqueda').value, this.value);
    });

    // Actualizar el filtro en tiempo real al escribir en el campo de búsqueda
    document.getElementById('busqueda').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoConversacion').value);
    });
</script>