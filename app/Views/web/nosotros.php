<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal -->
<main class="container my-3 main-content">

    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <section class="card p-4 shadow-sm">
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Sobre Nosotros</h2>
            <p class="text-muted">Nuestra historia, misión y equipo</p>
        </header>

        <div class="card-body">
            <p class="text-center">
                Bienvenidos a Tattoo Supply Store, tu destino para todo lo relacionado con el mundo del tatuaje.
                Fundada en 2020 por <strong>Juan Carlos Pastore</strong> y <strong>Romina Sol Almada</strong>,
                nuestra tienda se ha convertido en un referente para los amantes del arte corporal en Argentina.
            </p>

            <!-- Nuestra Misión -->
            <div class="mt-4">
                <h3 class="text-center text-uppercase"><i class="bi bi-bullseye"></i> Nuestra Misión</h3>
                <p class="text-center">
                    En Tattoo Supply Store, nos dedicamos a proporcionar insumos de tatuaje de la más alta calidad.
                    Queremos que cada artista tenga acceso a herramientas confiables para expresar su creatividad con seguridad y precisión.
                </p>
            </div>

            <!-- Carrusel de imágenes -->
            <div id="carouselNosotros" class="carousel slide my-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselNosotros" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#carouselNosotros" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselNosotros" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner rounded">
                    <div class="carousel-item active">
                        <img src="<?= base_url('assets/images/nosotros/local-1.png') ?>" class="d-block w-100 rounded" alt="Local 1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= base_url('assets/images/nosotros/local-2.png') ?>" class="d-block w-100 rounded" alt="Local 2">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= base_url('assets/images/nosotros/local-3.png') ?>" class="d-block w-100 rounded" alt="Local 3">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNosotros" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNosotros" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <!-- Nuestra Trayectoria -->
            <div class="mt-4">
                <h3 class="text-center text-uppercase"><i class="bi bi-clock-history"></i> Nuestra Trayectoria</h3>
                <p class="text-center">
                    Desde nuestros inicios como artistas tatuadores, hemos crecido hasta convertirnos en una empresa reconocida en la industria del tatuaje.
                    Contamos con proveedores confiables y ofrecemos productos de calidad para satisfacer a nuestros clientes.
                </p>
            </div>

            <!-- Nuestro Equipo -->
            <div class="mt-4">
                <h3 class="text-center text-uppercase"><i class="bi bi-people-fill"></i> Nuestro Equipo</h3>
                <p class="text-center">
                    Somos una familia de artistas y entusiastas del tatuaje, comprometidos con la calidad y la satisfacción del cliente.
                    Desde nuestro equipo de atención hasta logística, cada miembro es clave en nuestro éxito.
                </p>
            </div>

            <p class="text-center fw-bold">
                En Tattoo Supply Store, ofrecemos no solo los mejores productos de tatuaje,
                sino también una experiencia de compra personalizada y un compromiso con la excelencia.
            </p>
        </div>
    </section>

    <!-- Sección de Staff -->
    <section class="card p-4 shadow-sm my-4">
        <header class="card-header text-center bg-transparent border-0">
            <h2 class="text-uppercase">Nuestro Staff</h2>
            <p class="text-muted">Conoce a los fundadores de Tattoo Supply Store</p>
        </header>

        <div class="card-body text-center">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <img src="<?= base_url('assets/images/nosotros/staff-1.png') ?>" class="card-img-top rounded" alt="Juan Carlos Pastore">
                        <div class="card-body">
                            <h5 class="card-title">Juan Carlos Pastore</h5>
                            <p class="card-text">Propietario - Tatuador</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <img src="<?= base_url('assets/images/nosotros/staff-2.png') ?>" class="card-img-top rounded" alt="Romina Sol Almada">
                        <div class="card-body">
                            <h5 class="card-title">Romina Sol Almada</h5>
                            <p class="card-text">Propietaria - Tatuadora</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>