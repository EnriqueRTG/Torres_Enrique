<!-- Vista parcial: Header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<?php
// Recuperar los errores de validación enviados como flashdata, si existen.
$errors = session()->getFlashdata('errors');
?>

<!-- Contenido principal -->
<main class="container my-3 main-content">

    <!-- Mensajes de sesión (errores o confirmaciones) -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Marcas</h1>
        <p class="lead">Listado de <strong>marcas</strong> de productos registradas.</p>
    </header>

    <!-- Botón "Crear" para invocar el modal de creación de marca -->
    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="#" id="crearMarcaBtn" data-bs-toggle="modal" data-bs-target="#crearMarcaModal" title="Crear marca">
                Crear
            </a>
        </div>
    </div>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoMarca" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoMarca" name="estado" aria-label="Filtrar marcas por estado">
                <option value="todos" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todos') ? 'selected' : '' ?>>Todas</option>
                <option value="activo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'activo') ? 'selected' : '' ?>>Activas</option>
                <option value="inactivo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivas</option>
            </select>
        </div>
        <!-- Buscador por nombre o descripción -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o descripción:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese nombre o descripción" value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Sección: Tabla de marcas y paginación -->
    <section class="my-4">
        <!-- Spinner de carga (inicialmente oculto) -->
        <div class="text-center d-none m-5" id="spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <!-- Contenedor responsive para la tabla -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaMarcas">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Las filas se cargarán dinámicamente mediante AJAX -->
                </tbody>
            </table>
        </div>
        <!-- Controles de paginación -->
        <div class="text-center" id="paginacion"></div>
    </section>
</main>

