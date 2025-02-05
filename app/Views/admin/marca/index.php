<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="container py-5">

    <section class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </section>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#crearMarcaModal" title="Crear" id="crearMarcaBtn" aria-label="Crear marca">Crear</a>
        </div>
        <div class="modal fade" id="crearMarcaModal" tabindex="-1" aria-labelledby="crearMarcaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearMarcaModalLabel">Crear Marca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo base_url() ?>admin/marca" method="POST" id="crearMarcaForm">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="crearMarcaId">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="crearMarcaNombre" name="nombre" placeholder="Nombre de la Marca">
                                <label for="descripcion" class="form-label">Descripcion (Opcional):</label>
                                <textarea class="form-control" id="crearMarcaDescripcion" name="descripcion" placeholder="Descripcion de la Marca"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
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

        <table class="table table-dark table-striped table-hover table-responsive" id="tablaMarcas">

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

                <?php foreach ($marcas as $key => $marca) : ?>
                    <tr>
                        <td class="col-8">
                            <?= $marca->nombre ?>
                        </td>
                        <td>
                            <?php if ($marca->estado == 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center g-2">
                            <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#editarMarcaModal<?= $marca->id ?>" data-bs-marca-id="<?= $marca->id ?>" data-bs-marca-nombre="<?= $marca->nombre ?>" data-bs-marca-descripcion="<?= $marca->descripcion ?>" title="Editar" id="editarMarcaBtn" aria-label="Editar marca">
                                <i class="bi bi-pencil-square" alt="Editar"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#eliminarMarcaModal<?= $marca->id ?>" title="Eliminar" id="eliminarMarcaBtn" aria-label="Eliminar marca">
                                <i class="bi bi-trash" alt="Eliminar"></i>
                            </a>
                        </td>

                        <div class="modal fade" id="editarMarcaModal<?= $marca->id ?>" tabindex="-1" aria-labelledby="editarMarcaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarMarcaModalLabel">Editar Marca</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo base_url() ?>admin/marca/update/<?= $marca->id ?>" method="POST" id="editarMarcaForm">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" id="editarMarcaId">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre:</label>
                                                <input type="text" class="form-control" id="editarMarcaNombre" name="nombre" placeholder="Nombre de la Marca">
                                                <label for="descripcion" class="form-label">Descripcion (Opcional):</label>
                                                <textarea class="form-control" id="editarMarcaDescripcion" name="descripcion" placeholder="Descripcion de la Marca"></textarea>
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

                        <div class="modal fade" id="eliminarMarcaModal<?= $marca->id ?>" tabindex="-1" aria-labelledby="eliminarMarcaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eliminarMarcaModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-wrap">¿Estás seguro de que quieres eliminar la marca <span class="fw-bolder">'<?php echo $marca->nombre ?>'</span> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="<?php echo base_url() ?>admin/marca/delete/<?= $marca->id ?>" method="POST" id="eliminarMarcaForm">
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

        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Para cargar los datos de la marca en el formulario dentro del modal
    $('[id^="editarMarcaModal"]').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget); // Convertir a objeto jQuery
        const marcaId = button.data('bs-marca-id');
        const marcaNombre = button.data('bs-marca-nombre');
        const marcaDescripcion = button.data('bs-marca-descripcion');

        const modal = $(this);
        modal.find('#editarMarcaId').val(marcaId);
        modal.find('#editarMarcaNombre').val(marcaNombre);
        modal.find('#editarMarcaDescripcion').val(marcaDescripcion);
    });

    // Inicializar tooltips de Bootstrap
    inicializarTooltips();

    const filtroEstado = document.getElementById('filtroEstado');
    const tablaMarcas = document.querySelector('#tablaMarcas tbody');
    const paginacionContainer = document.getElementById('paginacion');

    // Función para aplicar el filtro y la paginación
    function aplicarFiltro(pagina = 1, textoBusqueda = '') {
        const estado = filtroEstado.value;

        // Mostrar el spinner
        document.getElementById('spinner').classList.remove('d-none');

        const body = `estado=${estado}&pagina=${pagina}&texto=${textoBusqueda}`;

        fetch('<?php echo base_url() ?>admin/marca/buscarMarca', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('spinner').classList.add('d-none');

                tablaMarcas.innerHTML = '';

                data.marcas.forEach(marca => {
                    const fila = `
                                    <tr>
                                        <td class="col-8">${marca.nombre}</td>
                                        <td>
                                            ${marca.estado === 'activo' 
                                                ? '<span class="badge bg-success">Activo</span>' 
                                                : '<span class="badge bg-danger">Inactivo</span>'}
                                        </td>
                                        <td class="text-center g-2">
                                            <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#editarMarcaModal${marca.id}" data-bs-marca-id="${marca.id}" data-bs-marca-nombre="${marca.nombre}" data-bs-marca-descripcion="${marca.descripcion}" title="Editar" aria-label="Editar marca">
                                                <i class="bi bi-pencil-square" alt="Editar"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#eliminarMarcaModal${marca.id}" title="Eliminar" aria-label="Eliminar marca">
                                                <i class="bi bi-trash" alt="Eliminar"></i>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                    tablaMarcas.innerHTML += fila;
                });

                // Actualizar la paginación
                generarPaginacion(data.paginaActual, data.totalPaginas);

                // Inicializar tooltips después de actualizar la tabla
                inicializarTooltips();
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                // Mostrar un mensaje de error al usuario
                alert('Error al cargar las marcas. Por favor, inténtalo de nuevo más tarde.');
            });
    }

    // Evento para el cambio de filtro
    filtroEstado.addEventListener('change', function() {
        localStorage.setItem('estado', this.value);
        aplicarFiltro();
    });

    // Al cargar la página, recuperar el estado del filtro
    window.addEventListener('load', function() {
        const estadoGuardado = localStorage.getItem('estado');
        if (estadoGuardado) {
            filtroEstado.value = estadoGuardado;
        }
        aplicarFiltro();
    });

    const inputBusqueda = document.querySelector('input[type="search"]');

    inputBusqueda.addEventListener('input', function() {
        const textoBusqueda = this.value;
        aplicarFiltro(1, textoBusqueda); // Llamar a aplicarFiltro con la página 1 y el texto de búsqueda
    });

    let timeoutBusqueda = null;
    let filasCoincidentes = new Set(); // Usar un Set para las filas coincidentes

    inputBusqueda.addEventListener('input', function() {
        clearTimeout(timeoutBusqueda);

        timeoutBusqueda = setTimeout(() => {
            const textoBusqueda = this.value.toLowerCase();
            const filas = tablaMarcas.querySelectorAll('tr');
            filasCoincidentes.clear(); // Limpiar el conjunto de filas coincidentes

            filas.forEach(fila => {
                const nombreMarca = fila.querySelector('td:first-child').textContent.toLowerCase();
                if (nombreMarca.includes(textoBusqueda)) {
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


    function generarPaginacion(paginaActual, totalPaginas) {
        const paginacionContainer = document.getElementById('paginacion');
        paginacionContainer.innerHTML = '';

        // Generar enlaces de paginación (con un máximo de 5 páginas visibles)
        const maxPaginasVisibles = 5;
        let paginaInicial = Math.max(1, paginaActual - Math.floor(maxPaginasVisibles / 2));
        let paginaFinal = Math.min(totalPaginas, paginaInicial + maxPaginasVisibles - 1);
        if (paginaFinal - paginaInicial < maxPaginasVisibles - 1) {
            paginaInicial = Math.max(1, paginaFinal - maxPaginasVisibles + 1);
        }

        for (let i = paginaInicial; i <= paginaFinal; i++) {
            let enlace = document.createElement('a');
            enlace.href = '#';
            enlace.textContent = i;
            enlace.classList.add('btn', 'btn-outline-primary', 'm-1');
            if (i === paginaActual) {
                enlace.classList.add('active');
            }
            enlace.addEventListener('click', function(event) {
                event.preventDefault();
                aplicarFiltro(i);
            });
            paginacionContainer.appendChild(enlace);
        }
    }
</script>