<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view("partials/_form-error") ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container py-3">
    <form class="text-center" action="/dashboard/categoria/update/<?= $categoria->id ?>" method="POST">

        <div class="input-group py-3">
            <span class="input-group-text text-black">Categoria</span>
            <input type="text" class="form-control" name="nombre" placeholder="Nombre de la Categoria" value="<?= old('nombre', $categoria->nombre) ?>" >
        </div>

        <div class="py-3">
            <button class="btn btn-warning btn-lg" type="submit"><?= $nombreBoton ?></button>
        </div>

    </form>

</section>

<?= view("plantilla/footer-admin") ?>
