<?php if (session('mensaje')) : ?>
    <div class="alert alert-success alert-dismissible fade show alert-fixed" role="alert">
        <?= session('mensaje') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>