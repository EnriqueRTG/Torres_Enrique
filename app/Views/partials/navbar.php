<header class="mb-5 pb-5 mb-sm-5 pb-sm-5 mb-md-5 pb-md-5 mb-lg-0 pb-lg-0">
    <!--Navbar-->
    <nav class="navbar fixed-top py-0 my-0">
        <div class="container-fluid row mx-auto align-content-center text-center" id="navbar">
            <button class="btn btn-dark btn-lg p-1 mb-3 ms-3 btn-nav-personalizado  order-lg-0 order-md-1 order-1 col-4 col-md-4 col-lg-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasExample">
            <samp class="hide-sm fs-3">Menu</samp>
                <i class="bi bi-list "></i>
            </button>
            <a class="navbar-brand order-lg-1 order-md-0 order-0 col-12 col-md-12 col-lg-auto" href="<?php echo base_url(); ?>">
                <img id="logo-header" class="img-fluid" src="<?= base_url(); ?>assets/images/logos/LOGO-TRANSPARENTE.png" alt="Logo">
            </a>
            <button class="btn btn-dark btn-lg p-1 mb-3 me-3 btn-nav-personalizado order-lg-2 order-md-2 order-2 col-4 col-md-4 col-lg-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarrito" aria-controls="offcanvasExample">
                <samp class="fs-3"></samp>
                <i class="bi bi-cart"></i>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 nav nav-pills nav-fill nav-underline">
                        <div class="offcanvas-body vstack gap-3">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="<?php echo base_url(); ?>">Principal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('nosotros'); ?>">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('comercializacion'); ?>">Comercialización</a>
                            </li>
                            <li class="nav-item">   
                                <a class="nav-link" href="<?php echo base_url('contacto'); ?>">Contacto</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url('terminos'); ?>">Términos y usos</a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <p class="fs-1">en construcción</p>
                </div>
            </div>
        </div>
    </nav>

</header>






