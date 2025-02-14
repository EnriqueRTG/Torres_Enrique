<!-- Filtros -->
<section class="bg-white rounded-3 p-2 row row-cols-1 mx-0">
    <!-- Formulario para ordenar productos -->
    <form method="get" action="<?= base_url('catalogo') ?>">
        <div class="col-10 mb-3">
            <!-- Etiqueta para el selector de orden -->
            <label for="orden" class="form-label">Ordenar por:</label>
            <!-- Selector que envía automáticamente el formulario al cambiar -->
            <select name="orden" id="orden" class="form-control" onchange="this.form.submit()">
                <option value="recientes" <?= (!isset($filtro['orden']) || $filtro['orden'] == 'recientes') ? 'selected' : ''; ?>>
                    Recientes
                </option>
                <option value="precio_asc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_asc') ? 'selected' : ''; ?>>
                    Menor precio
                </option>
                <option value="precio_desc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_desc') ? 'selected' : ''; ?>>
                    Mayor precio
                </option>
            </select>
        </div>
    </form>

    <!-- Formulario para filtrar por categorías -->
    <form method="get" action="<?= base_url('catalogo') ?>">
        <!-- Usamos un fieldset para agrupar las opciones de categorías -->
        <fieldset>
            <!-- Legend oculto para accesibilidad -->
            <legend class="visually-hidden">Filtrar por Categorías</legend>
            <div class="row">
                <div class="col-12">
                    <!-- Etiqueta para las categorías -->
                    <label for="categorias" class="form-label">Categorías:</label>
                    <?php foreach ($categorias as $categoria) : ?>
                        <div class="form-check">
                            <!-- Checkbox para cada categoría -->
                            <input class="form-check-input" type="checkbox" name="categoria[]" value="<?= $categoria->id; ?>"
                                id="categoria<?= $categoria->id; ?>"
                                <?= (isset($filtro['categoria']) && is_array($filtro['categoria']) && in_array($categoria->id, $filtro['categoria'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="categoria<?= $categoria->id; ?>">
                                <span class="text-capitalize"><?= $categoria->nombre; ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Botones de acción para filtrar o limpiar filtros -->
                <div class="col-12 mt-3 d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-dark">Filtrar</button>
                    <button type="submit" class="btn btn-secondary" name="limpiar_filtros" value="1">Limpiar</button>
                </div>
            </div>
        </fieldset>
    </form>
</section>