<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device=width, initial-scale=1.0">
        <title><?= $titulo ?></title>
    </head>
    <body>
        
        <?= view('partials/_session') ?>
        
        <h1><?= $titulo ?></h1>
            
        <table>
            <tr>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Email</td>
                <td>Direccion</td>
                <td>Telefono</td>
                <td>Alta</td>
                <td>Modificacion</td>
                <td>Opciones</td>
            </tr>
            
            <?php foreach ($usuarios as $key => $usuario) : ?>
                <tr>
                    
                    <?php if ($usuario->baja != 1) : ?>
                        <td>
                            <?= $usuario->nombre ?>  
                        </td>
                        <td>
                            <?= $usuario->apellido ?>  
                        </td>
                        <td>
                            <?= $usuario->email ?>  
                        </td>
                        <td>
                            <?= $usuario->direccion ?>  
                        </td>
                        <td>
                            <?= $usuario->telefono ?>  
                        </td>
                        <td>
                            <?= $usuario->fecha_alta ?>  
                        </td>
                        <td>
                            <?= $usuario->fecha_actualizacion ?>  
                        </td>
                        
                        <td>
                            <a href="/dashboard/usuario/<?= $usuario->id ?>">Ver</a>
                        </td>
                    <?php endif ?>
                        
                </tr>
            <?php endforeach ?>
                
        </table>
        
    </body>
</html>
