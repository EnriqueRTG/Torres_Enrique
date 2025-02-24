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
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb de navegación -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Encabezado de la sección -->
    <header class="mb-4">
        <h1 class="mb-2">Categorías</h1>
        <p class="lead">Listado de <strong>categorías</strong> de productos registradas.</p>
    </header>

    <!-- Botón "Crear" -->
    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="#" id="crearCategoriaBtn" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal" title="Crear Categoría">
                Crear
            </a>
        </div>
    </div>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoCategoria" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoCategoria" name="estado" aria-label="Filtrar por estado">
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

    <!-- Sección de tabla y paginación -->
    <section class="my-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div class="text-center d-none m-5" id="spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Tabla de categorías -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-dark" id="tablaCategorias">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Los registros se cargarán dinámicamente mediante AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Controles de paginación -->
        <div class="text-center" id="paginacion"></div>
    </section>
</main>

<!-- Modal Crear Categoría -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="crearCategoriaModalLabel">Crear Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <form action="<?= base_url('admin/categoria/create') ?>" method="POST" id="crearCategoriaForm" role="form">
                <div class="modal-body">
                    <!-- Campo oculto para ID, en caso de edición (no se utiliza en alta) -->
                    <input type="hidden" name="id" id="crearCategoriaId">
                    <div class="mb-3">
                        <label for="crearCategoriaNombre" class="form-label">Nombre:</label>
                        <input type="text"
                            class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                            id="crearCategoriaNombre"
                            name="nombre"
                            value="<?= old('nombre') ?>">
                        <?php if (isset($errors['nombre'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['nombre'] ?>
                            </div>
                        <?php endif; ?>

                        <label for="crearCategoriaDescripcion" class="form-label">Descripción (Opcional):</label>
                        <textarea class="form-control" id="crearCategoriaDescripcion" name="descripcion" placeholder="Descripción de la Categoría"><?= old('descripcion') ?></textarea>
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

<!-- Modal Editar Categoría -->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <form action="" method="POST" id="editarCategoriaForm" role="form">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editarCategoriaId">
                    <div class="mb-3">
                        <label for="editarCategoriaNombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="editarCategoriaNombre" name="nombre" value="<?= old('nombre') ?>">
                        <!-- Si quisieras agregar validación inline en edición, la lógica sería similar -->
                        <label for="editarCategoriaDescripcion" class="form-label">Descripción (Opcional):</label>
                        <textarea class="form-control" id="editarCategoriaDescripcion" name="descripcion" placeholder="Descripción de la Categoría"><?= old('descripcion') ?></textarea>
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

<!-- Modal Eliminar Categoría -->
<div class="modal fade" id="eliminarCategoriaModal" tabindex="-1" aria-labelledby="eliminarCategoriaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h5 class="modal-title" id="eliminarCategoriaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </header>
            <div class="modal-body">
                <p class="text-wrap">
                    ¿Estás seguro de que quieres eliminar la categoría
                    <span class="fw-bolder" id="eliminarCategoriaNombre"></span>?
                </p>
            </div>
            <footer class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="" method="POST" id="eliminarCategoriaForm">
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
        cargarCategoriasDinamicamente();
    });

    /**
     * Inicializa tooltips para elementos con data-bs-toggle="modal".
     */
    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

    /**
     * Delegar eventos para botones de edición y eliminación.
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
     * Abre el modal de edición y carga los datos de la categoría.
     * @param {HTMLElement} btn - Botón que dispara la edición.
     */
    function abrirModalEditar(btn) {
        event.preventDefault();
        const categoriaId = btn.getAttribute('data-bs-id');
        const categoriaNombre = btn.getAttribute('data-bs-nombre');
        const categoriaDescripcion = btn.getAttribute('data-bs-descripcion');

        document.querySelector('#editarCategoriaId').value = categoriaId;
        document.querySelector('#editarCategoriaNombre').value = categoriaNombre;
        document.querySelector('#editarCategoriaDescripcion').value = categoriaDescripcion;
        document.querySelector('#editarCategoriaForm').action = `<?= base_url('admin/categoria/update/') ?>${categoriaId}`;

        const modal = document.querySelector('#editarCategoriaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    /**
     * Abre el modal de eliminación y asigna los datos correspondientes.
     * @param {HTMLElement} btn - Botón que dispara la eliminación.
     */
    function abrirModalEliminar(btn) {
        event.preventDefault();
        const categoriaId = btn.getAttribute('data-bs-id');
        const categoriaNombre = btn.getAttribute('data-bs-nombre');

        document.querySelector('#eliminarCategoriaNombre').textContent = categoriaNombre;
        document.querySelector('#eliminarCategoriaForm').action = `<?= base_url('admin/categoria/delete/') ?>${categoriaId}`;

        const modal = document.querySelector('#eliminarCategoriaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    /**
     * Aplica el filtro de búsqueda y estado mediante AJAX y actualiza la tabla y la paginación.
     * @param {number} pagina - Número de página a cargar.
     * @param {string} textoBusqueda - Texto de búsqueda.
     * @param {string} estado - Valor del filtro.
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/categoria/buscarCategoria") ?>';
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
                actualizarTablaCategorias(data.categorias);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las categorías. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner cuando finaliza la carga
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza el cuerpo de la tabla con las categorías recibidas.
     * @param {Array} categorias - Array de objetos categoría.
     */
    function actualizarTablaCategorias(categorias) {
        const tbody = document.querySelector('#tablaCategorias tbody');
        tbody.innerHTML = '';

        if (categorias.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron categorías.</td></tr>';
            return;
        }

        categorias.forEach(categoria => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="col-8">${categoria.nombre}</td>
                <td>
                    <span class="badge ${categoria.estado === 'activo' ? 'bg-success' : 'bg-danger'}">
                        ${categoria.estado.charAt(0).toUpperCase() + categoria.estado.slice(1)}
                    </span>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-outline-warning border-3 fw-bolder m-1 btn-editar"
                       data-bs-id="${categoria.id}"
                       data-bs-nombre="${categoria.nombre}"
                       data-bs-descripcion="${categoria.descripcion}"
                       title="Editar" data-bs-toggle="modal">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger border-3 fw-bolder m-1 btn-eliminar"
                       data-bs-id="${categoria.id}"
                       data-bs-nombre="${categoria.nombre}"
                       title="Eliminar" data-bs-toggle="modal">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Re-inicializar tooltips para nuevos elementos
        inicializarTooltips();
    }

    /**
     * Genera la paginación en base a la página actual y el total de páginas.
     * @param {number} paginaActual - Página actual.
     * @param {number} totalPaginas - Total de páginas.
     * @param {string} textoBusqueda - Texto de búsqueda aplicado.
     * @param {string} estado - Filtro aplicado.
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
     * @param {number} pagina - Página a la que redirige.
     * @param {string} textoBusqueda - Texto de búsqueda a conservar.
     * @param {string} estado - Filtro de estado a conservar.
     * @param {boolean} activo - Indica si es la página actual.
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
     * Carga las categorías de forma dinámica utilizando filtros almacenados en localStorage.
     * Se utiliza la clave 'estado_categoria' para preservar el filtro de esta vista.
     */
    function cargarCategoriasDinamicamente() {
        const estadoGuardado = localStorage.getItem('estado_categoria') || 'todos';
        document.getElementById('filtroEstadoCategoria').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Al cambiar el select de estado, se guarda la selección y se actualiza el filtro.
    document.getElementById('filtroEstadoCategoria').addEventListener('change', function() {
        localStorage.setItem('estado_categoria', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    // Al escribir en el campo de búsqueda, se actualiza el filtro.
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoCategoria').value);
    });
</script>