<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Contenedor principal: se utiliza <main> para definir el contenido principal -->
<main class="container py-5 main-content">

    <!-- Sección de mensajes de sesión (errores o notificaciones) -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: muestra la navegación jerárquica -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Sección del formulario para crear un nuevo producto -->
    <section class="py-3">
        <!-- El formulario utiliza "multipart/form-data" para permitir la subida de archivos -->
        <form class="text-center" action="<?= base_url('admin/producto') ?>" method="POST" enctype="multipart/form-data">

            <!-- Grupo: Nombre del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Producto</span>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre del Producto" value="<?= old('nombre') ?>">
            </div>

            <!-- Grupo: Descripción del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Descripción</span>
                <textarea class="form-control" name="descripcion" placeholder="Descripción del Producto"><?= old('descripcion') ?></textarea>
            </div>

            <!-- Grupo: Precio del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Precio</span>
                <!-- Puedes ajustar el prefijo monetario según lo requieras -->
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" name="precio" placeholder="Precio Unitario del Producto" value="<?= old('precio') ?>">
            </div>

            <!-- Grupo: Stock -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Stock</span>
                <input type="number" class="form-control" name="stock" placeholder="Cantidad de Unidades" value="<?= old('stock') ?>">
            </div>

            <!-- Grupo: Selección de Categoría -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Categoría</span>
                <select class="form-select" name="categoria_id">
                    <?php if (empty(old('categoria_id'))): ?>
                        <option value="" selected>Seleccionar</option>
                    <?php endif; ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->id ?>" <?= old('categoria_id') == $categoria->id ? 'selected' : '' ?>>
                            <?= esc($categoria->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Grupo: Selección de Marca -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Marca</span>
                <select class="form-select" name="marca_id">
                    <?php if (empty(old('marca_id'))): ?>
                        <option value="" selected>Seleccionar</option>
                    <?php endif; ?>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca->id ?>" <?= old('marca_id') == $marca->id ? 'selected' : '' ?>>
                            <?= esc($marca->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Grupo: Modelo del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Modelo</span>
                <input type="text" class="form-control" name="modelo" placeholder="Modelo del Producto" value="<?= old('modelo') ?>">
            </div>

            <!-- Grupo: Peso del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Peso</span>
                <input type="text" class="form-control" name="peso" placeholder="Peso del Producto" value="<?= old('peso') ?>">
            </div>

            <!-- Grupo: Dimensiones del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Dimensiones</span>
                <input type="text" class="form-control" name="dimensiones" placeholder="Dimensiones del Producto" value="<?= old('dimensiones') ?>">
            </div>

            <!-- Grupo: Material del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Material</span>
                <input type="text" class="form-control" name="material" placeholder="Material del Producto" value="<?= old('material') ?>">
            </div>

            <!-- Grupo: Color del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black">Color</span>
                <input type="text" class="form-control" name="color" placeholder="Color del Producto" value="<?= old('color') ?>">
            </div>

            <!-- Grupo: Subida de Imágenes -->
            <!-- Imagen Principal -->
            <div class="input-group py-3">
                <label class="input-group-text" for="inputImagenPrincipal">Imagen Principal</label>
                <input type="file" class="form-control" id="inputImagenPrincipal" name="imagen">
            </div>
            <!-- Imágenes Adicionales -->
            <div class="input-group py-3">
                <label class="input-group-text" for="inputImagenesAdicionales">Imágenes Adicionales</label>
                <input type="file" class="form-control" id="inputImagenesAdicionales" name="imagenes[]" multiple>
            </div>

            <!-- Grupo: Botones de Acción -->
            <div class="mt-4 text-center d-flex justify-content-evenly">
                <!-- Botón Cancelar: regresa a la página anterior -->
                <a href="<?= session()->get('referer') ?>" class="btn btn-danger btn-lg" title="Cancelar">
                    Cancelar
                </a>
                <!-- Botón Enviar: envía el formulario para crear el producto -->
                <button class="btn btn-success btn-lg" type="submit"><?= esc($nombreBoton) ?></button>
            </div>
        </form>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>