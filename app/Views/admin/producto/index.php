<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal -->
<section class="container py-5">

    <!-- Mensajes de sesión -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: navegación jerárquica -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Botón Crear y Búsqueda -->
    <div class="row my-4">
        <!-- Botón Crear: abre el modal para crear un producto -->
        <div class="col-auto">
            <a class="btn btn-success" href="<?= base_url('admin/producto/crear')?>" data-bs-toggle="tooltip"
             data-bs-target="#crearProductoModal" title="Crear producto" id="crearProductoBtn">
                Crear
            </a>
        </div>
        <!-- Formulario de búsqueda -->
        <div class="col-auto ms-auto">
            <form class="d-inline-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-primary border-3 fw-bold" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Filtro: seleccionar estado (todos/activos/inactivos) -->
    <div class="row">
        <div class="col-md-2 offset-md-10">
            <select id="filtroEstado" class="form-select">
                <option value="todos">Todos</option>
                <option value="activo">Activos</option>
                <option value="inactivo">Inactivos</option>
            </select>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="row my-4">
        <!-- Spinner de carga (oculto por defecto) -->
        <div class="text-center d-none m-5" id="spinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Tabla con la lista de productos -->
        <table class="table table-dark table-striped table-hover table-responsive" id="tablaProductos">

            <colgroup>
                <col style="width: 20%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 15%;">
                <col style="width: 15%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
            </colgroup>

            <!-- Cabecera de la tabla -->
            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Fecha de Alta</th>
                    <th scope="col">Última Modificación</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <!-- Cuerpo de la tabla: se carga dinámicamente vía JS y AJAX -->
            <tbody class="text-center">
                <tr></tr>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="text-center" id="paginacion">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </div>
</section>

<!-- Modal de confirmación global para eliminar un producto -->
<div class="modal fade" id="eliminarProductoModal" tabindex="-1" aria-labelledby="eliminarProductoModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProductoModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <!-- Cuerpo del modal: se completará dinámicamente con el nombre del producto -->
            <div class="modal-body">
                <p class="text-wrap">
                    ¿Estás seguro de que quieres eliminar el producto
                    <span class="fw-bolder" id="modalProductoNombre"></span>?
                </p>
            </div>
            <!-- Pie del modal: formulario para confirmar eliminación -->
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

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        inicializarTooltips();
        delegarEventosModales();
        cargarProductosDinamicos();
    });

    function inicializarTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    function delegarEventosModales() {
        // Delegar eventos en botones de eliminación para configurar el modal global
        document.addEventListener('click', function(event) {
            const btnEliminar = event.target.closest('.btn-eliminar');
            if (btnEliminar) {
                event.preventDefault();
                abrirModalEliminar(btnEliminar);
            }
        });
    }

    function abrirModalEliminar(btn) {
        event.preventDefault(); // Evita el comportamiento predeterminado si es un botón dentro de un formulario

        // Obtener atributos data-bs-id y data-bs-nombre del botón
        const productoId = btn.getAttribute('data-bs-id');
        const productoNombre = btn.getAttribute('data-bs-nombre');

        // Actualizar el contenido del modal: nombre del producto
        document.querySelector('#modalProductoNombre').textContent = productoNombre;
        // Actualizar la acción del formulario para eliminar el producto
        document.querySelector('#eliminarProductoForm').action = "<?= base_url('admin/producto/delete/') ?>" + productoId;

        // Mostrar el modal (getOrCreateInstance se encarga de mostrarlo)
        const modalEl = document.querySelector('#eliminarProductoModal');
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        const url = '<?= base_url("admin/producto/buscarProducto") ?>';
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
                actualizarTablaProductos(data.productos);
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar los productos. Inténtalo de nuevo.');
            })
            .finally(() => {
                // Ocultar el spinner cuando termine la carga
                document.getElementById('spinner').classList.add('d-none');
            });
    }

    function actualizarTablaProductos(productos) {
        const tbody = document.querySelector('#tablaProductos tbody');
        tbody.innerHTML = '';

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
                    <a href="<?= base_url('admin/producto/') ?>${producto.id}" class="btn btn-sm btn-outline-info border-3 fw-bolder m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="<?= base_url('admin/producto/editar/') ?>${producto.id}" class="btn btn-sm btn-outline-warning border-3 fw-bolder m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-danger border-3 fw-bolder m-1 btn-eliminar" data-bs-toggle="tooltip" data-bs-target="#eliminarProductoModal" data-bs-id="${producto.id}" data-bs-nombre="${producto.nombre}" title="Eliminar" aria-label="Eliminar producto">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </td>
        `;
            tbody.appendChild(tr);
        });

        // Re-inicializar tooltips en los nuevos elementos
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

    function cargarProductosDinamicos() {
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