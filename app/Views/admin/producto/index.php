<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

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
        <h1 class="mb-2">Productos</h1>
        <p class="lead">Listado de <strong>productos</strong> registrados.</p>
    </header>

    <!-- Botón "Crear" -->
    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="<?= base_url('admin/productos/crear') ?>"
                data-bs-toggle="tooltip" title="Crear producto" id="crearProductoBtn">
                Crear
            </a>
        </div>
    </div>

    <!-- Formulario de filtros y buscador -->
    <form method="get" action="<?= current_url() ?>" class="row g-3 mb-4" role="search">
        <!-- Filtro por estado -->
        <div class="col-12 col-md-4">
            <label for="filtroEstadoProducto" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="filtroEstadoProducto" name="estado" aria-label="Filtrar por estado">
                <option value="todos" <?= (isset($_GET['estado']) && $_GET['estado'] == 'todos') ? 'selected' : '' ?>>Todos</option>
                <option value="activo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'activo') ? 'selected' : '' ?>>Activos</option>
                <option value="inactivo" <?= (isset($_GET['estado']) && $_GET['estado'] == 'inactivo') ? 'selected' : '' ?>>Inactivos</option>
            </select>
        </div>
        <!-- Buscador por nombre o descripción -->
        <div class="col-12 col-md-6">
            <label for="busqueda" class="form-label">Buscar por nombre o descripción:</label>
            <input type="search" class="form-control" id="busqueda" name="busqueda" placeholder="Ingrese nombre o descripción"
                value="<?= isset($_GET['busqueda']) ? esc($_GET['busqueda']) : '' ?>">
        </div>
        <!-- Botón de búsqueda -->
        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    <!-- Sección: Tabla de productos y paginación -->
    <section class="my-4">
        <!-- Spinner de carga (inicialmente oculto) -->
        <div id="spinner" class="text-center d-none m-5" aria-live="polite">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Contenedor responsive para la tabla de productos -->
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover" id="tablaProductos">
                <thead>
                    <tr class="text-capitalize text-center align-middle">
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Fecha Alta</th>
                        <th scope="col">Última Modificación</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    <!-- Las filas se insertarán dinámicamente mediante JavaScript -->
                    <tr></tr>
                </tbody>
            </table>
        </div>

        <!-- Controles de paginación -->
        <div class="text-center" id="paginacion"></div>
    </section>
</main>

<!-- Modal global para eliminar un producto -->
<div class="modal fade" id="eliminarProductoModal" tabindex="-1" aria-labelledby="eliminarProductoModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProductoModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <p class="text-wrap">
                    ¿Estás seguro de que quieres eliminar el producto
                    <span class="fw-bolder" id="modalProductoNombre"></span>?
                </p>
            </div>
            <!-- Pie del modal: Formulario para confirmar la eliminación -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="" method="POST" id="eliminarProductoForm">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>

