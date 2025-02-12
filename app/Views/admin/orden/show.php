<?= view("layouts/header-admin", ['titulo' => $titulo]) ?>

<section class="container py-5 main-content">

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fs-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
        </ol>

    </nav>

    <?php if ($orden) : ?>

        <section class="container ">
            <h2>Detalles de la Orden #<?= $orden->id ?></h2>

            <h3>Información del Cliente</h3>
            <p>Nombre: <?= $orden->nombre_usuario ?> <?= $orden->apellido_usuario ?></p>
            <p>Email: <?= $orden->email_usuario ?></p>

            <h3>Dirección de Envío</h3>
            <p><?= $orden->calle ?> <?= $orden->numero ?></p>
            <p><?= $orden->ciudad ?>, <?= $orden->provincia ?></p>
            <p>Teléfono: <?= $orden->telefono ?></p>

            <h3>Detalles de la Orden</h3>

            <?php foreach ($orden->detalle as $detalle): ?>
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
                        <tr>
                            <td><?= $detalle->nombre_producto ?></td>
                            <td><?= $detalle->cantidad ?></td>
                            <td>$<?= $detalle->precio_unitario ?></td>
                            <td>$<?= $detalle->cantidad * $detalle->precio_unitario ?></td>
                        </tr>
                    </tbody>
                </table>

                <p>Total: $<?= $detalle->total ?></p>
            <?php endforeach; ?>

        </section>

    <?php else : ?>

        <section class="container">
            <p class="m-5 p-5 text-center fs-3">NO EXISTEN ORDENES ASOCIADAS AL CLIENTE</p>

        </section>

    <?php endif; ?>

</section>


<?= view("layouts/footer-admin") ?>