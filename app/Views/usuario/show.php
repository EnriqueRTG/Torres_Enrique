<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device=width, initial-scale=1.0">
        <title><?= $usuario->nombre ?></title>
    </head>
    <body>
        <h1><?= $usuario->apellido?>, <?= $usuario->nombre ?></h1>
        <br>
        
        <h2>Datos Personales</h2>
        <p>Nombre: <?= $usuario->nombre ?></p>
        <p>Apellido: <?= $usuario->apellido ?></p>
        <p>Email: <?= $usuario->email ?></p>
        <p>Direccion: <?= $usuario->direccion ?></p>
        <p>Telefono: <?= $usuario->telefono ?></p>
        
        <h3>Informacion de la Cuenta</h3>
        <p>Dia de Alta: <?= $usuario->fecha_alta ?></p>
        <p>Dia de Ultima Actualizacion: <?= $usuario->fecha_actualizacion ?></p>
        
    </body>
</html>
