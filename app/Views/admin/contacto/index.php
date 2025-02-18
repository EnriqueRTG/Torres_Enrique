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

    <!-- Formulario de filtros y buscador (usando GET para que los parámetros queden en la URL) -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstado" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstado" name="estado">
                <option value="todos" <?= (!isset($_GET['estado']) || $_GET['estado'] == 'todos') ? 'selected' : '' ?>>Todos</option>
                <!-- Se asume que 'pendiente' corresponde a estado 'abierto' -->
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <!-- Se asume que 'respondido' corresponde a estado 'cerrado' -->
                <option value="respondido" <?= (isset($_GET['estado']) && $_GET['estado'] == 'respondido') ? 'selected' : '' ?>>Respondidos</option>
            </select>
        </div>
        <!-- Buscador: filtra por nombre del remitente y/o asunto -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o asunto:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" value="<?= esc(isset($_GET['busqueda']) ? $_GET['busqueda'] : '') ?>" placeholder="Ingrese nombre o asunto">
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
    <div class="table-responsive" id="tablaConversaciones">
        <!-- Tabla -->
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
    <div class="text-center" id="paginacion">
    </div>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Bootstrap Bundle JS -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Scripts para cargar y filtrar conversaciones -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        cargarConversacionesDinamicamente();
        // reinicializarDropdowns();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos con data-bs-toggle="modal" o similares.
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Aplica los filtros (página, búsqueda y estado) y realiza una solicitud AJAX
     * para obtener las conversaciones filtradas.
     * @param {number} pagina - Número de página a cargar (por defecto 1).
     * @param {string} textoBusqueda - Texto de búsqueda (por defecto cadena vacía).
     * @param {string} estado - Estado a filtrar ('todos', 'pendiente' o 'respondido').
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        // Genera la URL usando el alias de la ruta.
        const url = '<?= base_url("admin/conversacion/buscar_contactos") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            busqueda: textoBusqueda,
            estado: estado
        });

        // Mostrar el spinner de carga
        document.getElementById('spinner').classList.remove('d-none');

        fetch(`${url}?${params.toString()}`, {
                method: 'GET', // Asegúrate de usar GET si la ruta está definida como GET
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Intentar parsear la respuesta como JSON
                return response.json();
            })
            .then(data => {
                actualizarTablaConversaciones(data.conversaciones);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
                // reinicializarDropdowns();
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
     * @param {Array} conversaciones - Array de objetos de conversaciones.
     */
    function actualizarTablaConversaciones(conversaciones) {
        const tbody = document.querySelector('#tablaConversaciones tbody');
        tbody.innerHTML = '';

        if (conversaciones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron conversaciones.</td></tr>';
            return;
        }

        conversaciones.forEach(conv => {
            // Convertir estado de base de datos a visual:
            // 'abierto' -> "Pendiente", 'cerrado' -> "Respondido"
            let estadoVisual = (conv.estado === 'abierto') ? 'Pendiente' : 'Respondido';
            // Aplicar clases de color: 'table-warning' para pendiente, 'table-success' para respondido.
            let claseFila = (conv.estado === 'abierto') ? 'table-warning' : 'table-success';

            // Crear una fila y sus columnas
            const tr = document.createElement('tr');
            tr.className = claseFila;
            tr.innerHTML = `
            <td>
                ${conv.nombre} <br>
                <small>${conv.email}</small>
            </td>
            <td>${conv.asunto}</td>
            <td>${new Date(conv.created_at).toLocaleString()}</td>
            <td>
                <span class="badge ${conv.estado === 'abierto' ? 'bg-warning text-dark' : 'bg-success'}">
                    ${estadoVisual}
                </span>
            </td>
            <td>
                <a href="<?= base_url('admin/conversaciones/contactos/') ?>/${conv.id}" class="btn btn-sm btn-primary" title="Ver conversación">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        `;
            tbody.appendChild(tr);
        });
    }

    /**
     * Genera los controles de paginación basados en la página actual y el total de páginas.
     * @param {number} paginaActual - La página actualmente visualizada.
     * @param {number} totalPaginas - El total de páginas disponibles.
     * @param {string} textoBusqueda - El texto de búsqueda aplicado.
     * @param {string} estado - El filtro de estado aplicado.
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
     * @param {string|number} texto - El texto o número que se mostrará en el botón.
     * @param {number} pagina - La página a la que se debe ir al hacer clic.
     * @param {string} textoBusqueda - El texto de búsqueda que se mantiene.
     * @param {string} estado - El filtro de estado que se mantiene.
     * @param {boolean} activo - Si el botón corresponde a la página actual.
     * @returns {HTMLElement} El elemento de enlace con el comportamiento de paginación.
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
    function cargarConversacionesDinamicamente() {
        // Se recupera el valor guardado en localStorage o se usa 'todos'
        const estadoGuardado = localStorage.getItem('estado') || 'todos';
        document.getElementById('filtroEstado').value = estadoGuardado;
        // También se puede obtener el valor del buscador si se desea, en este ejemplo se usa cadena vacía
        aplicarFiltro(1, document.getElementById('busqueda').value, estadoGuardado);
    }

    // Actualiza el filtro cuando se cambia el select de estado
    document.getElementById('filtroEstado').addEventListener('change', function() {
        // Guardar el valor en localStorage (opcional)
        localStorage.setItem('estado', this.value);
        aplicarFiltro(1, document.getElementById('busqueda').value, this.value);
    });

    // Actualiza el filtro conforme se escribe en el buscador
    document.getElementById('busqueda').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstado').value);
    });

    /* function reinicializarDropdowns() {
        document.querySelectorAll('.dropdown-toggle').forEach(function(el) {
            // Crea o reinicializa la instancia de dropdown de Bootstrap
            new bootstrap.Dropdown(el);
        });
    } */

    document.addEventListener("DOMContentLoaded", function() {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('mouseover', function() {
                const toggle = this.querySelector('.dropdown-toggle');
                if (!toggle.classList.contains('show')) {
                    const dropdownMenu = new bootstrap.Dropdown(toggle);
                    dropdownMenu.show();
                }
            });

            dropdown.addEventListener('mouseleave', function() {
                const toggle = this.querySelector('.dropdown-toggle');
                if (toggle.classList.contains('show')) {
                    const dropdownMenu = new bootstrap.Dropdown(toggle);
                    dropdownMenu.hide();
                }
            });
        });
    });
</script>