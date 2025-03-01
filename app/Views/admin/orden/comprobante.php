<!-- app/Views/web/cliente/pedidos/pdf.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden #<?= esc($orden->id) ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header,
        .footer {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Resumen de Orden #<?= esc($orden->id) ?></h1>
    </div>

    <h3>Información General</h3>
    <p><strong>Total:</strong> $<?= number_format($orden->total, 2) ?></p>
    <p><strong>Estado:</strong> <?= ucfirst(esc($orden->estado)) ?></p>
    <p><strong>Fecha de Creación:</strong> <?= date("d/m/Y H:i", strtotime($orden->created_at)) ?></p>

    <h3>Dirección de Envío</h3>
    <p>
        <strong><?= esc($orden->nombre_destinatario ?? '') ?></strong><br>
        <?= esc($orden->calle ?? '') ?> <?= esc($orden->numero ?? '') ?><br>
        <?php if (!empty($orden->piso) || !empty($orden->departamento)) : ?>
            Piso: <?= esc($orden->piso) ?> - Dpto: <?= esc($orden->departamento) ?><br>
        <?php endif; ?>
        <?= esc($orden->ciudad) ?>, <?= esc($orden->provincia) ?><br>
        C.P.: <?= esc($orden->codigo_postal) ?><br>
        Tel: <?= esc($orden->telefono) ?>
    </p>

    <h3>Detalle de Productos</h3>
    <?php if (!empty($orden->detalles)): ?>
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
                <?php foreach ($orden->detalles as $detalle): ?>
                    <tr>
                        <td><?= esc($detalle->nombre_producto) ?></td>
                        <td><?= esc($detalle->cantidad) ?></td>
                        <td>$<?= number_format($detalle->precio_unitario, 2) ?></td>
                        <td>$<?= number_format($detalle->cantidad * $detalle->precio_unitario, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>$<?= number_format($orden->total, 2) ?></th>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <p>No hay detalles registrados.</p>
    <?php endif; ?>

    <div class="footer">
        <p>Gracias por su compra.</p>
    </div>
</body>

</html>