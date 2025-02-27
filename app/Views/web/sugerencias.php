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
        <form action="<?= base_url('catalogo/sugerencias') ?>" method="get">
            <div class="input-group">
                <input type="search" name="buscador" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
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

    <section class="sugerencias">
        <h2 class="text-white-50">Sugerencias para "<?= esc($query) ?>"</h2>
        <?php if (empty($sugerencias)) : ?>
            <p class="text-white">No se encontraron productos que coincidan.</p>
        <?php else : ?>
            <ul class="list-group">
                <?php foreach ($sugerencias as $producto) : ?>
                    <li class="list-group-item">
                        <a href="<?= url_to('producto', $producto->id) ?>">
                            <?= esc($producto->nombre) ?> - $<?= number_format($producto->precio, 2) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-3">
                <?= $pager ?>
            </div>
        <?php endif; ?>
    </section>

</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>