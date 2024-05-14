<?= view("plantilla/header", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view("partials/_form-error") ?>
</section>

<section class="container py-3">
    <header>
        <h1>Modulo admin</h1>
    </header>

    <section>
        <?= $this->renderSection('contenido') ?>
    </section>

</section>    

<?= view("plantilla/footer") ?>
