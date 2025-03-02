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
                <option value="alfabetico_asc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'alfabetico_asc') ? 'selected' : ''; ?>>
                    Alfabético A-Z
                </option>
                <option value="alfabetico_desc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'alfabetico_desc') ? 'selected' : ''; ?>>
                    Alfabético Z-A
                </option>
            </select>
        </div>
    </form>

    <!-- Formulario para filtrar por categorías y marcas -->
    <form method="get" action="<?= base_url('catalogo') ?>">
        <!-- Fieldset para categorías -->
        <fieldset>
            <legend class="visually-hidden">Filtrar por Categorías</legend>
            <div class="row">
                <div class="col-12">
                    <label class="form-label">Categorías:</label>
                    <?php foreach ($categorias as $categoria) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categoria[]" value="<?= $categoria->id; ?>"
                                id="categoria<?= $categoria->id; ?>"
                                <?= (isset($filtro['categoria']) && is_array($filtro['categoria']) && in_array($categoria->id, $filtro['categoria'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="categoria<?= $categoria->id; ?>">
                                <span class="text-capitalize"><?= $categoria->nombre; ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>

        <!-- Fieldset para marcas -->
        <fieldset class="mt-3">
            <legend class="visually-hidden">Filtrar por Marcas</legend>
            <div class="row">
                <div class="col-12">
                    <label class="form-label">Marcas:</label>
                    <?php if (isset($marcas) && !empty($marcas)): ?>
                        <?php foreach ($marcas as $marca) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="marca[]" value="<?= $marca->id; ?>"
                                    id="marca<?= $marca->id; ?>"
                                    <?= (isset($filtro['marca']) && is_array($filtro['marca']) && in_array($marca->id, $filtro['marca'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="marca<?= $marca->id; ?>">
                                    <span class="text-capitalize"><?= $marca->nombre; ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay marcas disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </fieldset>

        <!-- Botones de acción para filtrar o limpiar filtros -->
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-evenly">
                <button type="submit" class="btn btn-filtrar">Filtrar</button>
                <button type="submit" class="btn btn-limpiar" name="limpiar_filtros" value="1">Limpiar</button>
            </div>
        </div>
    </form>
</section>