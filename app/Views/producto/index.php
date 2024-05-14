<?= view("plantilla/header", ['titulo' => $titulo]) ?>

<section class="alert-info">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">
    <h1 class="title"><?= $titulo ?></h1>
</section>

<section class="container">
    <a class="btn btn-success" href="/dashboard/producto/new">Crear</a>
</section>

<section class="container py-3">
    <table class="table table-secondary text-center">
        <tr>
            <td>Nombre</td>
            <td>Descripcion</td>
            <td>Precio</td>
            <td>Stock</td>
            <td>Marca</td>
            <td>Presentacion</td>
            <td>Opciones</td>
        </tr>

        <?php foreach ($productos as $key => $producto) : ?>
            <tr>

                <?php if ($producto->baja != 1) : ?>
                    <td>
                        <?= $producto->nombre ?>  
                    </td>
                    <td>
                        <?= $producto->descripcion ?>  
                    </td>
                    <td>
                        <?= $producto->precio ?>  
                    </td>
                    <td>
                        <?= $producto->stock ?>  
                    </td>
                    <td>
                        <?php foreach ($marcas as $key => $marca) : ?>
                            <?php if ($marca->id == $producto->marca_id) : ?>
                                <?= $marca->nombre ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </td>
                    <td>
                        <?= $producto->presentacion ?>  
                    </td>


                    <td>
                        <a class="btn btn-primary" href="/dashboard/producto/<?= $producto->id ?>">Ver</a>
                        <form action="/dashboard/producto/delete/<?= $producto->id ?>" method="POST">
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                        </form>
                        <a class="btn btn-dark" href="/dashboard/producto/edit/<?= $producto->id ?>">Editar</a>
                    </td>
                <?php endif ?>

            </tr>
        <?php endforeach ?>

    </table>
</section>

<?= view("plantilla/footer") ?>