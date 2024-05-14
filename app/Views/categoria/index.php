<?= view("plantilla/header", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container">
    <a class="btn btn-success" href="/dashboard/categoria/new">Crear</a>
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
            <?php foreach ($categorias as $key => $categoria) : ?>

                <tr>
                    <?php if ($categoria->baja != 1) : ?>

                        <td class="col-8">
                            <?= $categoria->nombre ?>  
                        </td>

                        <td class="col-4">
                            <div class="row row-cols-3">
                                <a class="btn btn-primary col" href="/dashboard/categoria/<?= $categoria->id ?>">Ver</a>
                                <form class="col row" action="/dashboard/categoria/delete/<?= $categoria->id ?>" method="POST">
                                    <button class="btn btn-danger col" type="submit">Eliminar</button>
                                </form>
                                <a class="btn btn-warning col" href="/dashboard/categoria/edit/<?= $categoria->id ?>">Editar</a>
                            </div>
                        </td>

                    <?php endif ?>
                </tr>

            <?php endforeach ?>
        </tbody>
    </table>
</section>

<?= view("plantilla/footer") ?>