<!-- Scripts: Funciones para inicializar tooltips, manejo de modales y carga dinámica de productos -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarProductosDinamicos();
    });

    /**
     * Inicializa los tooltips de Bootstrap para elementos que los requieran.
     */
    function inicializarTooltips() {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    /**
     * Delegar eventos para modales.
     * Captura clics en botones de eliminación para configurar el modal global.
     */
    function delegarEventosModales() {
        document.addEventListener('click', function(event) {
            const btnEliminar = event.target.closest('.btn-eliminar');
            if (btnEliminar) {
                event.preventDefault();
                abrirModalEliminar(btnEliminar);
            }
        });
    }

    /**
     * Abre el modal de confirmación para eliminar un producto.
     * Extrae el ID y nombre del producto del botón y actualiza el contenido del modal.
     *
     * @param {HTMLElement} btn - Botón que dispara la eliminación.
     */
    function abrirModalEliminar(btn) {
        const productoId = btn.getAttribute('data-bs-id');
        const productoNombre = btn.getAttribute('data-bs-nombre');

        document.getElementById('modalProductoNombre').textContent = productoNombre;
        document.getElementById('eliminarProductoForm').action = "<?= base_url('admin/producto/delete/') ?>" + productoId;

        const modalEl = document.getElementById('eliminarProductoModal');
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    /**
     * Realiza una solicitud AJAX para obtener los productos filtrados según los parámetros.
     * Actualiza la tabla y la paginación en la vista.
     *
     * @param {number} pagina - Número de página a cargar.
     * @param {string} textoBusqueda - Texto de búsqueda ingresado.
     * @param {string} estado - Filtro de estado aplicado.
     */
    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/producto/buscarProducto") ?>';
        const params = new URLSearchParams({
            pagina,
            textoBusqueda,
            estado
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
                actualizarTablaProductos(data.productos);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar los productos. Inténtalo de nuevo.');
            })
            .finally(() => {
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    /**
     * Actualiza la tabla de productos con los datos recibidos vía AJAX.
     *
     * @param {Array} productos - Array de objetos producto.
     */
    function actualizarTablaProductos(productos) {
        const tbody = document.querySelector('#tablaProductos tbody');
        tbody.innerHTML = '';

        if (productos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center">No se encontraron productos.</td></tr>';
            return;
        }

        productos.forEach(producto => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="align-middle">${producto.nombre}</td>
                <td class="align-middle">$${producto.precio}</td>
                <td class="align-middle">${producto.stock}</td>
                <td class="align-middle">${producto.marca_nombre}</td>
                <td class="align-middle">${producto.categoria_nombre}</td>
                <td class="align-middle">${new Date(producto.created_at).toLocaleString()}</td>
                <td class="align-middle">${new Date(producto.updated_at).toLocaleString()}</td>
                <td class="align-middle">
                    <span class="badge ${producto.estado === 'activo' ? 'bg-success' : 'bg-danger'}">
                        ${producto.estado.charAt(0).toUpperCase() + producto.estado.slice(1)}
                    </span>
                </td>
                <td class="text-center align-middle">
                    <div class="d-flex flex-wrap flex-lg-nowrap justify-content-center align-items-center">
                        <a href="<?= base_url('admin/productos/') ?>${producto.id}" 
                           class="btn btn-sm btn-outline-info border-3 fw-bolder m-1" 
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="<?= base_url('admin/productos/editar/') ?>${producto.id}" 
                           class="btn btn-sm btn-outline-warning border-3 fw-bolder m-1" 
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger border-3 fw-bolder m-1 btn-eliminar" 
                           data-bs-toggle="tooltip" data-bs-target="#eliminarProductoModal" 
                           data-bs-id="${producto.id}" data-bs-nombre="${producto.nombre}" 
                           title="Eliminar" aria-label="Eliminar producto">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Re-inicializar tooltips en caso de que se hayan añadido nuevos elementos
        inicializarTooltips();
    }

    /**
     * Genera controles de paginación basados en la página actual y el total de páginas.
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
     * Carga los productos dinámicamente al iniciar la página.
     * Utiliza la clave "estado_producto" en localStorage para preservar la selección del filtro.
     */
    function cargarProductosDinamicos() {
        const estadoGuardado = localStorage.getItem('estado_producto') || 'todos';
        document.getElementById('filtroEstadoProducto').value = estadoGuardado;
        aplicarFiltro(1, '', estadoGuardado);
    }

    // Actualizar productos al cambiar el filtro de estado (guardando la selección en localStorage)
    document.getElementById('filtroEstadoProducto').addEventListener('change', function() {
        localStorage.setItem('estado_producto', this.value);
        aplicarFiltro(1, document.querySelector('input[type="search"]').value, this.value);
    });

    // Actualizar productos en tiempo real al escribir en el campo de búsqueda
    document.querySelector('input[type="search"]').addEventListener('input', function() {
        aplicarFiltro(1, this.value, document.getElementById('filtroEstadoProducto').value);
    });
</script>