 <!-- Vista parcial header -->
 <?= view("layouts/header-cliente", ['titulo' => $titulo]) ?>

 <!-- Incluir el partial del Navbar -->
 <?= view("partials/_navbar") ?>

 <!-- Contenedor principal del Catálogo -->
 <main class="container my-3 main-content">

     <!-- Mensajes de sesión: alertas de error o éxito -->
     <div id="flashMessage" class="alert-info text-center" role="alert">
        <?= session()->has('errors') ? view('partials/_session-error') : view('partials/_session') ?>
    </div>

     <!-- Buscador -->
     <section class="search-container mb-4">
         <form action="<?= base_url('catalogo/sugerencias') ?>" method="get">
             <div class="input-group">
                 <input type="search" name="buscador" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
                 <button class="btn" type="submit">
                     <i class="bi bi-search"></i>
                 </button>
             </div>
         </form>

     </section>

     <!-- Breadcrumb: navegación jerárquica -->
     <nav aria-label="breadcrumb" class="my-3">
         <?= view('partials/_breadcrumb', ['breadcrumbs' => $breadcrumbs]) ?>
     </nav>

     <?php if (!$productos) : ?>
         <!-- Sección: Mensaje cuando no hay productos -->
         <section class="text-center text-white-50">
             <h2>No hay Productos</h2>
         </section>
     <?php else : ?>
         <!-- Botón para mostrar filtros en móviles (visible en dispositivos pequeños) -->
         <div class="mb-3 d-md-none text-center">
             <button class="btn btn-filtros" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtrosOffcanvas" aria-controls="filtrosOffcanvas">
                 Mostrar Filtros
             </button>
         </div>

         <!-- Offcanvas para filtros en dispositivos móviles -->
         <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="filtrosOffcanvas" aria-labelledby="filtrosOffcanvasLabel">
             <div class="offcanvas-header">
                 <h5 class="offcanvas-title" id="filtrosOffcanvasLabel">Filtros</h5>
                 <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
             </div>
             <div class="offcanvas-body">
                 <?= $this->include('partials/_filtros') ?>
             </div>
         </div>

         <!-- Estructura para dispositivos medianos y grandes: Filtros fijos y listado de productos -->
         <div class="row">
             <!-- Columna para filtros (aside), visible solo en md+ -->
             <aside class="col-md-2 d-none d-md-block" id="filtrosContainer">
                 <?= $this->include('partials/_filtros') ?>
             </aside>

             <!-- Columna para el listado de productos -->
             <section class="col-md-10">
                 <!-- Grid responsivo: 1 columna en xs, 3 en md, 4 en lg -->
                 <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
                     <?php foreach ($productos as $producto) : ?>
                         <!-- Cada producto se presenta en un artículo -->
                         <article class="col">
                             <div class="card h-100 card-producto">
                                 <!-- Imagen del producto con overlay para "Ver Detalles" -->
                                 <a href="<?= url_to('producto', $producto->id) ?>" class="position-relative d-block">
                                     <img class="card-img-top" src="<?= base_url($producto->imagen_principal) ?>" alt="<?= esc($producto->nombre) ?>">
                                     <!-- Overlay que aparece al hacer hover -->
                                     <div class="overlay d-flex justify-content-center align-items-center">
                                         <button class="btn btn-ver-detalles">Ver Detalles</button>
                                     </div>
                                 </a>
                                 <!-- Detalles del producto: nombre y precio -->
                                 <div class="card-body">
                                     <div class="text-center">
                                         <h5 class="fw-medium"><?= esc($producto->nombre) ?></h5>
                                         <p class="fw-semibold fs-5">$ <?= number_format($producto->precio, 2) ?></p>
                                     </div>
                                 </div>
                                 <!-- Pie de tarjeta: Stock y acción "Agregar al Carrito" -->
                                 <div class="card-footer bg-transparent pt-0 border-0">
                                     <div class="text-center d-flex flex-column gap-2">
                                         <?php if (session()->get('usuario')) : ?>
                                             <?php if ($producto->stock < 9 && $producto->stock > 1) : ?>
                                                 <span class="text-danger fw-bold">¡Últimas <?= $producto->stock ?> unidades!</span>
                                             <?php elseif ($producto->stock == 1) : ?>
                                                 <span class="text-danger fw-bold">¡Última unidad!</span>
                                             <?php endif; ?>
                                             <?php if (session()->get('usuario')->rol !== 'administrador') : ?>
                                                 <a href="<?= base_url('web/carrito/agregar/' . $producto->id) ?>" class="btn btn-agregar-carrito">
                                                     Agregar al Carrito
                                                 </a>
                                             <?php endif; ?>
                                         <?php endif; ?>
                                     </div>
                                 </div>
                             </div>
                         </article>
                     <?php endforeach; ?>
                 </div>
             </section>
         </div>
     <?php endif; ?>

     <!-- Enlaces de paginación -->
     <div class="mt-4 text-center align-middle">
         <?= $pager ?>
     </div>

 </main>

 <!-- Vista parcial footer -->
 <?= view("layouts/footer-cliente") ?>

 <script>
     document.addEventListener("DOMContentLoaded", function() {
         <?php if (session()->getFlashdata('mensaje')): ?>
             mostrarMensaje("<?= session()->getFlashdata('mensaje') ?>");
         <?php endif; ?>
         // Asigna el evento a cada botón "Agregar al Carrito"
         document.querySelectorAll(".btn-agregar-carrito").forEach(btn => {
             btn.addEventListener("click", function(event) {
                 event.preventDefault(); // Evita la recarga de la página

                 fetch(this.href, {
                         method: "POST"
                     })
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             // Muestra el mensaje flotante
                             mostrarMensaje(data.message);
                             // Después de un breve retraso (por ejemplo, 1 segundos), recarga la página
                             setTimeout(() => {
                                 window.location.reload();
                             }, 1000);
                         } else {
                             mostrarMensaje(data.message, "danger");
                         }
                     })
                     .catch(error => console.error("Error:", error));
             });
         });
     });

     // Función para actualizar y mostrar el contenedor de mensajes (utilizando el contenedor ya definido en la vista)
     function mostrarMensaje(texto, tipo = "success") {
         const flashEl = document.getElementById("flashMessage");
         // Actualiza las clases para usar los estilos de alerta de Bootstrap
         flashEl.className = `alert alert-${tipo} alert-dismissible fade show text-center`;
         // Actualiza el contenido con el mensaje y el botón de cierre
         flashEl.innerHTML = `
        ${texto}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    `;
         // Muestra el contenedor
         flashEl.style.display = "block";

         // Oculta el mensaje automáticamente después de 3 segundos (aunque la página se recargará antes)
         setTimeout(() => {
             flashEl.classList.add("fade");
             setTimeout(() => {
                 flashEl.style.display = "none";
                 flashEl.classList.remove("fade");
             }, 500);
         }, 1000);
     }
 </script>