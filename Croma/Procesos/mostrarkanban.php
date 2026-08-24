<?php

require_once __DIR__ . '/../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../Datos/Clases/ClassSolicitud.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$incidencias = Incidencia::mostrar($conexion);
$solicitudes = Solicitud::mostrar($conexion);
$usuarios = Usuario::mostrar();

$nombresPorDocumento = [];
$tecnicos = [];
foreach ($usuarios as $usuario) {
    $nombresPorDocumento[$usuario['documento']] = $usuario['nombre'] . ' ' . $usuario['apellido'];
    if ($usuario['rol'] === 'tecnico') {
        $tecnicos[] = $usuario;
    }
}

$tickets = [];

foreach ($incidencias as $incidencia) {
    $tickets[] = [
        'clase'          => 'Incidencia',
        'id'             => $incidencia['id_incidencia'],
        'tipo'           => $incidencia['tipo'],
        'fecha'          => $incidencia['fecha'],
        'turno'          => $incidencia['turno'],
        'prioridad'      => $incidencia['prioridad'],
        'descripcion'    => $incidencia['descripcion'],
        'estado'         => $incidencia['estado'],
        'numero_serie'   => $incidencia['numero_serie'],
        'cedula_tecnico' => $incidencia['cedula_tecnico'],
        'nombreProf'     => $nombresPorDocumento[$incidencia['cedula_solicitante']] ?? $incidencia['cedula_solicitante'],
        'nombreTecnico'  => $incidencia['cedula_tecnico'] ? ($nombresPorDocumento[$incidencia['cedula_tecnico']] ?? $incidencia['cedula_tecnico']) : 'Sin asignar',
    ];
}

foreach ($solicitudes as $solicitud) {
    $tickets[] = [
        'clase'          => 'Solicitud',
        'id'             => $solicitud['id_solicitud'],
        'tipo'           => $solicitud['tipo'],
        'fecha'          => null,
        'turno'          => null,
        'prioridad'      => null,
        'descripcion'    => $solicitud['descripcion'],
        'estado'         => $solicitud['estado'],
        'numero_serie'   => null,
        'cedula_tecnico' => $solicitud['cedula_tecnico'],
        'nombreProf'     => $nombresPorDocumento[$solicitud['cedula_solicitante']] ?? $solicitud['cedula_solicitante'],
        'nombreTecnico'  => $solicitud['cedula_tecnico'] ? ($nombresPorDocumento[$solicitud['cedula_tecnico']] ?? $solicitud['cedula_tecnico']) : 'Sin asignar',
    ];
}

$puedeClasificar = puedeHacer("asignarPrioridad", $_SESSION["rol"]);
$miDocumento = $_SESSION['usuarioActivo']['documento'] ?? '';