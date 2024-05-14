<?= view("plantilla/header", ['titulo' => $subcategoria->nombre]) ?>

<section class="container py-5">

    <div class="py-3">
        <p class="h1"><?= $subcategoria->nombre ?></p>

        <p class="h2">Categoria</p>

        <?php foreach ($categorias as $categoria) : ?>

            <?php if ($subcategoria->categoria_id == $categoria->id) : ?>
                <p class="h3"><?= $categoria->nombre ?></p>
            <?php endif ?>

        <?php endforeach ?>

</section>

<?= view("plantilla/footer") ?> 