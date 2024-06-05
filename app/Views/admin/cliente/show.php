<?= view("plantilla/header-admin", ['titulo' => $titulo]) ?>

<section class="container ">
    <h1><?= $cliente->apellido ?>, <?= $cliente->nombre ?></h1>
    <br>

    <h2>Datos Personales</h2>
    <p>Nombre: <?= $cliente->nombre ?></p>
    <p>Apellido: <?= $cliente->apellido ?></p>
    <p>Email: <?= $cliente->email ?></p>
    <p>Direccion: <?= $cliente->direccion ?></p>
    <p>Telefono: <?= $cliente->telefono ?></p>

    <h3>Informacion de la Cuenta</h3>
    <p>Dia de Alta: <?= $cliente->fecha_alta ?></p>
    <p>Dia de Ultima Actualizacion: <?= $cliente->fecha_actualizacion ?></p>

</section>

<?= view("plantilla/footer-admin") ?>