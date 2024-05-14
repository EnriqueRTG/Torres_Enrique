<!-- Sección de Registro -->
<section class="container">

    <div class="card container my-5" id="cardRegistroPersonalizado">

        <form class="my-3 px-5">

            <div class="my-4 text-center" id="cabeceraFormRegistro">
                <legend class="h2 mb-3">Crear Cuenta</legend>

                <div class="mb-3">
                    <span class="form-text" id="leyendaFormRegistro">
                        Comprá más rápido y llevá el control de tus pedidos, ¡en un solo lugar!
                    </span>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="nombre" placeholder="Nombre/s">
                <label for="nombre">Nombre</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="apellido" placeholder="Apellido/s">
                <label for="apellido">Apellido</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Correo electrónico</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Contraseña</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="direccion" placeholder="Direccion 123">
                <label for="direccion">Dirección</label>
            </div>
            <div class="form-floating mb-3">
                <input type="tel" class="form-control" id="telefono" placeholder="Telefono/Celular">
                <label for="telefono">Telefono</label>
            </div>

            <div class="text-center my-4">
                <button type="submit" class="btn btn-lg btn-success ">Registrar</button>
            </div>

        </form>

    </div>
</section>