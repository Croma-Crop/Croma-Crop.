<?php
require_once '../../Datos/Clases/ClassIncidencia.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'] ?: date('Y-m-d');
    $salon = $_POST['salon'];
    $serie = $_POST['serie'];
    $turno = $_POST['turno'] ?? null;
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    if ($salon === '') {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Seleccione un salón.") . "&tipo=error");
        exit;
    }
    if ($serie === '') {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Seleccione un equipo del salón.") . "&tipo=error");
        exit;
    }

    $cedulaSolicitante = $_SESSION['usuarioActivo']['documento'] ?? null;

    $incidencia = new Incidencia(
        $conexion, null, $fecha, $descripcion, "Sin asignar", $turno, null, null, "Pendiente", NULL);

    $ok = $incidencia->guardar($cedulaSolicitante, $tipo);

    if ($ok) {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Incidencia registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("No se pudo registrar la incidencia") . "&tipo=error");
    }
    exit;
}