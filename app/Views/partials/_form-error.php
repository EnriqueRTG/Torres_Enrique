<?php if (session()->has('validation')) : ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('validation')->listErrors() ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php endif; ?>

