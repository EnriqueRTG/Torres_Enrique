<section class="container py-5 card">

    <h1><?= $producto->nombre ?></h1>

    <h3>Detalles del Producto</h3>

    <p>Nombre: <?= $producto->nombre ?></p>
    <br>

    <p>Descripcion: <?= $producto->descripcion ?></p>
    <br>

    <p>Precio: $<?= $producto->precio ?></p>
    <br>

    <ul>
        <?php foreach($imagenes as $i) : ?>
            <li><?= $i->imagen ?></li>
        <?php endforeach ?>
    </ul>

    <p>Marca: <?= $producto->marca ?></p>
    <br>

    <p>Subcategoria: <?= $producto->subcategoria ?></p>
    <br>

    <p>Categoria: <?= $producto->categoria ?></p>
    <br>

    <p>Presentacion: <?= $producto->presentacion ?></p>
    <br>

</section>
