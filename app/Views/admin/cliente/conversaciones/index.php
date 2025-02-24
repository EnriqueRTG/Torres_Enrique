<!-- Vista parcial: Header Admin -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación Admin -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal: Se utiliza <main> para delimitar el contenido principal -->
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
        <h1 class="mb-2">Conversaciones</h1>
        <p class="lead">Listado de <strong>conversaciones</strong> registradas del cliente.</p>
    </header>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoConversaciones" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoConversaciones" name="estado" aria-label="Filtrar por estado">
                <option value="activa" <?= (isset($_GET['estado']) && $_GET['estado'] == 'activa') ? 'selected' : '' ?>>Activas</option>
                <option value="inactiva" <?= (isset($_GET['estado']) && $_GET['estado'] == 'inactiva') ? 'selected' : '' ?>>Inactivas</option>
                <option value="todas" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
            </select>

        </div>
        <!-- Buscador por asunto o email -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por Asunto o Email:</label>
            <input type="search" class="form-control" id="busqueda" name="textoBusqueda" placeholder="Ingrese Asunto o Email" value="<?= isset($_GET['textoBusqueda']) ? esc($_GET['textoBusqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Sección: Tabla de Conversaciones y Paginación -->
    <section class="mb-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div id="spinner" class="text-center d-none my-5" aria-live="polite">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <!-- Tabla de Conversaciones -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaConversaciones">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Asunto</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Actualización</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
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

<!-- Vista parcial: Footer Admin -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para filtrar, buscar y paginar conversaciones -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips (si se usan en elementos dinámicos)
        inicializarTooltips();
        // Carga inicial de conversaciones con filtro por defecto
        cargarConversacionesDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos con data-bs-toggle="tooltip".
     */
    function inicializarTooltips() {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    /**
     * Envía una solicitud AJAX para filtrar y buscar conversaciones, actualizando la tabla y la paginación.
     *
     * @param {number} pagina Número de página a cargar.
     * @param {string} textoBusqueda Texto de búsqueda.
     * @param {string} estado Filtro de estado ("abierta", "cerrada" o "todas").
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todas') {
        const clienteId = document.getElementById('tablaConversaciones').dataset.clienteId;
        const url = '<?= base_url("admin/cliente/buscarConversacion") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            textoBusqueda: textoBusqueda,
            estado: estado,
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
                actualizarTablaConversaciones(data.conversaciones);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
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
     * Actualiza el cuerpo de la tabla con las conversaciones recibidas.
     *
     * @param {Array} conversaciones Arreglo de objetos conversación.
     */
    function actualizarTablaConversaciones(conversaciones) {
        const tbody = document.querySelector('#tablaConversaciones tbody');
        tbody.innerHTML = '';

        if (conversaciones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron conversaciones.</td></tr>';
            return;
        }

        conversaciones.forEach(conversacion => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
            <td class="col-8">${conversacion.asunto}</td>
            <td class="align-middle">${new Date(conversacion.created_at).toLocaleString()}</td>
            <td class="align-middle">${new Date(conversacion.updated_at).toLocaleString()}</td>
            <td class="align-middle">
                <span class="badge ${conversacion.estado === 'activa' ? 'bg-success' : 'bg-danger'}">
                    ${conversacion.estado.charAt(0).toUpperCase() + conversacion.estado.slice(1)}
                </span>
            </td>
            <td class="text-center align-middle">
                <a href="<?= base_url('admin/cliente/conversaciones/mostrar/') ?>${conversacion.id}" 
                   class="btn btn-sm btn-outline-info border-3 fw-bolder m-1" 
                   data-bs-toggle="tooltip" title="Ver Conversación">
                    <i class="bi bi-eye-fill"></i>
                </a>
            </td>
        `;
            tbody.appendChild(tr);
        });

        inicializarTooltips();
    }

    /**
     * Genera y actualiza la paginación según la página actual y el total de páginas.
     *
     * @param {number} paginaActual Página actual.
     * @param {number} totalPaginas Total de páginas.
     * @param {string} textoBusqueda Texto de búsqueda aplicado.
     * @param {string} estado Filtro aplicado.
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
     * @param {string|number} texto Texto o número a mostrar.
     * @param {number} pagina Página a la que redirige.
     * @param {string} textoBusqueda Texto de búsqueda actual.
     * @param {string} estado Filtro de estado actual.
     * @param {boolean} activo Indica si es la página actual.
     * @returns {HTMLElement} Botón de paginación.
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
     * Carga las conversaciones de forma dinámica utilizando un filtro almacenado en localStorage.
     * Se utiliza la clave 'estado_conversacion' para preservar el filtro de esta vista.
     */
    function cargarConversacionesDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_conversacion') || 'activa';
        document.getElementById('filtroEstadoConversaciones').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Al cambiar el select de estado, guardar la selección y actualizar el filtro.
    document.getElementById('filtroEstadoConversaciones').addEventListener('change', function() {
        localStorage.setItem('estado_conversacion', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    // Al escribir en el campo de búsqueda, actualizar la tabla en tiempo real.
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoConversaciones').value);
    });
</script>