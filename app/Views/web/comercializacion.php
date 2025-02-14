<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal de Comercialización -->
<main class="container my-3 main-content">
    <section class="card p-4 shadow-sm">
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Comercialización</h2>
            <p class="text-muted">Toda la información sobre pedidos, envíos y pagos.</p>
        </header>

        <div class="card-body">
            <!-- Información introductoria -->
            <p class="text-center card-texto">Te ofrecemos un proceso de compra seguro y eficiente con múltiples opciones de entrega y pago.</p>

            <!-- Sección de información con acordeón -->
            <div class="accordion" id="accordionComercializacion">

                <!-- Tipos de Entregas -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="collapse" data-bs-target="#entregas"
                            aria-expanded="true" aria-controls="entregas">
                            <i class="bi bi-truck"></i><span class="ms-2">Tipos de Entrega</span>
                        </button>
                    </h2>
                    <div id="entregas" class="accordion-collapse collapse show" data-bs-parent="#accordionComercializacion">
                        <div class="accordion-body">
                            <div class="row text-center">
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>🚚 Envío a Domicilio</h5>
                                        <p>Recibe tu pedido cómodamente en tu hogar o lugar de trabajo.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>🏪 Retiro en Tienda</h5>
                                        <p>Puedes recoger tu pedido en nuestra tienda en Mendoza 1194, Corrientes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formas de Envío -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="collapse" data-bs-target="#envios"
                            aria-expanded="false" aria-controls="envios">
                            <i class="bi bi-box-seam"></i><span class="ms-2">Formas de Envío</span>
                        </button>
                    </h2>
                    <div id="envios" class="accordion-collapse collapse" data-bs-parent="#accordionComercializacion">
                        <div class="accordion-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>📦 Envío Estándar</h5>
                                        <p>Entrega en un plazo razonable garantizando seguridad y confianza.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>⚡ Envío Express</h5>
                                        <p>Entrega rápida para quienes necesitan su pedido con urgencia.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>📬 Empresas de Envío</h5>
                                        <div class="d-flex flex-wrap justify-content-center gap-3">
                                            <a href="https://www.oca.com.ar/" target="_blank">
                                                <img class="img-fluid img-logo" src="<?= base_url('assets/images/comercializacion/oca-logo.png') ?>" alt="OCA">
                                            </a>
                                            <a href="https://www.correoargentino.com.ar/" target="_blank">
                                                <img class="img-fluid img-logo" src="<?= base_url('assets/images/comercializacion/correo-argentino-logo.png') ?>" alt="Correo Argentino">
                                            </a>
                                            <a href="https://www.andreani.com/" target="_blank">
                                                <img class="img-fluid img-logo" src="<?= base_url('assets/images/comercializacion/andreani-logo.png') ?>" alt="Andreani">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formas de Pago -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="collapse" data-bs-target="#formas-de-pago"
                            aria-expanded="false" aria-controls="formas-de-pago">
                            <i class="bi bi-credit-card"></i> <span class="ms-2">Formas de Pago</span>
                        </button>
                    </h2>
                    <div id="formas-de-pago" class="accordion-collapse collapse" data-bs-parent="#accordionComercializacion">
                        <div class="accordion-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>💳 Tarjeta de Crédito/Débito</h5>
                                        <p>Aceptamos diversas tarjetas para facilitar tu pago.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>🏦 Transferencia Bancaria</h5>
                                        <p>Opción segura y conveniente para realizar pagos desde tu cuenta bancaria.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded shadow-sm">
                                        <h5>💰 Pago en Efectivo</h5>
                                        <p>Puedes pagar en efectivo al retirar en nuestra tienda.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <img class="img-fluid img-formas-pagos" src="<?= base_url('assets/images/comercializacion/formas-pagos.png') ?>" alt="Formas de Pago">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Verifica si la URL contiene un hash
        let hash = window.location.hash;
        if (hash) {
            let accordionItem = document.querySelector(hash);
            if (accordionItem) {
                let collapse = new bootstrap.Collapse(accordionItem, {
                    toggle: true
                });
            }
        }
    });
</script>