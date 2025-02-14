<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal del Catálogo -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de error o éxito -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Buscador -->
    <section class="search-container mb-4">
        <form action="<?= base_url('catalogo') ?>" method="get">
            <div class="input-group">
                <input type="search" name="q" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
                <button class="btn" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </section>

    <!-- Breadcrumb: navegación jerárquica -->
    <nav aria-label="breadcrumb" class="my-3">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>

    <?php if (!$productos) : ?>
        <!-- Sección: Mensaje cuando no hay productos -->
        <section class="text-center">
            <h2>No hay Productos</h2>
        </section>
    <?php else : ?>
        <!-- Botón para mostrar filtros en móviles (visible en dispositivos pequeños) -->
        <div class="mb-3 d-md-none text-center">
            <button class="btn btn-secondary btn-accion" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtrosOffcanvas" aria-controls="filtrosOffcanvas">
                Mostrar Filtros
            </button>
        </div>

        <!-- Offcanvas para filtros en dispositivos móviles -->
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="filtrosOffcanvas" aria-labelledby="filtrosOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="filtrosOffcanvasLabel">Filtros</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                <?= $this->include('partials/_filtros') ?>
            </div>
        </div>

        <!-- Estructura para dispositivos medianos y grandes: Filtros fijos y listado de productos -->
        <div class="row">
            <!-- Columna para filtros (aside), visible solo en md+ -->
            <aside class="col-md-2 d-none d-md-block" id="filtrosContainer">
                <?= $this->include('partials/_filtros') ?>
            </aside>

            <!-- Columna para el listado de productos -->
            <section class="col-md-10">
                <!-- Grid responsivo: 1 columna en xs, 3 en md, 4 en lg -->
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php foreach ($productos as $producto) : ?>
                        <!-- Cada producto se presenta en un artículo -->
                        <article class="col">
                            <div class="card h-100 card-producto">
                                <!-- Imagen del producto con overlay para "Ver Detalles" -->
                                <a href="<?= url_to('producto', $producto->id) ?>" class="position-relative d-block">
                                    <img class="card-img-top" src="<?= base_url($producto->imagen_principal) ?>" alt="<?= esc($producto->nombre) ?>">
                                    <!-- Overlay que aparece al hacer hover -->
                                    <div class="overlay d-flex justify-content-center align-items-center">
                                        <button class="btn btn-accion btn-ver-detalle">Ver Detalles</button>
                                    </div>
                                </a>
                                <!-- Detalles del producto: nombre y precio -->
                                <div class="card-body">
                                    <div class="text-center">
                                        <h5 class="fw-medium"><?= esc($producto->nombre) ?></h5>
                                        <p class="fw-semibold fs-5">$ <?= number_format($producto->precio, 2) ?></p>
                                    </div>
                                </div>
                                <!-- Pie de tarjeta: Stock y acción "Agregar al Carrito" -->
                                <div class="card-footer bg-transparent pt-0 border-0">
                                    <div class="text-center d-flex flex-column gap-2">
                                        <?php if (session()->get('usuario')) : ?>
                                            <?php if ($producto->stock < 9 && $producto->stock > 1) : ?>
                                                <span class="text-danger fw-bold">¡Últimas <?= $producto->stock ?> unidades!</span>
                                            <?php elseif ($producto->stock == 1) : ?>
                                                <span class="text-danger fw-bold">¡Última unidad!</span>
                                            <?php endif; ?>
                                            <?php if (session()->get('usuario')->rol !== 'administrador') : ?>
                                                <a href="<?= base_url('carrito/agregar/' . $producto->id) ?>" class="btn btn-warning">
                                                    Agregar al Carrito
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    <?php endif; ?>
</main>

<!-- Offcanvas para el Carrito de Compras (lado derecho) -->
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body">
        <p>Try scrolling the rest of the page to see this option in action.</p>
        <p>Subtotal (sin envío):</p>
    </div>
</div>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente", ['titulo' => $titulo]) ?>