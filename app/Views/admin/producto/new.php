<!-- Vista parcial: Header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<?php
// Recuperar los errores de validación enviados como flashdata, si existen.
$errors = session()->getFlashdata('errors');
?>

<!-- Contenido principal: Se utiliza <main> para delimitar el contenido principal -->
<main class="container py-5 main-content">

    <!-- Mensajes de sesión (errores o notificaciones) -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb: Navegación jerárquica -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <!-- Sección del formulario para crear un nuevo producto -->
    <section class="py-3">
        <!-- El formulario utiliza "multipart/form-data" para permitir la subida de archivos -->
        <form class="text-center" action="<?= base_url('admin/productos') ?>" method="POST" enctype="multipart/form-data" role="form">

            <!-- Grupo: Nombre del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="nombreProductoLabel">Producto</span>
                <input type="text"
                    class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                    name="nombre"
                    placeholder="Nombre del Producto"
                    value="<?= old('nombre') ?>"
                    aria-labelledby="nombreProductoLabel">
                <?php if (isset($errors['nombre'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['nombre'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Descripción del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="descripcionProductoLabel">Descripción</span>
                <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>"
                    name="descripcion"
                    placeholder="Descripción del Producto"
                    aria-labelledby="descripcionProductoLabel"><?= old('descripcion') ?></textarea>
                <?php if (isset($errors['descripcion'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['descripcion'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Precio del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="precioProductoLabel">Precio</span>
                <!-- Prefijo monetario -->
                <span class="input-group-text">$</span>
                <input type="text"
                    class="form-control <?= isset($errors['precio']) ? 'is-invalid' : '' ?>"
                    name="precio"
                    placeholder="Precio Unitario del Producto"
                    value="<?= old('precio') ?>"
                    aria-labelledby="precioProductoLabel">
                <?php if (isset($errors['precio'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['precio'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Stock -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="stockProductoLabel">Stock</span>
                <input type="number"
                    class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>"
                    name="stock"
                    placeholder="Cantidad de Unidades"
                    value="<?= old('stock') ?>"
                    aria-labelledby="stockProductoLabel">
                <?php if (isset($errors['stock'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['stock'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Estado del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="estadoProductoLabel">Estado</span>
                <select class="form-select <?= isset($errors['estado']) ? 'is-invalid' : '' ?>"
                    name="estado"
                    aria-labelledby="estadoProductoLabel">
                    <option value="activo" <?= old('estado') === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= old('estado') === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <?php if (isset($errors['estado'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['estado'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Selección de Categoría -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="categoriaProductoLabel">Categoría</span>
                <select class="form-select <?= isset($errors['categoria_id']) ? 'is-invalid' : '' ?>"
                    name="categoria_id"
                    aria-labelledby="categoriaProductoLabel">
                    <?php if (empty(old('categoria_id'))): ?>
                        <option value="" selected>Seleccionar</option>
                    <?php endif; ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria->id ?>" <?= old('categoria_id') == $categoria->id ? 'selected' : '' ?>>
                            <?= esc($categoria->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['categoria_id'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['categoria_id'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Selección de Marca -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="marcaProductoLabel">Marca</span>
                <select class="form-select <?= isset($errors['marca_id']) ? 'is-invalid' : '' ?>"
                    name="marca_id"
                    aria-labelledby="marcaProductoLabel">
                    <?php if (empty(old('marca_id'))): ?>
                        <option value="" selected>Seleccionar</option>
                    <?php endif; ?>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca->id ?>" <?= old('marca_id') == $marca->id ? 'selected' : '' ?>>
                            <?= esc($marca->nombre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['marca_id'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['marca_id'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Modelo del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="modeloProductoLabel">Modelo</span>
                <input type="text"
                    class="form-control <?= isset($errors['modelo']) ? 'is-invalid' : '' ?>"
                    name="modelo"
                    placeholder="Modelo del Producto"
                    value="<?= old('modelo') ?>"
                    aria-labelledby="modeloProductoLabel">
                <?php if (isset($errors['modelo'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['modelo'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Peso del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="pesoProductoLabel">Peso</span>
                <input type="text"
                    class="form-control <?= isset($errors['peso']) ? 'is-invalid' : '' ?>"
                    name="peso"
                    placeholder="Peso del Producto"
                    value="<?= old('peso') ?>"
                    aria-labelledby="pesoProductoLabel">
                <?php if (isset($errors['peso'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['peso'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Dimensiones del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="dimensionesProductoLabel">Dimensiones</span>
                <input type="text"
                    class="form-control <?= isset($errors['dimensiones']) ? 'is-invalid' : '' ?>"
                    name="dimensiones"
                    placeholder="Dimensiones del Producto"
                    value="<?= old('dimensiones') ?>"
                    aria-labelledby="dimensionesProductoLabel">
                <?php if (isset($errors['dimensiones'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['dimensiones'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Material del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="materialProductoLabel">Material</span>
                <input type="text"
                    class="form-control <?= isset($errors['material']) ? 'is-invalid' : '' ?>"
                    name="material"
                    placeholder="Material del Producto"
                    value="<?= old('material') ?>"
                    aria-labelledby="materialProductoLabel">
                <?php if (isset($errors['material'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['material'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grupo: Color del Producto -->
            <div class="input-group py-3">
                <span class="input-group-text text-black" id="colorProductoLabel">Color</span>
                <input type="text"
                    class="form-control <?= isset($errors['color']) ? 'is-invalid' : '' ?>"
                    name="color"
                    placeholder="Color del Producto"
                    value="<?= old('color') ?>"
                    aria-labelledby="colorProductoLabel">
                <?php if (isset($errors['color'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['color'] ?>
                    </div>
                <?php endif; ?>
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
                <button class="btn btn-success btn-lg" type="submit">Crear</button>
            </div>
        </form>
    </section>
</main>

<!-- Vista parcial: Footer -->
<?= view("layouts/footer-admin") ?>