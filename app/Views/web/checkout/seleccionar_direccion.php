<!-- Vista: app/Views/web/carrito.php -->

<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Se incluye el partial del Navbar (para la parte pública del sitio) -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal: Catálogo del Carrito -->
<main class="container my-3 main-content">
    <!-- Breadcrumb (opcional) -->
    <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>

    <header class="mb-4">
        <h1 class="mb-2 text-white">Dirección de Facturación</h1>
        <p class="text-white">Selecciona una dirección registrada o agregue una nueva.</p>
    </header>

    <?php if (!empty($direcciones)) : ?>
        <div class="list-group">
            <?php foreach ($direcciones as $direccion) : ?>
                <a href="<?= site_url('checkout/confirmarPedido?direccion_id=' . $direccion->id) ?>" class="list-group-item list-group-item-action">
                    <!-- Mostrar nombre del destinatario -->
                    <strong><?= esc($direccion->nombre_destinatario) ?></strong><br>
                    <!-- Mostrar dirección: calle, número -->
                    <?= esc($direccion->calle) . ' ' . esc($direccion->numero) ?><br>
                    <!-- Mostrar piso y departamento, si existen -->
                    <?php if (!empty($direccion->piso) || !empty($direccion->departamento)) : ?>
                        Piso: <?= esc($direccion->piso) ?> - Dpto: <?= esc($direccion->departamento) ?><br>
                    <?php endif; ?>
                    <!-- Mostrar ciudad y provincia -->
                    <?= esc($direccion->ciudad) ?>, <?= esc($direccion->provincia) ?><br>
                    <!-- Mostrar código postal, si existe -->
                    <?php if (!empty($direccion->codigo_postal)) : ?>
                        C.P.: <?= esc($direccion->codigo_postal) ?><br>
                    <?php endif; ?>
                    <!-- Mostrar teléfono, si existe -->
                    <?php if (!empty($direccion->telefono)) : ?>
                        Tel: <?= esc($direccion->telefono) ?>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Sugerencia para agregar otra dirección -->
        <div class="text-center mt-3">
            <p class="text-white">¿Deseas enviar a otra dirección?</p>
            <a href="<?= site_url('checkout/nuevaDireccion') ?>" class="btn btn-secondary">Agregar Otra Dirección</a>
        </div>
    <?php else: ?>
        <div class="text-center">
            <p class="text-white">No tienes direcciones registradas.</p>
            <a href="<?= site_url('checkout/nuevaDireccion') ?>" class="btn btn-primary">Agregar Nueva Dirección</a>
        </div>
    <?php endif; ?>
</main>

<?= view("layouts/footer-cliente") ?>