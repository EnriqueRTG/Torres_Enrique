<nav aria-label="breadcrumb" class="bg-light rounded shadow-sm p-3 mb-4">
    <ol class="breadcrumb mb-0 fs-5">
        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <?php if ($index < count($breadcrumbs) - 1): ?>
                <li class="breadcrumb-item">
                    <a href="<?= esc($breadcrumb['url']) ?>" class="text-decoration-none text-primary">
                        <!-- Puedes agregar un ícono antes del label si lo deseas -->
                        
                        <?= esc($breadcrumb['label']) ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item active fw-bold" aria-current="page">
                    <?= esc($breadcrumb['label']) ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>