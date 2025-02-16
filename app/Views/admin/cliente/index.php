<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal -->
<main class="container py-5 main-content" tabindex="0">
    <!-- Mensajes de sesión: alertas de error o éxito -->
    <div class="alert-info text-center">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para navegación jerárquica -->
    <nav aria-label="breadcrumb" class="my-3">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Filtros y Buscador -->
    <div class="row my-4">
        <!-- Buscador: Filtra clientes por nombre, apellido o email -->
        <div class="col-md-6 mt-md-0 mt-3">
            <form class="d-inline-flex" role="search" id="buscadorClienteForm">
                <input type="search" class="form-control me-2" name="search" placeholder="Buscar por nombre, apellido o email" aria-label="Buscar">
                <button type="submit" class="btn btn-outline-primary fw-bold">Buscar</button>
            </form>
        </div>
        <!-- Filtro de Estado: Por defecto activos -->
        <div class="col-md-3 offset-md-3 mt-md-0 mt-3">
            <select id="filtroEstado" class="form-select">
                <option value="activo" selected>Activos</option>
                <option value="inactivo">Inactivos</option>
                <option value="todos">Todos</option>
            </select>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="my-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div id="spinner" class="text-center d-none my-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaClientes">
                <thead>
                    <tr class="text-capitalize text-center">
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha de Alta</th>
                        <th scope="col">Última Modificación</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- Las filas se cargarán dinámicamente vía AJAX -->
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="text-center" id="paginacion">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </div>
</main>

<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para filtrar, buscar y paginar clientes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa tooltips si es necesario
        inicializarTooltips();
        // Carga inicial de clientes con el filtro por defecto (activos)
        cargarClientesDinamicos();
        // Delegar eventos en el buscador y el filtro
        delegarEventosFiltros();
    });

    /**
     * Inicializa los tooltips de Bootstrap.
     */
    function inicializarTooltips() {
        const tooltipElements = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    /**
     * Configura los eventos para el buscador y el filtro de estado.
     */
    function delegarEventosFiltros() {
        // Evento para el filtro de estado
        document.getElementById('filtroEstado').addEventListener('change', function() {
            aplicarFiltro(1, document.querySelector('input[name="search"]').value, this.value);
        });

        document.querySelector('input[type="search"]').addEventListener('input', function() {
            aplicarFiltro(1, this.value, document.getElementById('filtroEstado').value);
        });
    }

    /**
     * Envía una solicitud AJAX para aplicar los filtros y actualizar la tabla de clientes.
     * 
     * @param {number} pagina Número de página actual.
     * @param {string} busqueda Texto de búsqueda.
     * @param {string} estado Filtro de estado ("activo", "inactivo" o "todos").
     */
    function aplicarFiltro(pagina = 1, busqueda = '', estado = 'activo') {
        const url = '<?= base_url("admin/cliente/buscarCliente") ?>';
        const params = new URLSearchParams({
            pagina,
            busqueda,
            estado
        });

        // Muestra el spinner mientras carga
        document.getElementById('spinner').classList.remove('d-none');

        fetch(`${url}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                actualizarTablaClientes(data.clientes);
                generarPaginacion(data.paginaActual, data.totalPaginas, busqueda, estado);
            })
            .catch(error => {
                console.error('Error al cargar clientes:', error);
                alert('Error al cargar los clientes. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Oculta el spinner al finalizar
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza el cuerpo de la tabla de clientes con los datos recibidos.
     * 
     * @param {Array} clientes Arreglo de objetos cliente.
     */
    function actualizarTablaClientes(clientes) {
        const tbody = document.querySelector('#tablaClientes tbody');
        tbody.innerHTML = '';

        clientes.forEach(cliente => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${cliente.nombre} ${cliente.apellido}</td>
            <td>${cliente.email}</td>
            <td>
                <span class="badge ${cliente.estado === 'activo' ? 'bg-success' : 'bg-danger'}">
                    ${cliente.estado.charAt(0).toUpperCase() + cliente.estado.slice(1)}
                </span>
            </td>
            <td>${new Date(cliente.created_at).toLocaleString()}</td>
            <td>${new Date(cliente.updated_at).toLocaleString()}</td>
            <td class="text-center">
                <!-- Opciones de consulta: Historial de mensajes y pedidos -->
                <a href="<?= base_url('admin/cliente/mensajes/') ?>${cliente.id}" class="btn btn-outline-info btn-sm mx-1" title="Historial de Mensajes"
                data-bs-toggle="tooltip">
                    <i class="bi bi-chat-left-text"></i>
                </a>
                <a href="<?= base_url('admin/cliente/pedidos/') ?>${cliente.id}" class="btn btn-outline-primary btn-sm mx-1" title="Historial de Pedidos"
                data-bs-toggle="tooltip">
                    <i class="bi bi-basket"></i>
                </a>
            </td>
        `;
            tbody.appendChild(tr);
        });

        inicializarTooltips();
    }

    /**
     * Genera los botones de paginación y los inserta en el contenedor.
     * 
     * @param {number} paginaActual Página actual.
     * @param {number} totalPaginas Total de páginas.
     * @param {string} busqueda Texto de búsqueda.
     * @param {string} estado Filtro de estado.
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
     * Crea un botón de paginación con el texto y la acción correspondiente.
     * 
     * @param {string|number} texto Texto o número del botón.
     * @param {number} pagina Página a la que se dirigirá el botón.
     * @param {string} busqueda Texto de búsqueda actual.
     * @param {string} estado Filtro de estado actual.
     * @param {boolean} activo Indica si el botón representa la página actual.
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
     * Carga la lista inicial de clientes usando el filtro por defecto (activos).
     */
    function cargarClientesDinamicos() {
        const estadoGuardado = localStorage.getItem('estadoCliente') || 'activo';
        document.getElementById('filtroEstado').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }
</script>