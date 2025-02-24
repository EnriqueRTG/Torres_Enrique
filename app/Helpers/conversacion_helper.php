<?php

if (!function_exists('get_conteo_pendientes')) {
    function get_conteo_pendientes()
    {
        $conversacionModel = new \App\Models\ConversacionModel();
        $consultas = $conversacionModel->contarConversacionesPorTipoYEstado('consulta', 'abierto');
        $contactos = $conversacionModel->contarConversacionesPorTipoYEstado('contacto', 'abierto');
        return [
            'consultasPendientes' => $consultas,
            'contactosPendientes' => $contactos,
            'totalPendientes' => $consultas + $contactos,
        ];
    }
}
