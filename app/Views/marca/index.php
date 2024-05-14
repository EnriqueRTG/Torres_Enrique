<?= view("plantilla/header", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container">
    <a class="btn btn-success" href="/dashboard/marca/new">Crear</a>
</section>

<section class="container text-center py-3">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($marcas as $key => $marca) : ?>
                <tr>
                    <?php if ($marca->baja != 1) : ?>

                        <td class="col-8">
                            <?= $marca->nombre ?>  
                        </td>

                        <td class="col-4">
                            <div class="row row-cols-3">
                                <a class="btn btn-primary col" href="/dashboard/marca/<?= $marca->id ?>">Ver</a>
                                <form class="col row" action="/dashboard/marca/delete/<?= $marca->id ?>" method="POST">
                                    <button class="btn btn-danger col" type="submit">Eliminar</button>
                                </form>
                                <a class="btn btn-warning col" href="/dashboard/marca/edit/<?= $marca->id ?>">Editar</a>
                            </div>
                        </td>

                    <?php endif ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>

<?= view("plantilla/footer") ?>
