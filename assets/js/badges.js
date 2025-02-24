/**
 * Función que actualiza dinámicamente los badges de mensajes pendientes.
 * Realiza una solicitud AJAX al endpoint que devuelve el conteo de mensajes pendientes
 * y actualiza (o crea) los elementos del DOM correspondientes.
 */
function actualizarConteoPendientes() {
    fetch(base_url + "admin/conversaciones/conteoPendientes", {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            // Actualizar badge total de mensajes pendientes
            let badgeTotal = document.getElementById('badgeTotalPendientes');
            if (!badgeTotal) {
                // Si el badge no existe, créalo y añádelo al contenedor (por ejemplo, al elemento con id "messagesDropdown")
                const messagesDropdown = document.getElementById('messagesDropdown');
                badgeTotal = document.createElement('span');
                badgeTotal.id = 'badgeTotalPendientes';
                badgeTotal.className = 'top-0 translate-middle badge rounded-pill bg-danger';
                messagesDropdown.appendChild(badgeTotal);
            }
            // Actualiza el texto, incluso si es "0"
            badgeTotal.textContent = data.totalPendientes;

            // Actualizar badge para Consultas
            let badgeConsultas = document.getElementById('badgeConsultas');
            if (!badgeConsultas) {
                // Buscar el enlace de consultas y agregar el badge
                const consultaLink = document.querySelector('a[href*="/admin/conversaciones/consultas"]');
                badgeConsultas = document.createElement('span');
                badgeConsultas.id = 'badgeConsultas';
                badgeConsultas.className = 'badge text-bg-warning';
                consultaLink.appendChild(badgeConsultas);
            }
            badgeConsultas.textContent = data.consultasPendientes;

            // Actualizar badge para Contactos
            let badgeContactos = document.getElementById('badgeContactos');
            if (!badgeContactos) {
                // Buscar el enlace de contactos y agregar el badge
                const contactosLink = document.querySelector('a[href*="/admin/conversaciones/contactos"]');
                badgeContactos = document.createElement('span');
                badgeContactos.id = 'badgeContactos';
                badgeContactos.className = 'badge text-bg-warning';
                contactosLink.appendChild(badgeContactos);
            }
            badgeContactos.textContent = data.contactosPendientes;
        })
        .catch(error => {
            console.error('Error actualizando conteo pendientes:', error);
        });
}

// Llama a la función inmediatamente para actualizar al cargar la página
actualizarConteoPendientes();

// Actualiza el conteo cada 60 segundos (60000 milisegundos)
setInterval(actualizarConteoPendientes, 60000);
