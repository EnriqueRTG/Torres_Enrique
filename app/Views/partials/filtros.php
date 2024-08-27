<div class="bg-white rounded-3 p-2 row row-cols-1">
    <form method="get" action="<?= base_url('catalogo') ?>">
        <div class="col-10 mb-3">
            <label for="orden">Ordenar por:</label>
            <select name="orden" id="orden" class="form-control" onchange="this.form.submit()">
                <option value="recientes" <?= (!isset($filtro['orden']) || $filtro['orden'] == 'recientes') ? 'selected' : ''; ?>>Recientes</option>
                <option value="precio_asc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_asc') ? 'selected' : ''; ?>>Menor precio</option>
                <option value="precio_desc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_desc') ? 'selected' : ''; ?>>Mayor precio</option>
            </select>
        </div>
    </form>

    <form method="get" action="<?= base_url('catalogo') ?>">
        <div class="row">
            <div class="col-12">
                <label>Categorías:</label>
                <?php foreach ($categorias as $categoria) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categoria[]" value="<?= $categoria->id; ?>" id="categoria<?= $categoria->id; ?>" <?= (isset($filtro['categoria']) && is_array($filtro['categoria']) && in_array($categoria->id, $filtro['categoria'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="categoria<?= $categoria->id; ?>">
                            <span class="text-capitalize"><?= $categoria->nombre; ?></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <button type="submit" class="btn btn-secondary" name="limpiar_filtros" value="1">Limpiar</button>
            </div>
        </div>
    </form>
</div>