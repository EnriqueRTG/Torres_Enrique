<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
        <?php foreach ($breadcrumbs as $breadcrumb) : ?>
            <?php if (isset($breadcrumb['url'])) : ?>
                <li class="breadcrumb-item"><a href="<?= base_url($breadcrumb['url']) ?>"><?= esc($breadcrumb['label']) ?></a></li>
            <?php else : ?>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($breadcrumb['label']) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>