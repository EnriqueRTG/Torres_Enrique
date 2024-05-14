<?= view("plantilla/header", ['titulo' => $titulo]) ?>

<section class="alert-info text-center">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container">
    <a class="btn btn-success" href="/dashboard/subcategoria/new">Crear</a>
</section>

<section class="container text-center py-3">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Categoria</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($subcategorias as $key => $subcategoria) : ?>

                <tr>
                    <?php if ($subcategoria->baja != 1) : ?>

                        <td class="col-4">
                            <?= $subcategoria->nombre ?>  
                        </td>

                        <td class="col-4">
                            <?php foreach ($categorias as $key => $categoria) : ?>
                                <?php if ($subcategoria->categoria_id == $categoria->id) : ?>
                                    <?= $categoria->nombre ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>

                        <td class="col-4">
                            <div class="row row-cols-3">
                                <a class="btn btn-primary col" href="/dashboard/subcategoria/<?= $subcategoria->id ?>">Ver</a>
                                <form class="col row" action="/dashboard/subcategoria/delete/<?= $subcategoria->id ?>" method="POST">
                                    <button class="btn btn-danger col" type="submit">Eliminar</button>
                                </form>
                                <a class="btn btn-warning col" href="/dashboard/subcategoria/edit/<?= $subcategoria->id ?>">Editar</a>
                            </div>
                        </td>

                    <?php endif ?>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>

<?= view("plantilla/footer") ?>
