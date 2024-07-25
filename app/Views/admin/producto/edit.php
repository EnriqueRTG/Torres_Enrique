<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<?= view("partials/_form-error") ?>

<form class="container" action="/dashboard/producto/update/<?= $producto->id ?>" method="POST" enctype="multipart/form-data">

    <label>Nombre del Producto:
        <input type="text" name="nombre" value="<?= old('nombre', $producto->nombre) ?>" />
    </label>
    <br>

    <label>Descripcion:
        <textarea name="descripcion" rows="3" cols="20"><?= old('descripcion', $producto->descripcion) ?></textarea>
    </label>
    <br>

    <label>Precio:
        <input type="number" name="precio" value="<?= old('precio', $producto->precio) ?>" />
    </label>
    <br>

    <label>Stock:
        <input type="number" name="stock" value="<?= old('stock', $producto->stock) ?>" />
    </label>
    <br>

    <label>Marca:
        <select name="marca_id">
            <option value="<?= $producto->marca_id ?>" selected>
                <?php echo $producto->marca; ?>
            </option>

            <?php foreach ($marcas as $marca) : ?>
                <?php if ($producto->marda_id != $marca->id) : ?>
                    <option value="<?= $marca->id ?>">
                        <?php echo $marca->nombre; ?>
                    </option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
    </label>
    <br>

    <label>Subcategoria:
        <select name="subcategoria_id">
            <option value="<?= $producto->subcategoria_id ?>" selected>
                <?php echo $producto->subcategoria; ?>
            </option>

            <?php foreach ($subcategorias as $subcategoria) : ?>
                <?php if ($producto->subcategoria_id != $subcategoria->id) : ?>
                    <option value="<?= $subcategoria->id ?>">
                        <?php echo $subcategoria->nombre; ?>
                    </option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
    </label>

    <br>

    <label>Presentacion:
        <input type="text" name="presentacion" value="<?= old('presentacion', $producto->presentacion) ?>" />
    </label>
    <br>

    <label>Imagen:
        <input type="file" name="imagen" id="imagen">
    </label>
    <br>


    <button class="btn btn-warning" type="submit"><?= $nombreBoton ?></button>
</form>

<?= view("plantilla/footer-admin") ?>