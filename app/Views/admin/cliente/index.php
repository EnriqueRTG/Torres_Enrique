<!-- Vista parcial: Header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Clientes</h1>
        <p class="lead">Listado de <strong>clientes</strong> registradas.</p>
    </header>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoCliente" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoCliente" name="estado" aria-label="Filtrar por estado">
                <option value="activo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'activo') ? 'selected' : '' ?>>Activos</option>
                <option value="inactivo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivos</option>
                <option value="todos" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todos') ? 'selected' : '' ?>>Todos</option>
            </select>
        </div>
        <!-- Buscador por nombre o descripción -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o email:</label>
            <input type="search" class="form-control" id="busqueda" name="textoBusqueda" placeholder="Ingrese nombre o email" value="<?= isset($_GET['textoBusqueda']) ? esc($_GET['textoBusqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Tabla de Clientes y Paginación -->
    <section class="mb-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div id="spinner" class="text-center d-none my-5" aria-live="polite">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Tabla de Clientes -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaClientes">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha de Alta</th>
                        <th scope="col">Última Modificación</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Las filas se cargarán dinámicamente vía AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Controles de paginación -->
        <div class="text-center" id="paginacion"></div>
    </section>
</main>

<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para filtrar, buscar y paginar clientes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa tooltips (si se utilizan)
        inicializarTooltips();
        // Carga inicial de clientes usando el filtro por defecto (activos)
        cargarClientesDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos con data-bs-toggle.
     */
    function inicializarTooltips() {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    /**
     * Envía una solicitud AJAX para aplicar los filtros y actualizar la tabla de clientes.
     * 
     * @param {number} pagina Número de página actual.
     * @param {string} textoBusqueda Texto de búsqueda.
     * @param {string} estado Filtro de estado ("activo", "inactivo" o "todos").
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'activo') {
        const url = '<?= base_url("admin/cliente/buscarCliente") ?>';
        const params = new URLSearchParams({
            pagina,
            textoBusqueda: textoBusqueda,
            estado
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
                actualizarTablaClientes(data.clientes);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error al cargar clientes:', error);
                alert('Error al cargar los clientes. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner
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

        if (clientes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron clientes.</td></tr>';
            return;
        }

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
                    <!-- Opciones: Informacion de perfil, historial de conversaciones y pedidos -->
                    <a href="<?= base_url('admin/cliente/show/') ?>${cliente.id}" class="btn btn-outline-primary btn-sm m-1" title="Info. de Perfil" data-bs-toggle="tooltip">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <a href="<?= base_url('admin/cliente/conversaciones/') ?>${cliente.id}" class="btn btn-outline-info btn-sm m-1" title="Historial de Conversaciones" data-bs-toggle="tooltip">
                        <i class="bi bi-chat-left-text"></i>
                    </a>
                    <a href="<?= base_url('admin/cliente/ordenes/') ?>${cliente.id}" class="btn btn-outline-warning btn-sm m-1" title="Historial de Ordenes" data-bs-toggle="tooltip">
                        <i class="bi bi-basket"></i>
                    </a>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Re-inicializa los tooltips para los nuevos elementos de la tabla
        inicializarTooltips();
    }

    /**
     * Genera y actualiza la paginación según la página actual y el total de páginas.
     * 
     * @param {number} paginaActual Página actual.
     * @param {number} totalPaginas Total de páginas disponibles.
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
     * Crea un botón de paginación con el texto, la página destino y la acción correspondiente.
     * 
     * @param {string|number} texto Texto o número a mostrar en el botón.
     * @param {number} pagina Página a la que redirige el botón.
     * @param {string} busqueda Texto de búsqueda actual.
     * @param {string} estado Filtro de estado actual.
     * @param {boolean} activo Indica si es la página actual.
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
     * Carga los clientes de forma dinámica utilizando filtros almacenados en localStorage.
     * Se utiliza la clave 'estado_cliente' para preservar el filtro de esta vista.
     */

    function cargarClientesDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_cliente') || 'activo';
        document.getElementById('filtroEstadoCliente').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Al cambiar el select de estado, se guarda la selección y se actualiza el filtro.
    document.getElementById('filtroEstadoCliente').addEventListener('change', function() {
        localStorage.setItem('estado_cliente', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    // Al escribir en el campo de búsqueda, actualiza la tabla en tiempo real
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoCliente').value);
    });
</script>