<?= view("plantilla/header", ['titulo' => $categoria->nombre]) ?>

<section class="container py-5">

    <div class="py-3">
        <p class="h1"><?= $categoria->nombre ?></p>
    </div>

    <div>
        <p class="h2"><?= $categoria->nombre ?></p>
    </div>

</section>

<?= view("plantilla/footer") ?> 

