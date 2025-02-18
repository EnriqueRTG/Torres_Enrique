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

    <!-- Botón Crear y Búsqueda -->
    <div class="row my-4">
        <!-- Botón Crear -->
        <div class="col-auto">
            <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal" title="Crear categoría" id="crearCategoriaBtn">
                Crear
            </a>
        </div>
        <!-- Búsqueda -->
        <div class="col-auto ms-auto">
            <form class="d-inline-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-primary border-3 fw-bold" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Filtro -->
    <div class="row">
        <div class="col-md-2 offset-md-10 mb-3">
            <select id="filtroEstado" class="form-select">
                <option value="todos">Todas</option>
                <option value="activo">Activas</option>
                <option value="inactivo">Inactivas</option>
            </select>
        </div>
    </div>

    <!-- Spinner de carga -->
    <div class="text-center d-none m-5" id="spinner">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Tabla de categorias -->
    <div class="table-responsive">
        <!-- Tabla -->
        <table class="table table-striped table-hover table-dark" id="tablaCategorias">
            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-capitalize text-center align-middle">
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody class="text-center align-middle">
                <!-- Se carga dinamicamente con JS y AJAX -->
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="text-center" id="paginacion">
        </div>
    </div>
</main>

<!-- Modal Crear -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearCategoriaModalLabel">Crear Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/categoria/create') ?>" method="POST" id="crearCategoriaForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="crearCategoriaId">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="crearCategoriaNombre" name="nombre">
                        <label for="descripcion" class="form-label">Descripcion (Opcional):</label>
                        <textarea class="form-control" id="crearCategoriaDescripcion" name="descripcion" placeholder="Descripcion de la Categoría"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" id="editarCategoriaForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editarCategoriaId">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="editarCategoriaNombre" name="nombre">
                        <label for="descripcion" class="form-label">Descripción (Opcional):</label>
                        <textarea class="form-control" id="editarCategoriaDescripcion" name="descripcion" placeholder="Descripción de la Categoría"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Editar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarCategoriaModal" tabindex="-1" aria-labelledby="eliminarCategoriaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="eliminarCategoriaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-wrap">¿Estás seguro de que quieres eliminar la categoría <span class="fw-bolder" id="eliminarCategoriaNombre"></span>?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="" method="POST" id="eliminarCategoriaForm">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Vista parcial header -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarCategoriasDinamicas();
    });

    function inicializarTooltips() {
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    }

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

    function abrirModalEditar(btn) {
        event.preventDefault(); // Evita el comportamiento predeterminado si es un botón dentro de un formulario

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

    function abrirModalEliminar(btn) {
        event.preventDefault(); // Evita el comportamiento predeterminado si es un botón dentro de un formulario

        const categoriaId = btn.getAttribute('data-bs-id');
        const categoriaNombre = btn.getAttribute('data-bs-nombre');

        document.querySelector('#eliminarCategoriaNombre').textContent = categoriaNombre;
        document.querySelector('#eliminarCategoriaForm').action = `<?= base_url('admin/categoria/delete/') ?>${categoriaId}`;

        const modal = document.querySelector('#eliminarCategoriaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/categoria/buscarCategoria") ?>';
        const params = new URLSearchParams({
            pagina,
            texto: textoBusqueda,
            estado
        });

        // Mostrar el spinner antes de cargar
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
                // Ocultar el spinner cuando termine la carga
                document.getElementById('spinner').classList.add('d-none');
            });
    }

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

        inicializarTooltips();
    }

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

    function cargarCategoriasDinamicas() {
        const estadoGuardado = localStorage.getItem('estado') || 'todos';
        document.getElementById('filtroEstado').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    document.getElementById('filtroEstado').addEventListener('change', function() {
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstado').value);
    });
</script>