<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal de garantía -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de éxito o error -->
    <div class="alert-info text-center container">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Tarjeta principal de "Garantía" -->
    <section class="card shadow-sm my-3">
        <!-- Encabezado de la tarjeta -->
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Garantía</h2>
        </header>

        <div class="card-body">
            <!-- Certificado de Garantía -->
            <section class="mb-4">
                <h3 class="card-title text-uppercase my-3 text-center">
                    <i class="bi bi-file-earmark-medical"></i> Certificado de Garantía
                </h3>
                <div class="">
                    <h4 class="fw-bold fs-5 my-2">¿Qué documentación necesito para iniciar el proceso de garantía?</h4>
                    <p>
                        Se requiere la factura de compra y el manual de instrucciones del producto. Estos documentos contienen información relevante
                        sobre la identificación del producto, condiciones de uso y plazo de garantía.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">¿Cuál es el plazo de garantía?</h4>
                    <p>
                        El período de garantía está indicado en la factura de compra y comienza a partir de la fecha de entrega del producto.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">¿Cómo inicio el proceso de garantía?</h4>
                    <p>
                        El cliente debe comunicarse con el servicio de postventa mediante WhatsApp al <strong>1533007912</strong> y completar el formulario correspondiente.
                        Una vez evaluado el caso, se indicará si el producto debe ser presentado en nuestras oficinas junto con su documentación.
                    </p>
                </div>
            </section>

            <!-- Alcance de la Garantía -->
            <section>
                <h4 class="fw-bold fs-5 my-2">¿Cuál es el alcance de la cobertura de la garantía?</h4>
                <p>
                    La garantía cubre defectos de fabricación y fallas bajo un uso normal del equipo. No se incluyen daños por uso indebido o factores externos.
                    Entre las exclusiones se encuentran:
                </p>
                <ul>
                    <li>Roturas, golpes o rayaduras.</li>
                    <li>Daños ocasionados por otros equipos interconectados.</li>
                    <li>Quemaduras de circuitos o componentes.</li>
                    <li>Fallas causadas por virus informáticos.</li>
                </ul>
                <p>
                    Intervenciones ajenas a Tattoo Supply Store pueden invalidar la garantía. Los productos expuestos a tensión excesiva también quedan fuera de cobertura.
                </p>
            </section>

            <!-- Procedimiento y Cambios -->
            <section>
                <h4 class="fw-bold fs-5 my-2">¿Puedo solicitar el cambio directo del producto?</h4>
                <p>
                    No. Todo producto en garantía debe ser evaluado por nuestros técnicos antes de determinar si se repara o se reemplaza.
                </p>
                <h4 class="fw-bold fs-5 my-2">¿Dónde debo presentar el producto?</h4>
                <p>
                    Si se requiere su presentación, deberá entregarse en Tattoo Supply Store, <strong>Mendoza 1194, Corrientes - Argentina</strong> o en la dirección
                    indicada por el fabricante según el manual del producto. Los gastos de envío corren por cuenta del cliente.
                </p>
            </section>
        </div>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>