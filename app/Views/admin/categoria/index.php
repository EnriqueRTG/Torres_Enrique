<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="row my-4">
        <div class="col-auto">
            <a class="btn btn-success" href="/dashboard/categoria/new">Crear</a>
        </div>
        <div class="col-auto ms-auto">
            <form class="d-inline-flex" role="search">

                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">

                <button class="btn btn-outline-primary border-3 fw-bold" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="my-4">

        <table class="table table-dark table-striped table-hover table-responsive">

            <thead>
                <tr class="text-capitalize text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php foreach ($categorias as $key => $categoria) : ?>

                    <tr>
                        <?php if ($categoria->estado != 'inactivo') : ?>

                            <td class="col-8">
                                <?= $categoria->nombre ?>
                            </td>

                            <td class="text-center g-2">
                                <a href="#" class="btn btn-outline-warning border-3 fw-bolder mx-1" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal<?= $categoria->id ?>" data-bs-categoria-id="<?= $categoria->id ?>" data-bs-categoria-nombre="<?= $categoria->nombre ?>" title="Editar" id="editarCategoriaBtn" aria-label="Editar categoría">
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
                                        <form action="/dashboard/categoria/update" method="POST" id="modificarCategoriaForm">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" id="editarCategoriaId">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre:</label>
                                                    <input type="text" class="form-control" id="editarCategoriaNombre" name="nombre">
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
                                            <form action="/dashboard/marca/delete/<?= $categoria->id ?>" method="POST" id="eliminarCategoriaForm">
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif ?>
                    </tr>

                <?php endforeach ?>
            </tbody>

        </table>
    </div>
</section>

<nav class="mb-5" aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>

<?= view("layouts/footer-admin") ?>

<script>
    // Inicializar tooltips de Bootstrap ( muestran información adicional cuando el usuario pasa el mouse sobre un elemento)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Inicializar tooltips para los botones de eliminar
    var eliminarCategoriaBtns = document.querySelectorAll('.btn-outline-danger');
    eliminarCategoriaBtns.forEach(function(btn) {
        new bootstrap.Tooltip(btn);
    });

    // Inicializar tooltips para los botones de editar
    var editarCategoriaBtns = document.querySelectorAll('.btn-outline-warning');
    editarCategoriaBtns.forEach(function(btn) {
        new bootstrap.Tooltip(btn);
    });

    // Para cargar los datos de la Categoría en el formulario dentro del modal
    $('[id^="editarCategoriaModal"]').on('show.bs.modal', function(event) { // Selecciona todos los modales que empiezan con "editarCategoriaModal"
        var button = $(event.relatedTarget); // Botón que activó el modal
        var categoriaId = button.data('bs-categoria-id');
        var categoriaNombre = button.data('bs-categoria-nombre');

        // Rellenar los campos del formulario
        var modal = $(this);
        modal.find('#editarCategoriaId').val(categoriaId);
        modal.find('#editarCategoriaNombre').val(categoriaNombre);
    });
</script>