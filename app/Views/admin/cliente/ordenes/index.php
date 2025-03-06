<!-- Vista: admin/cliente/pedidos/index.php -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<?= view('partials/_navbar-admin') ?>

<main class="container my-3 main-content">
    <!-- Mensajes de sesión -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Órdenes de <?= esc($cliente->nombre) ?> <?= esc($cliente->apellido) ?></h1>
        <p class="lead">Listado de órdenes realizadas por el cliente.</p>
    </header>

    <input type="hidden" id="clienteId" value="<?= $cliente->id ?>">

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado de la orden -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoOrden" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoOrden" name="estado" aria-label="Filtrar por estado">
                <option value="todas" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                <option value="completada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'completada') ? 'selected' : '' ?>>Completada</option>
                <option value="cancelada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'cancelada') ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>
        <!-- Buscador por número de orden -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por número de orden:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese número de orden" value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Sección: Tabla de Órdenes y Paginación -->
    <section class="mb-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div id="spinner" class="text-center d-none my-5" aria-live="polite">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Tabla de Órdenes -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaOrdenes">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Número de Orden</th>
                        <th scope="col">Fecha de Pedido</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Total</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Las filas se cargarán dinámicamente vía AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Controles de paginación -->
        <div class="text-center" id="paginacion">
        </div>
    </section>
</main>

<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para filtrar, buscar y paginar órdenes (opcional si deseas carga dinámica) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        // Si deseas implementar carga dinámica via AJAX, descomenta la siguiente línea:
        cargarOrdenesDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap.
     */
    function inicializarTooltips() {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    /* Ejemplo de funciones para carga dinámica de órdenes vía AJAX.
       Estas funciones requieren que implementes en el controlador un método
       (por ejemplo, admin/cliente/buscarOrden) que retorne los datos en JSON. */

    function aplicarFiltroOrdenes(pagina = 1, busqueda = '', estado = 'todas') {
        const clienteId = document.getElementById('clienteId').value;
        const url = '<?= base_url("admin/cliente/buscarOrden") ?>';
        const params = new URLSearchParams({
            pagina,
            busqueda: busqueda,
            estado,
            clienteId: clienteId
        });

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
                generarPaginacionOrdenes(data.paginaActual, data.totalPaginas, busqueda, estado);
            })
            .catch(error => {
                console.error('Error al cargar órdenes:', error);
                alert('Error al cargar las órdenes. Inténtalo de nuevo.');
            })
            .finally(() => {
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    function actualizarTablaOrdenes(ordenes) {
        const tbody = document.querySelector('#tablaOrdenes tbody');
        tbody.innerHTML = '';

        if (ordenes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron órdenes.</td></tr>';
            return;
        }

        ordenes.forEach(orden => {
            let badgeClass = '';
            switch (orden.orden_estado) { // Usar el alias "orden_estado"
                case 'pendiente':
                    badgeClass = 'bg-warning';
                    break;
                case 'completada':
                    badgeClass = 'bg-success';
                    break;
                case 'cancelada':
                    badgeClass = 'bg-danger';
                    break;
                default:
                    badgeClass = 'bg-secondary';
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${orden.id}</td>
            <td>${new Date(orden.created_at).toLocaleString()}</td>
            <td><span class="badge ${badgeClass}">${orden.orden_estado.charAt(0).toUpperCase() + orden.orden_estado.slice(1)}</span></td>
            <td>${parseFloat(orden.total).toFixed(2)}</td>
            <td class="text-center">
                <a href="<?= base_url('admin/clientes/ordenes/mostrar/') ?>${orden.id}" class="btn btn-outline-info btn-sm m-1" title="Ver Detalle" data-bs-toggle="tooltip">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        `;
            tbody.appendChild(tr);
        });

        inicializarTooltips();
    }


    function generarPaginacionOrdenes(paginaActual, totalPaginas, busqueda, estado) {
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
            fragment.appendChild(crearBotonPaginacionOrdenes('Anterior', paginaActual - 1, busqueda, estado));
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            fragment.appendChild(crearBotonPaginacionOrdenes(i, i, busqueda, estado, i === paginaActual));
        }

        if (paginaActual < totalPaginas) {
            fragment.appendChild(crearBotonPaginacionOrdenes('Siguiente', paginaActual + 1, busqueda, estado));
        }

        container.appendChild(fragment);
    }

    function crearBotonPaginacionOrdenes(texto, pagina, busqueda, estado, activo = false) {
        const btn = document.createElement('a');
        btn.href = '#';
        btn.textContent = texto;
        btn.classList.add('btn', 'btn-outline-primary', 'm-1');
        if (activo) btn.classList.add('active');

        btn.addEventListener('click', function(event) {
            event.preventDefault();
            aplicarFiltroOrdenes(pagina, busqueda, estado);
        });

        return btn;
    }

    function cargarOrdenesDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_orden_cliente') || 'todas';
        document.getElementById('filtroEstadoOrden').value = estadoGuardado;
        aplicarFiltroOrdenes(1, '', estadoGuardado);
    }

    // Eventos para actualizar el listado en tiempo real
    document.getElementById('filtroEstadoOrden').addEventListener('change', function() {
        localStorage.setItem('estado_orden_cliente', this.value);
        aplicarFiltroOrdenes(1, document.querySelector('input[type="search"]').value, this.value);
    });

    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltroOrdenes(1, this.value, document.getElementById('filtroEstadoOrden').value);
    });
</script>