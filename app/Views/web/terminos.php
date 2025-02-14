<!-- Vista parcial header -->
<?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

<!-- Incluir el partial del Navbar -->
<?= view("partials/_navbar") ?>

<!-- Contenedor principal de términos y condiciones -->
<main class="container my-3 main-content">
    <!-- Mensajes de sesión: alertas de éxito o error -->
    <div class="alert-info text-center container">
        <?= session()->has('errors')
            ? view('partials/_session-error')
            : view('partials/_session') ?>
    </div>

    <!-- Tarjeta principal de "Términos y Usos" -->
    <section class="card shadow-sm my-3">
        <!-- Encabezado de la tarjeta -->
        <header class="card-header text-center bg-transparent border-0 mt-3">
            <h2 class="text-uppercase">Términos y Usos</h2>
        </header>

        <div class="card-body">
            <!-- Política de Privacidad -->
            <section class="mb-4">
                <h3 class="card-title text-uppercase my-3">
                    <i class="bi bi-person-fill-lock"></i> Política de Privacidad
                </h3>
                <div class="">
                    <p>
                        Tattoo Supply Store ha implementado todas las medidas necesarias para la protección de los datos personales de los usuarios,
                        con el objetivo de evitar su uso indebido, alteración, acceso no autorizado y/o robo. Sin embargo, el usuario reconoce que
                        las medidas de seguridad en Internet no son infalibles.
                    </p>
                    <p>
                        Los datos proporcionados por los usuarios serán utilizados para gestionar la relación contractual y mejorar las ofertas de productos y servicios.
                    </p>
                    <p>
                        En caso de contratar servicios de terceros a través del sitio, los datos personales podrán ser compartidos con dichos terceros únicamente
                        para la prestación del servicio y la facturación correspondiente, conforme a la Ley Nacional de Protección de Datos Personales N° 25.326.
                    </p>
                    <p>
                        Los usuarios tienen derecho a solicitar acceso, rectificación o eliminación de sus datos personales enviando un correo a:
                        <a href="mailto:tattoosupplystoreok@gmail.com">tattoosupplystoreok@gmail.com</a>.
                    </p>
                </div>
            </section>

            <!-- Términos y Condiciones de Uso -->
            <section>
                <h3 class="card-title text-uppercase my-3">
                    <i class="bi bi-pen"></i> Términos y Condiciones de Uso
                </h3>
                <div class="">
                    <p>
                        Al acceder y utilizar este sitio web, el usuario declara haber leído y aceptado los términos y condiciones establecidos.
                    </p>
                    <p>
                        Tattoo Supply Store se reserva el derecho de modificar los términos y condiciones en cualquier momento, con vigencia inmediata desde su publicación.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Usuarios habilitados</h4>
                    <p>
                        Los servicios están disponibles únicamente para personas con capacidad legal para contratar. En caso de empresas, el usuario registrado deberá estar autorizado para actuar en su nombre.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Registro y Seguridad</h4>
                    <p>
                        Para realizar compras en el sitio, es obligatorio completar el formulario de registro con datos verídicos y actualizados. El usuario es responsable de la confidencialidad de su contraseña y de todas las actividades realizadas en su cuenta.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Medios de Pago</h4>
                    <p>
                        Las compras realizadas en el sitio deben ser abonadas exclusivamente a través de MercadoPago. Tattoo Supply Store no almacena información de tarjetas de crédito ni datos financieros de los usuarios.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Garantía y Devoluciones</h4>
                    <p>
                        Todos los productos cuentan con garantía de fábrica. En caso de arrepentimiento, el usuario podrá solicitar la devolución del producto dentro de los 10 días corridos posteriores a la compra, en las condiciones establecidas por la normativa vigente.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Propiedad Intelectual</h4>
                    <p>
                        Todo el contenido del sitio, incluyendo textos, imágenes y logotipos, es propiedad de Tattoo Supply Store y está protegido por las leyes de propiedad intelectual.
                    </p>
                    <h4 class="fw-bold fs-5 my-2">Legislación Aplicable</h4>
                    <p>
                        Estos términos y condiciones se rigen por la legislación de la República Argentina. Cualquier controversia será resuelta por los tribunales correspondientes.
                    </p>
                </div>
            </section>
        </div>
    </section>
</main>

<!-- Vista parcial footer -->
<?= view("layouts/footer-cliente") ?>