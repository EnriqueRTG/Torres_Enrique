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

        <div class="text-center paginacion">
            <?= $pager->links('default', 'default_full') ?>
        </div>


    </div>


</section>

<?= view("layouts/footer-admin") ?>

<script>
    // Inicializar tooltips
    function inicializarTooltips() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="modal"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Función para actualizar la tabla
    function actualizarTabla(page = 1) {
        // Mostrar el spinner
        document.getElementById('spinner').classList.remove('d-none');

        // Obtener el estado del filtro y el término de búsqueda
        const estado = $('#filtroEstado').val();
        const busqueda = $('form[role="search"]').find('input[type="search"]').val();

        fetch('<?php echo base_url() ?>admin/categoria/buscarMarca', { // Asegúrate de que la ruta sea correcta
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `estado=${estado}&busqueda=${busqueda}&page=${page}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                // Ocultar el spinner
                document.getElementById('spinner').classList.add('d-none');

                const tbody = document.querySelector('#tablaCategorias tbody');
                tbody.innerHTML = '';

                if (data.categorias.length > 0) {
                    data.categorias.forEach(categoria => {
                        const fila = `
                                        <tr>
                                            <td class="col-8">${categoria.nombre}</td>
                                            <td>
                                                ${categoria.estado === 'activo' ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>'}
                                            </td>
                                            <td class="text-center g-2">
                                                <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal${categoria.id}" data-bs-categoria-id="${categoria.id}" data-bs-categoria-nombre="${categoria.nombre}" data-bs-categoria-descripcion="${categoria.descripcion}" title="Editar" aria-label="Editar categoría">
                                                <i class="bi bi-pencil-square" alt="Editar"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#eliminarCategoriaModal${categoria.id}" title="Eliminar" aria-label="Eliminar categoría">
                                                <i class="bi bi-trash" alt="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        `;
                        tbody.innerHTML += fila;
                    });

                    // Re-inicializar los tooltips después de agregar las filas
                    inicializarTooltips();
                } else {
                    // Mostrar un mensaje si no hay resultados
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center">No se encontraron resultados.</td></tr>';
                }

                // Actualizar la paginación
                const paginationContainer = document.querySelector('.paginacion');
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pager;
                }

                // Agregar evento click a los enlaces de paginación usando delegación de eventos
                if (paginationContainer) {
                    paginationContainer.addEventListener('click', function(event) {
                        if (event.target.tagName === 'A' && event.target.classList.contains('page-link')) {
                            event.preventDefault();
                            const page = $(event.target).data('ci-pagination-page');
                            actualizarTabla(page);
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al cargar las categorías. Por favor, inténtalo de nuevo más tarde.');
            });
    }

    // Manejar el evento change del filtro de estado
    $('#filtroEstado').on('change', function(event) {
        event.preventDefault();
        actualizarTabla();
    });

    // Manejar el evento submit del formulario de búsqueda
    $('form[role="search"]').on('submit', function(event) {
        event.preventDefault();
        actualizarTabla();
    });

    // Inicializar tooltips de Bootstrap
    inicializarTooltips();

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
</script>
