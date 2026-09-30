<?php

require_once __DIR__ . '/../Datos/Clases/ClassSolicitudUsuario.php';
require_once __DIR__ . '/../Datos/Clases/ClassSolicitudUsuarioextranjero.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$solicitudesPendientes = SolicitudUsuario::mostrarPendientes($conexion);
$solicitudesResueltas = SolicitudUsuario::mostrarResueltas($conexion);
$solicitudesPendientesextranjeras = SolicitudUsuarioextranjero::mostrarPendientes($conexion);
$solicitudesResueltasextranjeras = SolicitudUsuarioextranjero::mostrarResueltas($conexion);
foreach ($solicitudesPendientesextranjeras as $i => $s) {
    $solicitudesPendientesextranjeras[$i]['tipo'] = 'extranjero';
}

$todosPendientes = array_merge($solicitudesPendientes, $solicitudesPendientesextranjeras);
$todosResueltas = array_merge($solicitudesResueltas, $solicitudesResueltasextranjeras);
