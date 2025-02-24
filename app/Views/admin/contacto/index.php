<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Se incluye la barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Título y descripción de la sección -->
    <h1 class="mb-4">Contactos</h1>
    <p class="lead">Listado de conversaciones de tipo <strong>contacto</strong>.</p>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoContacto" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoContacto" name="estado" aria-label="Filtrar por estado">
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <option value="cerrada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'cerrada') ? 'selected' : '' ?>>Cerradas</option>
                <option value="todas" <?= (!isset($_GET['estado']) || $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
            </select>
        </div>
        <!-- Buscador: filtra por nombre y/o asunto -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o asunto:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese nombre o asunto" value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón para enviar el filtro -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
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

    <!-- Tabla de conversaciones -->
    <div class="table-responsive" id="tablaContactos">
        <table class="table table-striped table-hover table-dark">
            <!-- Encabezados de la tabla -->
            <thead>
                <tr class="text-capitalize text-center align-middle">
                    <th>Nombre / Email</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody class="text-center align-middle">
                <!-- Los registros se cargarán dinámicamente mediante AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="text-center" id="paginacion"></div>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts para cargar y filtrar conversaciones -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        cargarContactosDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para los elementos que tengan data-bs-toggle="tooltip".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Aplica los filtros (página, búsqueda y estado) y realiza una solicitud AJAX para obtener
     * las conversaciones filtradas.
     * @param {number} pagina - Número de página a cargar (por defecto 1).
     * @param {string} textoBusqueda - Texto de búsqueda (por defecto cadena vacía).
     * @param {string} estado - Estado a filtrar ( 'pendiente', 'todas' o 'cerrada').
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todas') {
        // Genera la URL usando el alias de la ruta
        const url = '<?= base_url("admin/conversacion/buscar_contactos") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            textoBusqueda: textoBusqueda,
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
                actualizarTablaContactos(data.contactos);
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
     * Cada conversación muestra un badge con su estado:
     * - "Pendiente" para conversaciones abiertas.
     * - "Cerrada" para conversaciones cerradas.
     *
     * Además, se asignan clases a la fila según el estado:
     * - 'table-warning' para pendientes.
     * - 'table-secondary' para cerradas.
     *
     * @param {Array} conversaciones - Array de objetos de conversaciones.
     */
    function actualizarTablaContactos(contactos) {
        const tbody = document.querySelector('#tablaContactos tbody');
        tbody.innerHTML = '';

        if (contactos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron conversaciones.</td></tr>';
            return;
        }

        contactos.forEach(contacto => {
            // Determinar el estado visual basado en el campo 'estado'
            const estadoVisual = (contacto.estado === 'cerrada') ? 'Cerrada' : 'Pendiente';
            const claseFila = (contacto.estado === 'cerrada') ? 'table-secondary' : 'table-warning';
            const badgeClass = (contacto.estado === 'cerrada') ? 'bg-secondary' : 'bg-warning text-dark';

            const tr = document.createElement('tr');
            tr.className = claseFila;
            tr.innerHTML = `
                <td>
                    ${contacto.nombre} <br>
                    <small>${contacto.email}</small>
                </td>
                <td>${contacto.asunto}</td>
                <td>${new Date(contacto.created_at).toLocaleString()}</td>
                <td>
                    <span class="badge ${badgeClass}">
                        ${estadoVisual}
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('admin/conversaciones/contactos') ?>/${contacto.id}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Ver conversación">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    /**
     * Genera los controles de paginación basados en la página actual y el total de páginas.
     * @param {number} paginaActual - Página actualmente visualizada.
     * @param {number} totalPaginas - Total de páginas disponibles.
     * @param {string} textoBusqueda - Texto de búsqueda aplicado.
     * @param {string} estado - Filtro de estado aplicado.
     */
    function generarPaginacion(paginaActual, totalPaginas, textoBusqueda, estado) {
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
            fragment.appendChild(crearBotonPaginacion('Anterior', paginaActual - 1, textoBusqueda, estado));
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            fragment.appendChild(crearBotonPaginacion(i, i, textoBusqueda, estado, i === paginaActual));
        }

        if (paginaActual < totalPaginas) {
            fragment.appendChild(crearBotonPaginacion('Siguiente', paginaActual + 1, textoBusqueda, estado));
        }

        paginacionContainer.appendChild(fragment);
    }

    /**
     * Crea un botón (enlace) de paginación.
     * @param {string|number} texto - Texto o número a mostrar en el botón.
     * @param {number} pagina - Página a la que se dirigirá al hacer clic.
     * @param {string} textoBusqueda - Texto de búsqueda que se mantiene.
     * @param {string} estado - Filtro de estado que se mantiene.
     * @param {boolean} activo - Indica si el botón corresponde a la página actual.
     * @returns {HTMLElement} Elemento de enlace con comportamiento de paginación.
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
     * Carga las conversaciones de forma dinámica utilizando los filtros almacenados (si existen).
     */
    function cargarContactosDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_contacto') || 'pendiente';
        document.getElementById('filtroEstadoContacto').value = estadoGuardado;
        aplicarFiltro(1, document.getElementById('busqueda').value, estadoGuardado);
    }

    document.getElementById('filtroEstadoContacto').addEventListener('change', function() {
        localStorage.setItem('estado_contacto', this.value);
        aplicarFiltro(1, document.getElementById('busqueda').value, this.value);
    });

    document.getElementById('busqueda').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoContacto').value);
    });
</script>