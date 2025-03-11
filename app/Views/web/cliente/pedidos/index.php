<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Navbar principal para el cliente -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal -->
<div class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div id="flashMessage" class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>

    <!-- Encabezado -->
    <div class="d-flex flex-column mb-4">
        <h1 class="h3 mb-1 text-white">Mis Pedidos</h1>
    </div>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoPedido" class="form-label text-white">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoPedido" name="estado" aria-label="Filtrar por estado">
                <option value="todas" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todos</option>
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <option value="completada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'completada') ? 'selected' : '' ?>>Completados</option>
                <option value="cancelada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'cancelada') ? 'selected' : '' ?>>Cancelados</option>
            </select>
        </div>
        <!-- Buscador por asunto -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label text-white">Buscar por número de Pedido:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda"
                placeholder="Ingrese número de pedido"
                value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-buscar-outline w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Spinner de carga -->
    <div id="spinner" class="text-center d-none m-5" aria-live="polite">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Tabla de órdenes (contenido se actualizará vía AJAX) -->
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="tablaPedidos">
            <thead class="text-center align-middle">
                <tr>
                    <th scope="col">Orden</th>
                    <th scope="col">Total</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha de Creación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <!-- Se cargan dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Contenedor para controles de paginación -->
    <div id="paginacion" class="d-flex justify-content-center"></div>
</div>

<!-- Modal de Confirmación para Cancelar Pedido -->
<div class="modal fade" id="cancelarPedidoModal" tabindex="-1" aria-labelledby="cancelarPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelarPedidoModalLabel">Confirmar Cancelación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="cancelarPedidoForm" method="post" action="">
                <div class="modal-body">
                    ¿Estás seguro de cancelar el pedido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Cancelar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view("layouts/footer-cliente") ?>

