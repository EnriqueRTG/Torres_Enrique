<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<?= view("partials/_form-error") ?>

<section class="container py-5">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/productos') ?>">Productos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h1 class="card-title fs-1"><?= $producto->nombre ?></h1>
        </div>
        <div class="card-body">
            <form action="/dashboard/producto/update/<?= $producto->id ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div id="carruselImagenes" class="carousel slide carousel-dark" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php $active = 'active';
                                foreach ($imagenes as $imagen): ?>
                                    <div class="carousel-item <?= $active ?>">
                                        <img src="<?= base_url($imagen->ruta_imagen) ?>" class="d-block w-100 rounded" alt="Imagen del producto">
                                        <div class="carousel-caption d-none d-md-block">
                                            <a href="/admin/producto/eliminarImagen/<?= $imagen->id ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?')">Eliminar</a>
                                        </div>
                                    </div>
                                    <?php $active = ''; ?>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenes" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenes" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $producto->nombre) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio" name="precio" value="<?= old('precio', $producto->precio) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Unidades disponibles:</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $producto->stock) ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="imagen" class="form-label">Subir imágenes:</label>
                            <input type="file" class="form-control" id="imagen" name="imagenes[]" multiple>
                        </div>
                    </div>

                </div>
                <div class="mt-5">
                    <h2 class="fs-2">Detalles</h2>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $producto->descripcion) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca:</label>
                                <select class="form-select" id="categoria" name="marca_id">
                                    <option value="<?= $producto->marca_id ?>" selected>
                                        <?php echo $producto->nombre_marca; ?>
                                    </option>

                                    <?php foreach ($marcas as $marca) : ?>
                                        <?php if ($producto->nombre_marca != $marca->nombre) : ?>
                                            <option value="<?= $marca->id ?>">
                                                <?php echo $marca->nombre; ?>
                                            </option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="modelo" class="form-label">Modelo:</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?= old('modelo', $producto->modelo) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="peso" class="form-label">Peso:</label>
                                <input type="text" class="form-control" id="peso" name="peso" value="<?= old('peso', $producto->peso) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dimensiones" class="form-label">Dimensiones:</label>
                                <input type="text" class="form-control" id="dimensiones" name="dimensiones" value="<?= old('dimensiones', $producto->dimensiones) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="material" class="form-label">Material:</label>
                                <input type="text" class="form-control" id="material" name="material" value="<?= old('material', $producto->material) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color:</label>
                                <input type="text" class="form-control" id="color" name="color" value="<?= old('color', $producto->color) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select class="form-select" id="categoria" name="categoria_id">
                            <option value="<?= $producto->categoria_id ?>" selected>
                                <?php echo $producto->nombre_categoria; ?>
                            </option>

                            <?php foreach ($categorias as $categoria) : ?>
                                <?php if ($producto->nombre_categoria != $categoria->nombre) : ?>
                                    <option value="<?= $categoria->id ?>">
                                        <?php echo $categoria->nombre; ?>
                                    </option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="text-center pt-5 d-flex justify-content-evenly pb-3">
                    <a href="<?= session()->get('referer') ?>" class="btn btn-outline-secondary border-3 fw-bolder fw-bold fs-4" title="Cancelar">
                        Cancelar <i class="bi bi-arrow-return-left"></i>
                    </a>
                    <button type="submit" class="btn btn-outline-warning border-3 fw-bolder fw-bold fs-4" title="Guardar cambios">
                        Editar <i class="bi bi-pencil-square"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>

<?= view("layouts/footer-admin") ?>