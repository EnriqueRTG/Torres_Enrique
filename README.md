# 🖋️ Tattoo Supply Store

E-commerce de insumos y suministros para la industria del tatuaje, desarrollado en **PHP con CodeIgniter 4** y **MySQL**, con arquitectura **MVC**.

Proyecto individual para la materia **Taller de Programación I** de la Licenciatura en Sistemas de Información (FaCENA – UNNE). El documento de requerimientos (ERS) está incluido en el repositorio: [`ERS - Taller de Programacion 1.pdf`](ERS%20-%20Taller%20de%20Programacion%201.pdf).

> Proyecto académico. Los datos de ejemplo (usuarios, órdenes, mensajes) son ficticios.

## Funcionalidades

### Sitio público y clientes
- Catálogo de productos con **filtros** (categoría, marca), **búsqueda con sugerencias** y **paginación**.
- Ficha de producto con múltiples imágenes.
- **Registro e inicio de sesión** con contraseñas hasheadas (`password_hash`).
- **Carrito de compras** con control de stock: la cantidad se ajusta al stock disponible y avisa cuando quedan pocas unidades.
- **Checkout** con selección o alta de dirección de envío y confirmación del pedido.
- Perfil del cliente, gestión de direcciones e historial de pedidos (con filtros, búsqueda, cancelación y comprobante en **PDF**).
- Formulario de contacto y **mensajería interna** con el administrador.
- Páginas institucionales: nosotros, formas de pago, garantía, términos y ubicación.

### Panel de administración
- Dashboard.
- **CRUD** de productos (con carga de varias imágenes), categorías y marcas.
- Gestión de **órdenes**: listado con filtros y búsqueda, detalle, cancelar, completar e imprimir comprobante.
- Gestión de **clientes**: listado, detalle, órdenes y conversaciones de cada uno.
- **Conversaciones**: contactos y consultas, con respuestas enviadas por correo electrónico y contador de pendientes.

### Aspectos técnicos destacados
- Creación de la orden dentro de una **transacción de base de datos** (`transBegin` / `transCommit`): si falla la actualización de stock o algún detalle, se revierte todo.
- **Filtros de acceso** por rol (`AuthAdminFilter`, `AuthClienteFilter`) y filtro de carrito.
- Base de datos relacional con **11 tablas**, claves foráneas, **migraciones** y **seeders** (datos de prueba con Faker).
- Entidades y modelos de CodeIgniter con Query Builder.
- Generación de PDF con **dompdf**, migas de pan con `ci4-breadcrumbs` y envío de correo por SMTP.

## Tecnologías

| Área | Tecnología |
|------|-----------|
| Backend | PHP 8.1+, CodeIgniter 4.5 |
| Base de datos | MySQL / MariaDB |
| Frontend | HTML, CSS, JavaScript, jQuery, Bootstrap |
| Librerías | dompdf, ci4-breadcrumbs, módulo de carrito para CI4 |
| Herramientas | Composer, Git, XAMPP (desarrollo) |

## Estructura del proyecto

```
app/
├── Config/          # Rutas, filtros, base de datos, correo, datos de la empresa
├── Controllers/
│   ├── Admin/       # Panel de administración
│   ├── Auth/        # Login y registro
│   ├── Cliente/     # Perfil, direcciones, pedidos y mensajes del cliente
│   └── Web/         # Sitio público, carrito y checkout
├── Database/
│   ├── Migrations/  # Estructura de tablas
│   └── Seeds/       # Datos de prueba
├── Entities/        # Entidades
├── Filters/         # Filtros de autenticación y carrito
├── Models/          # Modelos
└── Views/           # Vistas (admin, web, auth, layouts, partials)
assets/              # CSS, JS, imágenes e íconos
uploads/productos/   # Imágenes de productos
torres_enrique_bd.sql  # Volcado de la base de datos con datos de ejemplo
```

## Instalación

### Requisitos
- PHP 8.1 o superior con las extensiones `intl`, `mbstring`, `mysqli` y `gd`
- MySQL o MariaDB
- Composer
- Apache (por ejemplo XAMPP) con `mod_rewrite` habilitado

### Pasos

1. **Clonar el repositorio** dentro de la carpeta pública de tu servidor (en XAMPP: `htdocs`):

   ```bash
   git clone https://github.com/EnriqueRTG/Torres_Enrique.git
   cd Torres_Enrique
   ```

2. **Instalar dependencias:**

   ```bash
   composer install
   ```

3. **Crear el archivo de entorno** a partir del ejemplo:

   ```bash
   cp .env.example .env
   ```

   Editá `.env` y ajustá `app.baseURL` a la URL donde corre el proyecto (por defecto `http://localhost/Torres_Enrique/`). Si querés probar el envío de correos, completá `SMTP_PASS` con una contraseña de aplicación de tu cuenta de Gmail.

4. **Crear la base de datos.** Hay dos opciones:

   **a) Importar el volcado (rápido, incluye datos de ejemplo):**

   ```sql
   CREATE DATABASE torres_enrique_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```
   Luego importá `torres_enrique_bd.sql` desde phpMyAdmin o con:
   ```bash
   mysql -u root torres_enrique_bd < torres_enrique_bd.sql
   ```

   **b) Con migraciones y seeders:**

   ```bash
   php spark migrate
   php spark db:seed DataBaseSeeder
   ```

5. **Revisar la conexión** en `app/Config/Database.php` (por defecto: host `localhost`, usuario `root`, sin contraseña, base `torres_enrique_bd`).

6. **Dar permisos de escritura** a las carpetas `writable/` y `uploads/` si estás en Linux/macOS.

7. **Abrir** `http://localhost/Torres_Enrique/` en el navegador.

## Usuarios de prueba

| Rol | Email | Contraseña |
|-----|-------|-----------|
| Administrador | `admin@example.com.org` | `admin123` |
| Cliente | cualquier cliente del listado (ver tabla `usuarios`) | `password123` |

Acceso al panel: `/admin/dashboard` (solo rol administrador).

> Estas credenciales son únicamente para pruebas locales.

## Capturas de pantalla

<!-- Agregá tus capturas en docs/screenshots/ y enlazalas acá. Ejemplo: -->
<!-- ![Catálogo](docs/screenshots/catalogo.png) -->
<!-- ![Carrito](docs/screenshots/carrito.png) -->
<!-- ![Panel de administración](docs/screenshots/dashboard.png) -->

## Documentación

- [ERS – Especificación de Requerimientos de Software](ERS%20-%20Taller%20de%20Programacion%201.pdf)
- Diagrama y estructura de la base de datos: ver `app/Database/Migrations/` y `torres_enrique_bd.sql`.

## Posibles mejoras

- Pasarela de pagos real (hoy el pago se coordina fuera del sistema).
- Pruebas automatizadas del flujo de compra.
- Cambiar las acciones de cancelar/completar a métodos POST y activar la protección CSRF de forma global.
- Baja lógica en lugar de borrado en cascada para órdenes y productos.

## Autor

**Enrique Ramón Torres Gamarra**
Estudiante de Licenciatura en Sistemas de Información – UNNE
GitHub: [@EnriqueRTG](https://github.com/EnriqueRTG)

## Licencia

El framework CodeIgniter 4 se distribuye bajo licencia MIT (ver [`LICENSE`](LICENSE)). El código propio de este proyecto es de uso académico.
