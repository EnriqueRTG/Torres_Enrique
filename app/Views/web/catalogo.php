<!-- colocar un aviso de que el usuario debe loguearse para adicionar los productos al carrito
    este cartel debe aparecer cada vez que se ingrese a catalogo sin loguearse
 -->
<div class="container row row-cols-2 p-3 mx-auto">

    <div class="bg-white container col-3">

        <form method="get" action="<?= base_url('catalogo') ?>">
            <div class="col-md-3">
                <label for="orden">Ordenar por:</label>
                <select name="orden" id="orden" class="form-control" onchange="this.form.submit()">
                    <option value="novedades" <?= (!isset($filtro['orden']) || $filtro['orden'] == 'novedades') ? 'selected' : ''; ?>>Recientes</option>
                    <option value="precio_asc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_asc') ? 'selected' : ''; ?>>Menor precio</option>
                    <option value="precio_desc" <?= (isset($filtro['orden']) && $filtro['orden'] == 'precio_desc') ? 'selected' : ''; ?>>Mayor precio</option>
                </select>
            </div>
        </form>

        <form method="get" action="<?= base_url('catalogo') ?>">
            <div class="row">
                <div class="col-12">
                    <label>Categorías:</label>
                    <?php foreach ($categorias as $categoria) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categoria[]" value="<?= $categoria->id; ?>" id="categoria<?= $categoria->id; ?>" <?= (isset($filtro['categoria']) && is_array($filtro['categoria']) && in_array($categoria->id, $filtro['categoria'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="categoria<?= $categoria->id; ?>">
                                <?= $categoria->nombre; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-12">
                    <label>Subcategorías:</label>
                    <?php foreach ($subcategorias as $subcategoria) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subcategoria[]" value="<?= $subcategoria->id; ?>" id="subcategoria<?= $subcategoria->id; ?>" <?= (isset($filtro['subcategoria']) && is_array($filtro['subcategoria']) && in_array($subcategoria->id, $filtro['subcategoria'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="subcategoria<?= $subcategoria->id; ?>">
                                <?= $subcategoria->nombre; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-12">
                    <label>Marcas:</label>
                    <?php foreach ($marcas as $marca) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="marca[]" value="<?= $marca->id; ?>" id="marca<?= $marca->id; ?>" <?= (isset($filtro['marca']) && is_array($filtro['marca']) && in_array($marca->id, $filtro['marca'])) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="marca<?= $marca->id; ?>">
                                <?= $marca->nombre; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

    </div>


    <div class="col-8">
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-3">

            <?php foreach ($productos as $key => $p) : ?>

                <div class="col mb-3">
                    <div class="card h-100">
                        <!-- Imagen del Producto -->
                        <a href="<?= url_to('producto', $p->id) ?>" class="position-relative">
                            <img class="card-img-top" src="<?= base_url(); ?>assets/images/fondo/fondo-b_n.jpg" alt="..." />
                            <div class="overlay d-flex justify-content-center align-items-center">
                                <button class="btn btn-primary">Ver Detalles</button>
                            </div>
                        </a>

                        <!-- Detalles del Producto -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Nombre del Producto-->
                                <h5 class="fw-bolder"><?= $p->nombre ?></h5>
                                <!-- Marca del Producto -->
                                <p class="card-text"><?= $p->nombre_marca ?></p>
                                <!-- Presentacion del Producto -->
                                <p class="card-text"><?= $p->presentacion ?></p>
                                <!-- Precio del Producto -->
                                <p>$ <?= $p->precio ?></p>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center d-flex gap-3 justify-content-center">
                                <?php if (session()->get('usuario')) : ?>
                                    <div>
                                        <a class="btn btn-warning" href="<?= url_to('producto', $p->id) ?>">
                                            Añadir al carrito
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>

        </div>
    </div>


</div>


<style>
    .card:hover {
        background-color: #f0f0f0 !important;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
        transform: scale(1.05);
    }

    .card:hover .card-title {
        color: #007bff !important;
    }

    .card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo semi-transparente */
        opacity: 0;
        /* Oculto por defecto */
        transition: opacity 0.3s ease;
        /* Transición suave */
    }

    .card:hover .overlay {
        opacity: 1;
        /* Visible al pasar el mouse */
    }

    .card .overlay button {
        display: none;
        /* Botón oculto por defecto */
    }

    .card:hover .overlay button {
        display: block;
        /* Botón visible al pasar el mouse */
    }
</style>