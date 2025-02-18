<!-- Navbar de Bootstrap para el panel de administración -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-4" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- Botón de toggle para vistas móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <!-- Menú colapsable centrado -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarMenu">
            <ul class="navbar-nav mb-2 mb-lg-0 gap-3">
                <!-- Enlace al Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
                </li>
                <!-- Enlace a la Tienda -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>">Tienda</a>
                </li>
                <!-- Dropdown para mensajes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mensajes
                        <!-- Badge para mostrar cantidad de mensajes no leídos -->
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            99+ <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="messagesDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/conversaciones/consultas'); ?>">
                                Consultas <span class="badge text-bg-warning">4</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/conversaciones/contactos'); ?>">
                                Contactos <span class="badge text-bg-warning">4</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Dropdown para opciones del administrador -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url() ?><?= route_to('logout'); ?>">Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.collapse -->
    </div><!-- /.container-fluid -->
</nav>