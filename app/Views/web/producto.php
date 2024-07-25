<section class="container">
    <section class="card container mt-2">

        <h1><?= $producto->nombre ?></h1>

        <div id="carouselExampleFade" class="carousel slide carousel-fade">
            <div class="carousel-inner">
                <?php foreach ($imagenes as $i) : ?>
                    <div class="carousel-item active">
                        <img src="..." class="d-block w-100" alt="..."><?= $i->imagen ?>
                    </div>
                <?php endforeach ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <h3>Detalles del Producto</h3>

        <p>Nombre: <?= $producto->nombre ?></p>
        <br>

        <p>Descripcion: <?= $producto->descripcion ?></p>
        <br>

        <p>Precio: $<?= $producto->precio ?></p>
        <br>

        <p>Marca: <?= $producto->nombre_marca ?></p>
        <br>

        <p>Subcategoria: <?= $producto->nombre_subcategoria ?></p>
        <br>

        <p>Categoria: <?= $producto->nombre_categoria ?></p>
        <br>

        <p>Presentacion: <?= $producto->presentacion ?></p>
        <br>

    </section>
</section>