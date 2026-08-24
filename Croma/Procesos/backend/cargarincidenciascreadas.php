<?php

require_once __DIR__ . '/../../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../../Datos/Clases/ClassSolicitud.php';
require_once __DIR__ . '/../../Datos/DataBase/ConexionMYSQL/conexion.php';

$incidencias = Incidencia::mostrar($conexion);
$solicitudes = Solicitud::mostrar($conexion);

$tickets = [];

foreach ($incidencias as $incidencia) {
    $tickets[] = [
        'clase'       => 'Incidencia',
        'id'          => $incidencia['id_incidencia'],
        'tipo'        => $incidencia['tipo'],
        'fecha'       => $incidencia['fecha'],
        'turno'       => $incidencia['turno'],
        'prioridad'   => $incidencia['prioridad'],
        'descripcion' => $incidencia['descripcion'],
        'estado'      => $incidencia['estado'],
    ];
}

foreach ($solicitudes as $solicitud) {
    $tickets[] = [
        'clase'       => 'Solicitud',
        'id'          => $solicitud['id_solicitud'],
        'tipo'        => $solicitud['tipo'],
        'fecha'       => null,
        'turno'       => null,
        'prioridad'   => null,
        'descripcion' => $solicitud['descripcion'],
        'estado'      => $solicitud['estado'],
    ];
}
