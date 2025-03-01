<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenido principal de la página Home -->
<main class="container-fluid px-0 mb-3 main-content">

    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Sección: Carrusel de banners -->
    <section class="d-none d-sm-block">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1500">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= base_url('assets/images/banner/banner-1.png'); ?>" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url('assets/images/banner/banner-2.png'); ?>" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <video src="<?= base_url('assets/images/banner/banner-3.mp4'); ?>" class="d-block w-100" autoplay muted loop></video>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>

    <!-- Sección: Presentación principal del negocio -->
    <section class="container my-5">
        <div class="card shadow">
            <!-- Encabezado: Título principal de la marca (respeta .titulo-nombre-empresa) -->
            <header class="card-header text-center bg-transparent border-0">
                <h2 class="titulo-nombre-empresa">Tattoo Supply Store</h2>
            </header>
            <!-- Cuerpo descriptivo -->
            <div class="card-body text-center">
                <h3 class="card-title text-uppercase">Tienda de Insumos para Tatuajes</h3>
                <p class="card-text mx-auto" style="max-width: 800px;">
                    Somos una empresa joven dedicada a la comercialización de máquinas, pigmentos, insumos y todo aquello
                    que necesites para equipar tu salón y puedas desarrollar tu actividad como un profesional.
                    En <span class="fw-bold">Tattoo Supply Store</span> estamos dispuestos a asesorarte y ofrecerte la mejor atención.
                    Trabajamos ofreciendo productos de calidad, nacionales e importados.
                </p>
                <div class="mt-4">
                    <a href="<?= base_url('catalogo'); ?>" class="btn btn-custom" id="btn-catalogo-per">
                        Ver Catálogo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Principales productos ofrecidos -->
    <section class="container">
        <header class="text-center mb-4">
            <h2 class="text-uppercase fw-bold" style="font-family: 'Montserrat', sans-serif; color: var(--color-secundario);">
                Principales Productos
            </h2>
        </header>

        <!-- Grid responsivo para las tarjetas de productos -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <!-- Tarjeta de producto: Máquinas -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/maquinas.png'); ?>"
                        alt="Máquinas" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Máquinas</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Fuentes -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/fuentes.png'); ?>"
                        alt="Fuentes" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Fuentes</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Pigmentos -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/pigmentos.png'); ?>"
                        alt="Pigmentos" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Pigmentos</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Mobiliario -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/mobiliarios.png'); ?>"
                        alt="Mobiliario" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Mobiliario</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Otros Insumos y Accesorios -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/insumos.png'); ?>"
                        alt="Otros Insumos y Accesorios" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Insumos</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Kits/Combos -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/kits.png'); ?>"
                        alt="Kits/Combos" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Kits/Combos</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Merchan    -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/merchan.png'); ?>"
                        alt="Kits/Combos" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Merchan</h5>
                    </div>
                </div>
            </article>

            <!-- Tarjeta de producto: Kits/Combos -->
            <article class="col">
                <div class="card h-100 card-productos-home">
                    <img src="<?= base_url('assets/images/cards-principal/accesorios.png'); ?>"
                        alt="Kits/Combos" class="card-img-top rounded-3">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Accesorios</h5>
                    </div>
                </div>
            </article>
        </div>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente", ['titulo' => $titulo]) ?>