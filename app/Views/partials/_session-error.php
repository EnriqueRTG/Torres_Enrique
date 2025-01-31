<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <style>
            ul {
                list-style-type: none;
                padding: 0;
            }
        </style>
        <ul class="">
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>