<!-- Modal Crear Marca -->
<div class="modal fade" id="crearMarcaModal" tabindex="-1" aria-labelledby="crearMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="crearMarcaModalLabel">Crear Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <form action="<?= base_url('admin/marca/create') ?>" method="POST" id="crearMarcaForm" role="form">
                <div class="modal-body">
                    <!-- Campo oculto para ID (si fuera necesario para edición) -->
                    <input type="hidden" name="id" id="crearMarcaId">
                    <div class="mb-3">
                        <label for="crearMarcaNombre" class="form-label">Nombre:</label>
                        <input type="text"
                            class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                            id="crearMarcaNombre"
                            name="nombre"
                            value="<?= old('nombre') ?>">
                        <?php if (isset($errors['nombre'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['nombre'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Guardar</button>
                </footer>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Marca -->
<div class="modal fade" id="editarMarcaModal" tabindex="-1" aria-labelledby="editarMarcaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="editarMarcaModalLabel">Editar Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <form action="" method="POST" id="editarMarcaForm" role="form">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editarMarcaId">
                    <div class="mb-3">
                        <label for="editarMarcaNombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="editarMarcaNombre" name="nombre">
                        <label for="editarMarcaDescripcion" class="form-label">Descripción (Opcional):</label>
                        <textarea class="form-control" id="editarMarcaDescripcion" name="descripcion" placeholder="Descripción de la Marca"></textarea>
                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Editar</button>
                </footer>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Marca -->
<div class="modal fade" id="eliminarMarcaModal" tabindex="-1" aria-labelledby="eliminarMarcaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="eliminarMarcaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <div class="modal-body">
                <p class="text-wrap">¿Estás seguro de que quieres eliminar la marca <span class="fw-bolder" id="eliminarMarcaNombre"></span>?</p>
            </div>
            <footer class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="" method="POST" id="eliminarMarcaForm">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </footer>
        </div>
    </div>
</div>

<!-- Vista parcial: Footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarMarcasDinamicas();
    });

    /**
     * Inicializa los tooltips para elementos con data-bs-toggle="modal".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Delegar eventos para los botones de edición y eliminación.
     */
    function delegarEventosModales() {
        document.addEventListener('click', function(event) {
            const btnEditar = event.target.closest('.btn-editar');
            const btnEliminar = event.target.closest('.btn-eliminar');
            if (btnEditar) {
                abrirModalEditar(btnEditar);
            }
            if (btnEliminar) {
                abrirModalEliminar(btnEliminar);
            }
        });
    }

    /**
     * Abre el modal de edición y carga los datos correspondientes.
     * @param {HTMLElement} btn - Botón que dispara la edición.
     */
    function abrirModalEditar(btn) {
        event.preventDefault();
        const marcaId = btn.getAttribute('data-bs-id');
        const marcaNombre = btn.getAttribute('data-bs-nombre');
        const marcaDescripcion = btn.getAttribute('data-bs-descripcion');

        document.querySelector('#editarMarcaId').value = marcaId;
        document.querySelector('#editarMarcaNombre').value = marcaNombre;
        document.querySelector('#editarMarcaDescripcion').value = marcaDescripcion;
        document.querySelector('#editarMarcaForm').action = `<?= base_url('admin/marca/update/') ?>${marcaId}`;

        const modal = document.querySelector('#editarMarcaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    /**
     * Abre el modal de eliminación y asigna los datos correspondientes.
     * @param {HTMLElement} btn - Botón que dispara la eliminación.
     */
    function abrirModalEliminar(btn) {
        event.preventDefault();
        const marcaId = btn.getAttribute('data-bs-id');
        const marcaNombre = btn.getAttribute('data-bs-nombre');

        document.querySelector('#eliminarMarcaNombre').textContent = marcaNombre;
        document.querySelector('#eliminarMarcaForm').action = `<?= base_url('admin/marca/delete/') ?>${marcaId}`;

        const modal = document.querySelector('#eliminarMarcaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    /**
     * Aplica el filtro de búsqueda y estado mediante AJAX y actualiza la tabla y la paginación.
     * @param {number} pagina - Número de página.
     * @param {string} textoBusqueda - Texto de búsqueda.
     * @param {string} estado - Valor del filtro de estado.
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/marca/buscarMarca") ?>';
        const params = new URLSearchParams({
            pagina,
            textoBusqueda: textoBusqueda,
            estado
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
                actualizarTablaMarcas(data.marcas);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las marcas. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza el cuerpo de la tabla con las marcas recibidas.
     * @param {Array} marcas - Array de objetos marca.
     */
    function actualizarTablaMarcas(marcas) {
        const tbody = document.querySelector('#tablaMarcas tbody');
        tbody.innerHTML = '';

        if (marcas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron marcas.</td></tr>';
            return;
        }

        marcas.forEach(marca => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="col-8">${marca.nombre}</td>
                <td>
                    <span class="badge ${marca.estado === 'activo' ? 'bg-success' : 'bg-danger'}">
                        ${marca.estado.charAt(0).toUpperCase() + marca.estado.slice(1)}
                    </span>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-outline-warning border-3 fw-bolder m-1 btn-editar"
                       data-bs-id="${marca.id}"
                       data-bs-nombre="${marca.nombre}"
                       data-bs-descripcion="${marca.descripcion}"
                       title="Editar" data-bs-toggle="modal">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger border-3 fw-bolder m-1 btn-eliminar"
                       data-bs-id="${marca.id}"
                       data-bs-nombre="${marca.nombre}"
                       title="Eliminar" data-bs-toggle="modal">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Re-inicializar tooltips en caso de que se hayan añadido nuevos elementos.
        inicializarTooltips();
    }

    /**
     * Genera la paginación en base a la página actual y el total de páginas.
     * @param {number} paginaActual - Página actual.
     * @param {number} totalPaginas - Total de páginas disponibles.
     * @param {string} textoBusqueda - Texto de búsqueda.
     * @param {string} estado - Filtro de estado.
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
     * @param {string|number} texto - Texto a mostrar en el botón.
     * @param {number} pagina - Página a la que se dirigirá.
     * @param {string} textoBusqueda - Texto de búsqueda que se conserva.
     * @param {string} estado - Filtro de estado que se conserva.
     * @param {boolean} activo - Indica si es el botón de la página actual.
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
     * Carga las marcas de forma dinámica utilizando filtros almacenados en localStorage.
     * Se utiliza la clave 'estado_marca' para evitar colisiones con otras vistas.
     */
    function cargarMarcasDinamicas() {
        const estadoGuardado = localStorage.getItem('estado_marca') || 'todos';
        document.getElementById('filtroEstadoMarca').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Al cambiar el select de estado, se guarda la selección y se actualiza el filtro.
    document.getElementById('filtroEstadoMarca').addEventListener('change', function() {
        localStorage.setItem('estado_marca', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    // Al escribir en el campo de búsqueda, se actualiza el filtro.
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoMarca').value);
    });
</script>