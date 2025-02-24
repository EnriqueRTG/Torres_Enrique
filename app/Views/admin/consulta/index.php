<!-- Vista: Listado de consultas del Administrador para Consultas -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión (errores o confirmaciones) -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Consultas</h1>
        <p class="lead">Listado de consultas de tipo <strong>consulta</strong>.</p>
    </header>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoConsulta" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoConsulta" name="estado" aria-label="Filtrar por estado">
                <!-- Se preserva la selección utilizando GET -->
                <option value="pendiente" <?= (isset($_GET['estado']) && $_GET['estado'] == 'pendiente') ? 'selected' : '' ?>>Pendientes</option>
                <option value="respondida" <?= (isset($_GET['estado']) && $_GET['estado'] == 'respondida') ? 'selected' : '' ?>>Respondidas</option>
                <option value="eliminada" <?= (isset($_GET['estado']) && $_GET['estado'] == 'eliminada') ? 'selected' : '' ?>>Eliminadas</option>
                <option value="todas" <?= (!isset($_GET['estado']) || $_GET['estado'] == 'todas') ? 'selected' : '' ?>>Todas</option>
            </select>
        </div>
        <!-- Buscador: filtra por nombre y/o asunto -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o asunto:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda"
                placeholder="Ingrese nombre o asunto"
                value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
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

    <!-- Tabla de consultas -->
    <div class="table-responsive" id="tablaConsultas">
        <table class="table table-striped table-hover table-dark">
            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-capitalize text-center align-middle">
                    <th scope="col">Nombre / Email</th>
                    <th scope="col">Asunto</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla: se cargará dinámicamente mediante AJAX -->
            <tbody class="text-center align-middle">
                <!-- Se insertarán las filas dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Controles de paginación -->
    <div class="d-flex justify-content-center" id="paginacion"></div>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts -->
<script>
    // Inicialización al cargar el DOM
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        cargarConsultasDinamicamente();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos que tengan el atributo data-bs-toggle="tooltip".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Realiza una solicitud AJAX para obtener las consultas filtradas según los parámetros,
     * y actualiza la tabla y la paginación.
     *
     * @param {number} pagina - Página actual a cargar (por defecto 1).
     * @param {string} textoBusqueda - Texto de búsqueda (por defecto cadena vacía).
     * @param {string} estado - Filtro de estado ('todas', 'pendiente', 'respondida' o 'cerrada').
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todas') {
        // Construir la URL con parámetros
        const url = '<?= base_url("admin/conversacion/buscar_consultas") ?>';
        const params = new URLSearchParams({
            pagina: pagina,
            textoBusqueda: textoBusqueda,
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
                actualizarTablaConsultas(data.consultas);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las consultas. Inténtalo de nuevo.');
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
    function actualizarTablaConsultas(consultas) {
        const tbody = document.querySelector('#tablaConsultas tbody');
        tbody.innerHTML = '';

        if (consultas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No se encontraron consultas.</td></tr>';
            return;
        }

        consultas.forEach(consulta => {
            let estadoVisual = '';
            let claseFila = '';
            let badgeClass = '';

            // Determinar el estado visual basado en el campo 'estado' y el último mensaje (si existe)
            if (consulta.estado === 'cerrada') {
                estadoVisual = 'Cerrada';
                claseFila = 'table-secondary';
                badgeClass = 'bg-secondary';
            } else if (consulta.ultimoMensaje && consulta.ultimoMensaje.tipo_remitente === 'administrador') {
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
            tr.innerHTML = `
                <td>
                    ${consulta.nombre} <br>
                    <small>${consulta.email}</small>
                </td>
                <td>${consulta.asunto}</td>
                <td>${new Date(consulta.created_at).toLocaleString()}</td>
                <td>
                    <span class="badge ${badgeClass}">
                        ${estadoVisual}
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('admin/conversaciones/consultas') ?>/${consulta.id}" 
                       class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Ver conversación">
                        <i class="bi bi-eye"></i>
                    </a>
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
     * Crea un botón de paginación.
     *
     * @param {string|number} texto - Texto o número a mostrar en el botón.
     * @param {number} pagina - Página a la que redirige el botón.
     * @param {string} textoBusqueda - Texto de búsqueda a conservar.
     * @param {string} estado - Filtro de estado a conservar.
     * @param {boolean} activo - Indica si el botón corresponde a la página actual.
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
     * Carga las consultas de forma dinámica utilizando el valor guardado en localStorage.
     *
     * Se utiliza la clave "estado_consulta" para preservar la selección en esta vista.
     */
    function cargarConsultasDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_consulta') || 'todas';
        document.getElementById('filtroEstadoConsulta').value = estadoGuardado;
        aplicarFiltro(1, document.getElementById('busqueda').value, estadoGuardado);
    }

    // Actualizar el filtro cuando se cambia el select de estado
    document.getElementById('filtroEstadoConsulta').addEventListener('change', function() {
        localStorage.setItem('estado_consulta', this.value);
        aplicarFiltro(1, document.getElementById('busqueda').value, this.value);
    });

    // Actualizar el filtro en tiempo real al escribir en el campo de búsqueda
    document.getElementById('busqueda').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoConsulta').value);
    });
</script>