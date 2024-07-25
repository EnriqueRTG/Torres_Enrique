<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view("partials/_form-error") ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container py-3">
    
    <form action="create" method="POST">

        <div class="py-3">
            <label for="title">Nombre Categoria</label>

            <input type="input" name="nombre" 
                   value="<?= old('nombre', $categoria->nombre) ?>"/> 
        </div>

        <div class="py-3 text-left">
            <button class="btn btn-success" type="submit"><?= $nombreBoton ?></button>
        </div>

    </form>
    
</section>

<?= view("plantilla/footer-admin") ?>

