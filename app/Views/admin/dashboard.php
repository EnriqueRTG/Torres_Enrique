<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!--Mensaje -->
<section class="text-center">
    <?= view('partials/_session') ?>
</section>

<section class="container py-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
        <div class="col">
            <a href="<?php echo base_url('admin/orden'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/ordenes.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Ordenes</p>
                        <p class="card-text">Visualizacion, Bajas y Modificaciones</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="<?php echo base_url('admin/cliente'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/clientes.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Clientes</p>
                        <p class="card-text">Visualizacion</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="<?php echo base_url('admin/producto'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/productos.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Productos</p>
                        <p class="card-text">Visualizacion, Altas, Bajas y Modificaciones</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="<?php echo base_url('admin/categoria'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/categorias.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Categorías</p>
                        <p class="card-text">Visualizacion, Altas, Bajas y Modificaciones</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="<?php echo base_url('admin/subcategoria'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/subcategorias.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Subcategorías</p>
                        <p class="card-text">Visualizacion, Altas, Bajas y Modificaciones</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="<?php echo base_url('admin/marca'); ?>">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?php echo base_url("assets/images/panel/marcas.png") ?>" class="card-img-top rounded-top-5" alt="...">
                    <div class="card-body">
                        <p class="card-title fs-3">Marcas</p>
                        <p class="card-text">Visualizacion, Altas, Bajas y Modificaciones</p>
                    </div>
                </div>
            </a>
        </div>

    </div>


</section>

<?= view("layouts/footer-admin") ?>