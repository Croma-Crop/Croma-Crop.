<?php

require_once __DIR__ . '/../../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../../Datos/Clases/ClassSolicitud.php';
require_once __DIR__ . '/../../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../../Datos/DataBase/ConexionMYSQL/conexion.php';

$incidencias = Incidencia::mostrar($conexion);
$solicitudes = Solicitud::mostrar($conexion);
$usuarios = Usuario::mostrar($conexion);
$equiposRegistrados = Inventario::mostrarTodos($conexion);

$nombresPorDocumento = [];
foreach ($usuarios as $usuarioRegistrado) {
    $nombresPorDocumento[$usuarioRegistrado['documento']] = $usuarioRegistrado['nombre'] . ' ' . $usuarioRegistrado['apellido'];
}

$equiposPorSerie = [];
foreach ($equiposRegistrados as $equipoRegistrado) {
    $equiposPorSerie[$equipoRegistrado['numero_serie']] = $equipoRegistrado;
}

$tickets = [];

foreach ($incidencias as $incidencia) {

    $equipoNombre = "-";
    $equipoMarca = "-";
    $equipoModelo = "-";

    if ($incidencia['numero_serie'] !== null && isset($equiposPorSerie[$incidencia['numero_serie']])) {
        $equipoDelTicket = $equiposPorSerie[$incidencia['numero_serie']];
        $equipoNombre = $equipoDelTicket['nombre'];
        $equipoMarca = $equipoDelTicket['marca'];
        $equipoModelo = $equipoDelTicket['modelo'];
    }

    $tickets[] = [
        'clase'           => 'Incidencia',
        'id'              => $incidencia['id_incidencia'],
        'tipo'            => $incidencia['tipo'],
        'fecha'           => $incidencia['fecha'],
        'turno'           => $incidencia['turno'],
        'prioridad'       => $incidencia['prioridad'],
        'descripcion'     => $incidencia['descripcion'],
        'estado'          => $incidencia['estado'],
        'nombre_software' => null,
        'hora_inicio'     => null,
        'hora_fin'        => null,
        'numero_serie'    => $incidencia['numero_serie'],
        'equipoNombre'    => $equipoNombre,
        'equipoMarca'     => $equipoMarca,
        'equipoModelo'    => $equipoModelo,
        'nombreProf'      => $nombresPorDocumento[$incidencia['cedula_solicitante']] ?? $incidencia['cedula_solicitante'],
        'nombreTecnico'   => $incidencia['cedula_tecnico'] ? ($nombresPorDocumento[$incidencia['cedula_tecnico']] ?? $incidencia['cedula_tecnico']) : 'Sin asignar',
    ];
}

foreach ($solicitudes as $solicitud) {
    $tickets[] = [
        'clase'           => 'Solicitud',
        'id'              => $solicitud['id_solicitud'],
        'tipo'            => $solicitud['tipo'],
        'fecha'           => $solicitud['fecha'],
        'turno'           => null,
        'prioridad'       => null,
        'descripcion'     => $solicitud['descripcion'],
        'estado'          => $solicitud['estado'],
        'nombre_software' => $solicitud['nombre_software'],
        'hora_inicio'     => $solicitud['hora_inicio'],
        'hora_fin'        => $solicitud['hora_fin'],
        'numero_serie'    => null,
        'equipoNombre'    => null,
        'equipoMarca'     => null,
        'equipoModelo'    => null,
        'nombreProf'      => $nombresPorDocumento[$solicitud['cedula_solicitante']] ?? $solicitud['cedula_solicitante'],
        'nombreTecnico'   => $solicitud['cedula_tecnico'] ? ($nombresPorDocumento[$solicitud['cedula_tecnico']] ?? $solicitud['cedula_tecnico']) : 'Sin asignar',
    ];
}
