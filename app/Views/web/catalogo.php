<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php foreach ($productos as $key => $p) : ?>

                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="<?= base_url(); ?>assets/images/fondo/fondo-b_n.jpg" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?= $p->nombre ?></h5>
                                <!-- Product price-->
                                <p><?= $p->precio ?></p>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-primary" href="<?= url_to('producto', $p->id) ?>">
                                    <i class="bi bi-eye" alt="Ver"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        </div>

    </div>
</section>