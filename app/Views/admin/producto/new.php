<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view("partials/_form-error") ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container py-3">

    <form class="text-center" action="create" method="POST" enctype="multipart/form-data">

        <div class="input-group py-3">
            <span class="input-group-text text-black" >Producto</span>
            <input type="text" class="form-control" name="nombre" placeholder="Nombre del Producto" value="<?= old('nombre', $producto->nombre) ?>" >
        </div>

        <div class="input-group py-3">
            <span class="input-group-text text-black">Descripcion</span>
            <textarea class="form-control" name="descripcion" placeholder="Descripcion del Producto" value="<?= old('nombre', $producto->descripcion) ?>"></textarea>
        </div>

        <div class="input-group py-3">
            <span class="input-group-text text-black">Precio</span>
            <span class="input-group-text">$ 0.00</span>
            <input type="text" class="form-control" name="precio" placeholder="Precio Unitario del Producto" value="<?= old('precio', $producto->precio) ?>">
        </div>

        <div class="input-group py-3">
            <span class="input-group-text text-black" >Stock</span>
            <input type="number" class="form-control"  name="stock" placeholder="Cantidad de Unidades" value="<?= old('stock', $producto->stock) ?>" >
        </div>

        <div class="input-group py-3">
            <label class="input-group-text text-black text-black">Marca</label>

            <select class="form-select" name="marca_id">

                <?php if ($producto->marca_id == null) : ?>
                    <option value="0" selected>
                        Seleccionar
                    </option>
                <?php endif ?>

                <?php foreach ($marcas as $marca) : ?>
                    <option value="<?= $marca->id ?>">
                        <?php echo $marca->nombre; ?>
                    </option>
                <?php endforeach ?>
            </select>
            </label>
        </div>

        <div class="input-group py-3">
            <label class="input-group-text text-black text-black">Subcategoria</label>

            <select class="form-select" name="subcategoria_id" onchange="mostrarCategoria(this.value)" >
                <?php if ($producto->subcategoria_id == null) : ?>
                    <option value ="0" selected>
                        Seleccionar
                    </option>
                <?php endif ?>

                <?php foreach ($subcategorias as $subcategoria) : ?>
                    <option value="<?= $subcategoria->id ?>">
                        <?php echo $subcategoria->nombre; ?>
                    </option>
                <?php endforeach ?>
            </select>

        </div>

        <div class="input-group py-3">
            <span class="input-group-text text-black" >Categoria</span>
            <input type="text" class="form-control" placeholder="Categoria del Producto" disabled id="categoria">
        </div>

        <div class="input-group py-3">
            <span class="input-group-text text-black" >Presentacion</span>
            <input type="text" class="form-control" name="presentacion" placeholder="Ej: 1 Litro, 1 Kilogramo, 2 Unidades, Pack de 12 Unidades, etc." value="<?= old('nombre', $producto->presentacion) ?>" >
        </div>

        <div class="input-group py-3">
            <label class="input-group-text" for="inputImagen">Subir Imagen</label>
            <input type="file" class="form-control" id="inputImagen" name="imagen">
            <input type="file" name="imagenes[]" class="form-control-file" multiple>
        </div>

        <button class="btn btn-success btn-lg" type="submit"><?= $nombreBoton ?></button>
    </form>
</section>



<?= view("plantilla/footer-admin") ?> 

<script>
    function mostrarCategoria(str) {
        if (str == "") {
            document.getElementById("categoria").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("categoria").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "categoria.php?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>