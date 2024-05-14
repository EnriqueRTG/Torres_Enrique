<?= view("plantilla/header", ['titulo' => $marca->nombre]) ?>

<section class="container py-5">

    <div class="py-3">
        <p class="h1"><?= $marca->nombre ?></p>
    </div>

    <div>
        <p class="h2"><?= $marca->nombre ?></p>
    </div>

</section>

<?= view("plantilla/footer") ?> 
