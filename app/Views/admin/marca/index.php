<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal -->
<section class="container py-5">

    <!-- Mensajes de sesión -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Botón Crear y Búsqueda -->
    <div class="row my-4">
        <!-- Botón Crear -->
        <div class="col-auto">
            <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#crearMarcaModal" title="Crear marca" id="crearMarcaBtn">
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
        <div class="col-md-2 offset-md-10">
            <select id="filtroEstado" class="form-select">
                <option value="todos">Todas</option>
                <option value="activo">Activas</option>
                <option value="inactivo">Inactivas</option>
            </select>
        </div>
    </div>

    <!-- Tabla de marcas -->
    <div class="my-4">
        <!-- Spinner de carga -->
        <div class="text-center d-none m-5" id="spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <!-- Tabla -->
        <table class="table table-dark table-striped table-hover table-responsive" id="tablaMarcas">
            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <!-- Cuerpo de la tabla -->
            <tbody class="text-center">
                <!-- Se carga dinamicamente JS y AJAX -->
                <tr>
                </tr>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="text-center" id="paginacion">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </div>
</section>

<!-- Modal Crear -->
<div class="modal fade" id="crearMarcaModal" tabindex="-1" aria-labelledby="crearMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearMarcaModalLabel">Crear Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/marca/create') ?>" method="POST" id="crearMarcaForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="crearMarcaId">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="crearMarcaNombre" name="nombre">
                        <label for="descripcion" class="form-label">Descripcion (Opcional):</label>
                        <textarea class="form-control" id="crearMarcaDescripcion" name="descripcion" placeholder="Descripcion de la Categoría"></textarea>
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
<div class="modal fade" id="editarMarcaModal" tabindex="-1" aria-labelledby="editarMarcaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editarMarcaModalLabel">Editar Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" id="editarMarcaForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="editarMarcaId">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="editarMarcaNombre" name="nombre">
                        <label for="descripcion" class="form-label">Descripción (Opcional):</label>
                        <textarea class="form-control" id="editarMarcaDescripcion" name="descripcion" placeholder="Descripción de la Categoría"></textarea>
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
<div class="modal fade" id="eliminarMarcaModal" tabindex="-1" aria-labelledby="eliminarMarcaModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarMarcaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Cuerpo del modal: se completará dinámicamente con el nombre de la  categoría-->
            <div class="modal-body">
                <p class="text-wrap">
                    ¿Estás seguro de que quieres eliminar la categoría 
                    <span class="fw-bolder" id="eliminarMarcaNombre"></span>?
                </p>
            </div>
            <!-- Pie del modal: formulario para confirmar eliminación -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="" method="POST" id="eliminarMarcaForm">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarMarcasDinamicas();
    });

    function inicializarTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
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

    function abrirModalEliminar(btn) {
        event.preventDefault(); // Evita el comportamiento predeterminado si es un botón dentro de un formulario

        const marcaId = btn.getAttribute('data-bs-id');
        const marcaNombre = btn.getAttribute('data-bs-nombre');

        document.querySelector('#eliminarMarcaNombre').textContent = marcaNombre;
        document.querySelector('#eliminarMarcaForm').action = `<?= base_url('admin/marca/delete/') ?>${marcaId}`;

        const modal = document.querySelector('#eliminarMarcaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    }

    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/marca/buscarMarca") ?>';
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
                actualizarTablaMarcas(data.marcas);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las marcas. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner cuando termine la carga
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    function actualizarTablaMarcas(marcas) {
        const tbody = document.querySelector('#tablaMarcas tbody');
        tbody.innerHTML = '';

        marcas.forEach(marca => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
            <td class="col-8">${marca.nombre}</td>
            <td>
                <span class="badge ${marca.estado === 'activo' ? 'bg-success' : 'bg-danger'}">
                    ${marca.estado.charAt(0).toUpperCase() + marca.estado.slice(1)}
                </span>
            </td>
            <td class="text-center g-2">
                <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1 btn-editar"
                   data-bs-id="${marca.id}"
                   data-bs-nombre="${marca.nombre}"
                   data-bs-descripcion="${marca.descripcion}"
                   title="Editar" data-bs-toggle="modal">
                   <i class="bi bi-pencil-square"></i>
                </a>
                <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1 btn-eliminar"
                   data-bs-id="${marca.id}"
                   data-bs-nombre="${marca.nombre}"
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

    function cargarMarcasDinamicas() {
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