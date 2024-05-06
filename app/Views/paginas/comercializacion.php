<!-- Sección de comercialización-->
<section class="container mt-5 pt-5">

    <div class="card container user-select-none mt-2">
        <p class="card-header mt-3 shadow-lg titulo-seccion banner-seccion" id="titulo-seccion-comercializacion">
            comercialización
        </p>

        <div class="card-body vstack gap-3">
            <p class="card-text card-texto">
                Te  brindamos toda la información necesaria sobre cómo realizar pedidos,
                recibir tus productos y completar tus transacciones de manera segura y conveniente.
            </p>

            <ul class="nav nav-pills justify-content-center fs-3 list-group list-group-horizontal mb-2 gap-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active boton-per" id="tipos-de-entrega-tab" data-bs-toggle="tab" data-bs-target="#tipos-de-entrega-pane" type="button" role="tab" aria-controls="tipos-de-entrega-pane" aria-selected="true">Tipos de Entregas</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link boton-per" id="formas-de-envio-tab" data-bs-toggle="tab" data-bs-target="#formas-de-envio-pane" type="button" role="tab" aria-controls="formas-de-envio-pane" aria-selected="false">Formas de Envíos</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link boton-per" id="formas-de-pago-tab" data-bs-toggle="tab" data-bs-target="#formas-de-pago-pane" type="button" role="tab" aria-controls="formas-de-pago-pane" aria-selected="false">Formas de Pagos</button>
                </li>
            </ul>

            <div class="tab-content card-texto" id="myTabContent">
                <div class="tab-pane fade show active" id="tipos-de-entrega-pane" role="tabpanel" aria-labelledby="tipos-de-entrega" tabindex="0">
                    <table class="table table-dark table-hover">
                        <tbody class="vstack gap-3 m-5 tbody-per">
                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Envío a Domicilio
                                </td>

                                <td class="col-auto p-3">
                                    Ofrecemos la opción de enviar los productos directamente a la 
                                    puerta de tu hogar o lugar de trabajo, 
                                    garantizando comodidad y conveniencia para nuestros clientes.
                                </td>
                            </tr>

                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Retiro en Tienda
                                </td>

                                <td class="col-auto p-3">
                                    Para aquellos que prefieren una opción más rápida y personal, 
                                    también ofrecemos la posibilidad de recoger los productos en 
                                    nuestra tienda física ubicada en la calle Mendoza 1194 de la Ciudad de Corrientes, 
                                    Argentina.
                                </td>  
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="formas-de-envio-pane" role="tabpanel" aria-labelledby="formas-de-envio" tabindex="0">
                    <table class="table table-dark table-hover">
                        <tbody class="vstack gap-3 m-5 tbody-per">
                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Envío Estándar
                                </td>

                                <td class="col-auto p-3">
                                    Nuestro servicio de envío estándar garantiza la entrega 
                                    confiable y oportuna de tus productos en un plazo razonable.
                                </td>
                            </tr>

                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Envío Express
                                </td>

                                <td class="col-auto p-3">
                                    Para aquellos clientes que necesitan sus productos con urgencia, 
                                    ofrecemos un servicio de envío express que garantiza la 
                                    entrega rápida en un plazo reducido de tiempo.
                                </td>  
                            </tr>

                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Empresas de Envíos
                                </td>

                                <td class="nav justify-content-center gap-5 mx-auto>"
                                    <a></a>
                                    <a class="link-comercializacion" href="https://www.oca.com.ar/Content/preciosPDF/precios.pdf" target="_blank">
                                        <img class="img-fluid img-logo-comer" src="<?php echo base_url("assets/images/comercializacion/oca-logo.png") ?>" alt="Logo de OCA"/>
                                    </a>
                                    <a class="link-comercializacion" href="https://www.correoargentino.com.ar/servicios/paqueteria/encomienda-correo-clasica" target="_blank">
                                        <img class="img-fluid img-logo-comer" src="<?php echo base_url("assets/images/comercializacion/correo-argentino-logo.png") ?>" alt="Logo de Correo Argentino"/>
                                    </a>
                                    <a class="link-comercializacion" href="https://www.andreani.com/#!/precios-productos/sucursal" target="_blank">
                                        <img class="img-fluid img-logo-comer" src="<?php echo base_url("assets/images/comercializacion/andreani-logo.png") ?>" alt="Logo de Andreani"/>
                                    </a>
                                </td>  
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="formas-de-pago-pane" role="tabpanel" aria-labelledby="formas-de-pago" tabindex="0">
                    <table class="table table-dark table-hover" id="formas-de-pago">
                        <tbody class="vstack gap-3 mx-5 tbody-per">
                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Tarjeta de Crédito/Débito
                                </td>

                                <td class="col-auto p-3">
                                    Aceptamos una amplia gama de tarjetas de crédito y 
                                    débito para facilitar el proceso de pago de nuestros clientes.
                                </td>
                            </tr>

                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Transferencia Bancaria
                                </td>

                                <td class="col-auto p-3">
                                    Para aquellos que prefieren realizar pagos a través de transferencias bancarias, 
                                    también ofrecemos esta opción segura y conveniente.
                                </td>  
                            </tr>

                            <tr class="row align-items-center">
                                <td class="text-center p-3 col-auto">
                                    Pago en Efectivo
                                </td>

                                <td class="col-auto p-3">
                                    Si prefieres pagar en efectivo al momento de recoger 
                                    tu pedido en nuestra tienda física, ¡también te damos la bienvenida!.
                                </td>  
                            </tr>

                        </tbody>
                    </table>
                    <div class="text-center">
                        <img class="img-formas-pagos img-fluid" src="<?php echo base_url("assets/images/comercializacion/formas-pagos.png") ?>" alt="Formas de Pago"/> 
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>