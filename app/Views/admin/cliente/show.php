<!-- Vista parcial header -->
<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<!-- Se incluye la barra de navegación -->
<?= view('partials/_navbar-admin') ?>

<!-- Contenido principal -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: errores o confirmaciones -->
    <div class="alert-info text-center">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

    <!-- Breadcrumb para la navegación interna -->
    <nav aria-label="breadcrumb">
        <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
    </nav>


    <h1><?= $cliente->apellido ?>, <?= $cliente->nombre ?></h1>
    <br>

    <h2>Datos Personales</h2>
    <p>Nombre: <?= $cliente->nombre ?></p>
    <p>Apellido: <?= $cliente->apellido ?></p>
    <p>Email: <?= $cliente->email ?></p>
    <p>Telefono: <?= $cliente->telefono ?></p>

    <h3>Informacion de la Cuenta</h3>
    <p>Dia de Alta: <?= $cliente->fecha_alta ?></p>
    <p>Dia de Ultima Actualizacion: <?= $cliente->fecha_actualizacion ?></p>

</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-admin") ?>