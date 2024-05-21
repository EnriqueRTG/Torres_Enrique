<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="container py-5">

    <h1><?= $producto->nombre ?></h1>

    <h3>Detalles del Producto</h3>

    <p>Nombre: <?= $producto->nombre ?></p>
    <br>

    <p>Descripcion: <?= $producto->descripcion ?></p>
    <br>

    <p>Precio: $<?= $producto->precio ?></p>
    <br>

    <p>Marca: <?= $producto->marca ?></p>
    <br>

    <p>Subcategoria: <?= $producto->subcategoria ?></p>
    <br>

    <p>Categoria: <?= $producto->categoria ?></p>
    <br>

    <p>Presentacion: <?= $producto->presentacion ?></p>
    <br>

</section>

<?= view("plantilla/footer-admin") ?> 