<!-- Scripts -->
<script>
    // Cuando el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        abrirModalCancelar();
        cargarPedidosDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para todos los elementos que tengan data-bs-toggle="tooltip".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Configura la apertura del modal de confirmación para cancelar pedido.
     * Escucha en delegación de eventos para elementos con la clase .btn-cancelar.
     */
    function abrirModalCancelar() {
        document.addEventListener('click', function(e) {
            const btnCancelar = e.target.closest('.btn-cancelar');
            if (btnCancelar) {
                e.preventDefault();
                // Obtener el ID del pedido desde el atributo data-pedido-id
                const pedidoId = btnCancelar.getAttribute('data-pedido-id');
                // Actualizar la acción del formulario del modal
                const formulario = document.getElementById('cancelarPedidoForm');
                formulario.action = '<?= base_url("cliente/pedidos/cancelar") ?>/' + pedidoId;
                // Mostrar el modal
                const modalEl = document.getElementById('cancelarPedidoModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    }

    /**
     * Realiza una solicitud AJAX para obtener las órdenes filtradas según los parámetros,
     * y actualiza la tabla y la paginación.
     *
     * @param {number} pagina - Página actual a cargar (por defecto 1).
     * @param {string} busqueda - Término de búsqueda.
     * @param {string} estado - Filtro de estado.
     */
    function aplicarFiltro(pagina = 1, busqueda = '', estado = 'todas') {
        const url = '<?= base_url("cliente/pedidos/buscarPedido") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            busqueda: busqueda,
            estado: estado
        });

        // Mostrar el spinner
        document.getElementById('spinner').classList.remove('d-none');

        fetch(`${url}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                actualizarTablaOrdenes(data.pedidos);
                generarPaginacion(data.paginaActual, data.totalPaginas, busqueda, estado);
                inicializarTooltips();
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
     * Actualiza el cuerpo de la tabla con los datos de los pedidos recibidos vía AJAX.
     *
     * @param {Array} pedidos - Array de objetos de pedido.
     */
    function actualizarTablaOrdenes(pedidos) {
        const tbody = document.querySelector('#tablaPedidos tbody');
        tbody.innerHTML = '';

        if (pedidos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron órdenes.</td></tr>';
            return;
        }

        pedidos.forEach(pedido => {
            const tr = document.createElement('tr');

            // Definir el badge y estilos según el estado de la orden
            let badgeClass = '';
            if (pedido.orden_estado === 'pendiente') {
                badgeClass = 'bg-warning text-dark';
            } else if (pedido.orden_estado === 'completada') {
                badgeClass = 'bg-success';
            } else if (pedido.orden_estado === 'cancelada') {
                badgeClass = 'bg-danger';
            }

            tr.innerHTML = `
                <td>${pedido.id}</td>
                <td>$${Number(pedido.total).toFixed(2)}</td>
                <td>
                    <span class="badge ${badgeClass}">
                        ${pedido.orden_estado.charAt(0).toUpperCase() + pedido.orden_estado.slice(1)}
                    </span>
                </td>
                <td>
                    <time datetime="${pedido.created_at}">
                        ${pedido.created_at}
                    </time>
                </td>
                <td class="text-center">
                    <a href="<?= base_url('cliente/pedidos/show/') ?>${pedido.id}" class="btn btn-outline-primary btn-sm mx-1 mb-2 mb-md-0" title="Ver Detalle" data-bs-toggle="tooltip">
                        <i class="bi bi-eye"></i>
                    </a>
                    ${
                        pedido.orden_estado === 'pendiente'
                        ? `<button type="button" class="btn btn-outline-danger btn-sm mx-1 mb-2 mb-md-0 btn-cancelar" data-pedido-id="${pedido.id}" title="Cancelar Orden" data-bs-toggle="tooltip">
                               <i class="bi bi-x-circle"></i>
                           </button>`
                        : ''
                    }
                           <a href="<?= base_url('cliente/pedidos/descargarPdf/') ?>${pedido.id}" class="btn btn-outline-secondary btn-sm mx-1 mb-2 mb-md-0" title="Descargar Comprobante" data-bs-toggle="tooltip">
                                    <i class="bi bi-download"></i>
                               </a>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    /**
     * Genera los controles de paginación según la página actual y el total de páginas.
     *
     * @param {number} paginaActual - Página actual.
     * @param {number} totalPaginas - Total de páginas.
     * @param {string} busqueda - Término de búsqueda.
     * @param {string} estado - Filtro de estado.
     */
    function generarPaginacion(paginaActual, totalPaginas, busqueda, estado) {
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
            fragment.appendChild(crearBotonPaginacion('Anterior', paginaActual - 1, busqueda, estado));
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            fragment.appendChild(crearBotonPaginacion(i, i, busqueda, estado, i === paginaActual));
        }

        if (paginaActual < totalPaginas) {
            fragment.appendChild(crearBotonPaginacion('Siguiente', paginaActual + 1, busqueda, estado));
        }

        container.appendChild(fragment);
    }

    /**
     * Crea un botón de paginación.
     *
     * @param {string|number} texto - Texto o número a mostrar en el botón.
     * @param {number} pagina - Página destino.
     * @param {string} busqueda - Término de búsqueda actual.
     * @param {string} estado - Filtro de estado actual.
     * @param {boolean} activo - Indica si es la página actual.
     * @returns {HTMLElement} El botón de paginación.
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
     * Carga las órdenes de forma dinámica utilizando el valor guardado en localStorage.
     *
     * Se utiliza la clave "estado_pedido" para preservar la selección en esta vista.
     */
    function cargarPedidosDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_pedido') || 'todas';
        document.getElementById('filtroEstadoPedido').value = estadoGuardado;
        aplicarFiltro(1, document.getElementById('busqueda').value, estadoGuardado);
    }

    // Actualizar el filtro al cambiar el select y al escribir en el buscador
    document.getElementById('filtroEstadoPedido').addEventListener('change', function() {
        localStorage.setItem('estado_pedido', this.value);
        aplicarFiltro(1, document.getElementById('busqueda').value, this.value);
    });
    document.getElementById('busqueda').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoPedido').value);
    });
</script>