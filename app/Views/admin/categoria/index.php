<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="container py-5">

    <section class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </section>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal" title="Crear" id="crearCategoriaBtn" aria-label="Crear Categoría">Crear</a>
        </div>

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
                                <input type="hidden" name="id" id="crearCategoriaId">
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

        <div class="col-auto ms-auto">
            <form class="d-inline-flex" role="search">

                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">

                <button class="btn btn-outline-primary border-3 fw-bold" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 offset-md-10">
            <select id="filtroEstado" class="form-select">
                <option value="todos">Todas</option>
                <option value="activo">Activas</option>
                <option value="inactivo">Inactivas</option>
            </select>
        </div>
    </div>

    <div class="my-4">

        <table class="table table-dark table-striped table-hover table-responsive" id="tablaCategorias">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center">

                <div class="text-center d-none m-5" id="spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>

                <?php foreach ($categorias as $key => $categoria) : ?>

                    <tr>
                        <td class="col-8">
                            <?= $categoria->nombre ?>
                        </td>

                        <td>
                            <?php if ($categoria->estado == 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center g-2">
                            <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal<?= $categoria->id ?>" data-bs-categoria-id="<?= $categoria->id ?>" data-bs-categoria-nombre="<?= $categoria->nombre ?>" data-bs-categoria-descripcion="<?= $categoria->descripcion ?>" title="Editar" id="editarCategoriaBtn" aria-label="Editar categoría">
                                <i class="bi bi-pencil-square" alt="Editar"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#eliminarCategoriaModal<?= $categoria->id ?>" title="Eliminar" id="eliminarCategoriaBtn" aria-label="Eliminar categoría">
                                <i class="bi bi-trash" alt="Eliminar"></i>
                            </a>
                        </td>
                        <div class="modal fade" id="editarCategoriaModal<?= $categoria->id ?>" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo base_url() ?>admin/categoria/update/<?= $categoria->id ?>" method="POST" id="editarCategoriaForm">
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

                        <div class="modal fade" id="eliminarCategoriaModal<?= $categoria->id ?>" tabindex="-1" aria-labelledby="eliminarCategoriaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eliminarCategoriaModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-wrap">¿Estás seguro de que quieres eliminar la categoría <span class="fw-bolder">'<?php echo $categoria->nombre ?>'</span>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="<?php echo base_url() ?>admin/categoria/delete/<?= $categoria->id ?>" method="POST" id="eliminarCategoriaForm">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="text-center" id="paginacion">
            <?= $pager->links('default', 'default_full') ?>
        </div>

    </div>

</section>

<?= view("layouts/footer-admin") ?>

<script>
    // Inicializar tooltips para todos los elementos que lo requieran
    function inicializarTooltips() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="modal"]');
        console.log(tooltipTriggerList); // Verificar los elementos seleccionados

        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Para cargar los datos de la categoria en el formulario dentro del modal
    $('[id^="editarCategoriaModal"]').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget); // Convertir a objeto jQuery
        const categoriaId = button.data('bs-categoria-id');
        const categoriaNombre = button.data('bs-categoria-nombre');
        const categoriaDescripcion = button.data('bs-categoria-descripcion');

        const modal = $(this);
        modal.find('#editarCategoriaId').val(categoriaId);
        modal.find('#editarCategoriaNombre').val(categoriaNombre);
        modal.find('#editarCategoriaDescripcion').val(categoriaDescripcion);
    });

    // Inicializar tooltips de Bootstrap
    inicializarTooltips();

    const filtroEstado = document.getElementById('filtroEstado');
    const tablaCategorias = document.querySelector('#tablaCategorias tbody');
    const paginacionContainer = document.getElementById('paginacion');
    const inputBusqueda = document.querySelector('input[type="search"]');


    function aplicarFiltro(pagina = 1, textoBusqueda = '', estado = 'todos') {
        // Convertir 'pagina' a número
        pagina = parseInt(pagina, 10);

        const url = '<?php echo base_url() ?>admin/categoria/buscarCategoria'; // Asegúrate de que esta ruta sea correcta
        const params = new URLSearchParams({
            pagina: pagina,
            texto: textoBusqueda,
            estado: estado
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
                // Ocultar el spinner
                document.getElementById('spinner').classList.add('d-none');

                // Actualizar la tabla con los datos recibidos
                const tbody = document.querySelector('#tablaCategorias tbody');
                tbody.innerHTML = '';

                data.categorias.forEach(categoria => {
                    const fila = `
                <tr>
                    <td class="col-8">${categoria.nombre}</td>
                    <td>
                        ${categoria.estado === 'activo' 
                            ? '<span class="badge bg-success">Activo</span>' 
                            : '<span class="badge bg-danger">Inactivo</span>'}
                    </td>
                    <td class="text-center g-2">
                        <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" 
                           data-bs-toggle="modal" 
                           data-bs-target="#editarCategoriaModal${categoria.id}" 
                           data-bs-categoria-id="${categoria.id}" 
                           data-bs-categoria-nombre="${categoria.nombre}" 
                           data-bs-categoria-descripcion="${categoria.descripcion}" 
                           title="Editar" aria-label="Editar categoría">
                           <i class="bi bi-pencil-square" alt="Editar"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1" 
                           data-bs-toggle="modal" 
                           data-bs-target="#eliminarCategoriaModal${categoria.id}" 
                           title="Eliminar" aria-label="Eliminar categoría">
                           <i class="bi bi-trash" alt="Eliminar"></i>
                        </a>
                    </td>
                </tr>
            `;
                    tbody.innerHTML += fila;
                });

                // Actualizar la paginación
                generarPaginacion(data.paginaActual, data.totalPaginas, textoBusqueda, estado);
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las categorías. Por favor, inténtalo de nuevo más tarde.');
            });
    }

    // Evento para el cambio de filtro
    filtroEstado.addEventListener('change', function() {
        const estado = this.value;
        const textoBusqueda = inputBusqueda.value;
        aplicarFiltro(1, textoBusqueda, estado); // Reiniciar a la página 1
    });



    // Evento para la búsqueda
    inputBusqueda.addEventListener('input', function() {
        const textoBusqueda = this.value;
        const estado = filtroEstado.value;
        aplicarFiltro(1, textoBusqueda, estado); // Reiniciar a la página 1
    });

    // Al cargar la página, recuperar el estado del filtro
    window.addEventListener('load', function() {
        const estadoGuardado = localStorage.getItem('estado') || 'todos';
        const textoBusqueda = inputBusqueda.value;
        filtroEstado.value = estadoGuardado;
        aplicarFiltro(1, textoBusqueda, estadoGuardado);
    });

    let timeoutBusqueda = null;
    let filasCoincidentes = new Set(); // Usar un Set para las filas coincidentes

    inputBusqueda.addEventListener('input', function() {
        clearTimeout(timeoutBusqueda);

        timeoutBusqueda = setTimeout(() => {
            const textoBusqueda = this.value.toLowerCase();
            const filas = tablaCategorias.querySelectorAll('tr');
            filasCoincidentes.clear(); // Limpiar el conjunto de filas coincidentes

            filas.forEach(fila => {
                const nombreCategoria = fila.querySelector('td:first-child').textContent.toLowerCase();
                if (nombreCategoria.includes(textoBusqueda)) {
                    fila.style.display = '';
                    filasCoincidentes.add(fila); // Agregar la fila al conjunto
                } else {
                    if (!filasCoincidentes.has(fila)) { // Ocultar solo si no coincide con otra búsqueda
                        fila.style.display = 'none';
                    }
                }
            });
        }, 300);
    });


    function generarPaginacion(paginaActual, totalPaginas, textoBusqueda, estado) {
        const paginacionContainer = document.getElementById('paginacion');
        paginacionContainer.innerHTML = '';

        // Convertir 'paginaActual' y 'totalPaginas' a números
        paginaActual = parseInt(paginaActual, 10);
        totalPaginas = parseInt(totalPaginas, 10);

        // Generar enlaces de paginación (con un máximo de 5 páginas visibles)
        const maxPaginasVisibles = 5;
        let paginaInicial = Math.max(1, paginaActual - Math.floor(maxPaginasVisibles / 2));
        let paginaFinal = Math.min(totalPaginas, paginaInicial + maxPaginasVisibles - 1);

        if (paginaFinal - paginaInicial < maxPaginasVisibles - 1) {
            paginaInicial = Math.max(1, paginaFinal - maxPaginasVisibles + 1);
        }

        // Botón "Anterior"
        if (paginaActual > 1) {
            const enlaceAnterior = document.createElement('a');
            enlaceAnterior.href = '#';
            enlaceAnterior.textContent = 'Anterior';
            enlaceAnterior.classList.add('btn', 'btn-outline-primary', 'm-1');
            enlaceAnterior.addEventListener('click', function(event) {
                event.preventDefault();
                if (paginaActual > 1) { // Validar que no se pase de la página 1
                    aplicarFiltro(paginaActual - 1, textoBusqueda, estado);
                }
            });
            paginacionContainer.appendChild(enlaceAnterior);
        }

        // Enlaces de páginas
        for (let i = paginaInicial; i <= paginaFinal; i++) {
            const enlace = document.createElement('a');
            enlace.href = '#';
            enlace.textContent = i;
            enlace.classList.add('btn', 'btn-outline-primary', 'm-1');
            if (i === paginaActual) {
                enlace.classList.add('active');
            }
            enlace.addEventListener('click', function(event) {
                event.preventDefault();
                aplicarFiltro(i, textoBusqueda, estado);
            });
            paginacionContainer.appendChild(enlace);
        }

        // Botón "Siguiente"
        if (paginaActual < totalPaginas) {
            const enlaceSiguiente = document.createElement('a');
            enlaceSiguiente.href = '#';
            enlaceSiguiente.textContent = 'Siguiente';
            enlaceSiguiente.classList.add('btn', 'btn-outline-primary', 'm-1');
            enlaceSiguiente.addEventListener('click', function(event) {
                event.preventDefault();
                if (paginaActual < totalPaginas) { // Validar que no se pase de la última página
                    aplicarFiltro(paginaActual + 1, textoBusqueda, estado);
                }
            });
            paginacionContainer.appendChild(enlaceSiguiente);
        }
    }
</script>