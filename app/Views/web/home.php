<section class="container-fluid px-0 mb-2 hide-sm">
    <!--carrusel-->
    <div id="carouselExampleFade" class="carousel slide carousel-fade ">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo base_url(); ?>assets/images/banner/banner-1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="<?php echo base_url(); ?>assets/images/banner/banner-2.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <video src="<?php echo base_url(); ?>assets/images/banner/banner-3.mp4" class="d-block w-100" autoplay="true" muted="true" loop="true"></video>
            </div>
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
</section>

<!-- seccion de la pagina principal  con presentacion-->
<div class="card container user-select-none">
    <p class="card-header mt-3 shadow-lg titulo-seccion banner-seccion">Tattoo Supply Store</p>
    <div class="card-body">
        <p class="card-title shadow-lg card-principal-subtitulo">Tienda de Insumos para Tatuajes</p>
        <p class="card-text card-texto">Somos una empresa joven dedicada a la comercialización de máquinas, pigmentos, insumos y todo aquello
            que necesites para equipar tu salón y puedas desarrollar tu actividad como un profesional.
            En <span class="fw-bold">Tattoo Supply Store</span> estamos dispuestos a asesorarte y ofrecerte la mejor atención.
            Trabajamos ofreciendo los mejores productos, nacionales como importados, tales como: Cheyenne, Dynamic Ink, EZ, etc.
        </p>
        <div class="text-center mt-4 mb-3">
            <a href="<?php echo base_url('catalogo'); ?>" class="btn" id="btn-catalogo-per">Catálogo</a>
        </div>

    </div>
</div>

<!-- seccion de la pagina principal  con principales productos ofrecidos-->
<section class="container text-center text-uppercase mt-2">
    <div class="row mt-lg-4 mt-0">
        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/maquinas.png" alt="Maquina de Tatuar" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Máquinas</h5>
                </div>
            </div>
        </div>
        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/fuentes.png" alt="Fuente de poder" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Fuentes</h5>
                </div>
            </div>
        </div>
        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/pigmentos.png" alt="Tintas para tatuar" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Pigmentos</h5>
                </div>
            </div>
        </div>

        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/mobiliarios.png" alt="Camilla" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Mobiliario</h5>
                </div>
            </div>
        </div>
        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/insumos.png" alt="Insumos y accesorios" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Otros Insumos y Accesorios</h5>
                </div>
            </div>
        </div>
        <div class="col col-lg-4 col-md-6 col-12 mb-lg-4 mb-md-3 mb-1">
            <div class="card card-principal-per">
                <img src="<?php echo base_url(); ?>assets/images/cards-principal/kits.png" alt="Kit" class="card-img-top rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Kits/Combos</h5>
                </div>
            </div>
        </div>

    </div>

</section>