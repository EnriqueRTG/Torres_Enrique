<!-- Vista parcial header (incluye el DOCTYPE, head y apertura del body) -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Se incluye la barra de navegación (navbar) -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal del Dashboard -->
<main class="container py-5 main-content">
    <!-- Sección de mensajes de sesión (errores o confirmaciones) -->
    <section class="mb-4">
        <div class="alert-info text-center">
            <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
        </div>
    </section>

    <!-- Encabezado principal del Dashboard -->
    <header class="mb-4">
        <h1 class="mb-2">Dashboard</h1>
        <p class="lead">Acceso rápido a las secciones del panel de administración.</p>
    </header>

    <!-- Sección con tarjetas de acceso rápido -->
    <section class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
        <!-- Tarjeta: Órdenes -->
        <article class="col">
            <a href="<?= base_url('admin/ordenes'); ?>" class="text-decoration-none">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?= base_url("assets/images/panel/ordenes.png") ?>" class="card-img-top rounded-top-5" alt="Órdenes">
                    <div class="card-body">
                        <h2 class="card-title fs-3">Órdenes</h2>
                        <p class="card-text">Visualización, bajas y modificaciones.</p>
                    </div>
                </div>
            </a>
        </article>

        <!-- Tarjeta: Clientes -->
        <article class="col">
            <a href="<?= base_url('admin/clientes'); ?>" class="text-decoration-none">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?= base_url("assets/images/panel/clientes.png") ?>" class="card-img-top rounded-top-5" alt="Clientes">
                    <div class="card-body">
                        <h2 class="card-title fs-3">Clientes</h2>
                        <p class="card-text">Visualización.</p>
                    </div>
                </div>
            </a>
        </article>

        <!-- Tarjeta: Productos -->
        <article class="col">
            <a href="<?= base_url('admin/productos'); ?>" class="text-decoration-none">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?= base_url("assets/images/panel/productos.png") ?>" class="card-img-top rounded-top-5" alt="Productos">
                    <div class="card-body">
                        <h2 class="card-title fs-3">Productos</h2>
                        <p class="card-text">Visualización, altas, bajas y modificaciones.</p>
                    </div>
                </div>
            </a>
        </article>

        <!-- Tarjeta: Categorías -->
        <article class="col">
            <a href="<?= base_url('admin/categorias'); ?>" class="text-decoration-none">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?= base_url("assets/images/panel/categorias.png") ?>" class="card-img-top rounded-top-5" alt="Categorías">
                    <div class="card-body">
                        <h2 class="card-title fs-3">Categorías</h2>
                        <p class="card-text">Visualización, altas, bajas y modificaciones.</p>
                    </div>
                </div>
            </a>
        </article>

        <!-- Tarjeta: Marcas -->
        <article class="col">
            <a href="<?= base_url('admin/marcas'); ?>" class="text-decoration-none">
                <div class="card rounded-5 text-center shadow-lg card-dashboard">
                    <img src="<?= base_url("assets/images/panel/marcas.png") ?>" class="card-img-top rounded-top-5" alt="Marcas">
                    <div class="card-body">
                        <h2 class="card-title fs-3">Marcas</h2>
                        <p class="card-text">Visualización, altas, bajas y modificaciones.</p>
                    </div>
                </div>
            </a>
        </article>
    </section>
</main>

<!-- Se incluye el footer del panel de administración -->
<?= view("layouts/footer-admin") ?>