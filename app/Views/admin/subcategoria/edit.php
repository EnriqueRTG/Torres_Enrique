<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view("partials/_form-error") ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container py-3">

    <form class="text-center" action="/dashboard/subcategoria/update/<?= $subcategoria->id ?>" method="POST">

        <div class="input-group py-3">
            <span class="input-group-text text-black">Nombre de Subcategoria</span>
            <input type="text" class="form-control" name="nombre" placeholder="Nombre de Subcategoria" value="<?= old('nombre', $subcategoria->nombre) ?>" >
        </div>

        <div class="input-group mb-3">
            <label class="input-group-text text-black text-black">Categoria</label>

            <select class="form-select" name="categoria_id">

                <?php if ($subcategoria->categoria_id == null) : ?>
                    <option value="0" selected>
                        Seleccionar
                    </option>
                <?php endif ?>

                <?php foreach ($categorias as $categoria) : ?>

                    <?php if ($subcategoria->categoria_id == $categoria->id) : ?>
                        <option value="<?= $categoria->id ?>" selected>
                            <?php echo $categoria->nombre; ?>
                        </option>
                    <?php endif ?>

                    <?php if ($categoria->baja != 1 & $subcategoria->categoria_id != $categoria->id) : ?>
                        <option value="<?= $categoria->id ?>">
                            <?php echo $categoria->nombre; ?>
                        </option>
                    <?php endif ?>

                <?php endforeach ?>

            </select>  
        </div>

        </div>

        <div class="py-3">
            <button class="btn btn-warning btn-lg" type="submit"><?= $nombreBoton ?></button>
        </div>

    </form>
</section>

<?= view("plantilla/footer-admin") ?> 