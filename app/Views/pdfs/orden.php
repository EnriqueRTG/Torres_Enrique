<!DOCTYPE html>
<html>
<head>
    <title>Orden de Compra #<?= $orden->id ?></title>
    <style>
        /* Agrega aquí los estilos CSS que quieras aplicar al PDF */
        body {
            font-family: sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Orden de Compra #<?= $orden->id ?></h1>
        <p>Fecha: <?= $orden->fecha_creacion ?></p>
        <p>Estado: <?= $orden->estado ?></p>

        <h3>Dirección de Envío</h3>
        

        <h3>Productos</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detallesOrden as $detalle): ?>
                    <tr>
                        <td><?= $detalle->nombre_producto ?></td>
                        <td><?= $detalle->cantidad ?></td>
                        <td>$<?= number_format($detalle->precio, 2) ?></td>
                        <td>$<?= number_format($detalle->cantidad * $detalle->precio, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>$<?= number_format($orden->total, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>