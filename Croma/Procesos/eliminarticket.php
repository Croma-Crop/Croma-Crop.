<?php

$moduloRequerido = "tickets";
require_once __DIR__ . "/backend/guardia.php";

require_once __DIR__ . '/../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../Datos/Clases/ClassSolicitud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!puedeHacer("eliminarTickets", $_SESSION["rol"])) {
        header("Location: ../Presentacion/html/incidenciascreadas.php?mensaje=" . urlencode("No tenés permiso para eliminar tickets") . "&tipo=error");
        exit;
    }

    $clase = $_POST['clase'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($clase === '' || $id === '') {
        header("Location: ../Presentacion/html/incidenciascreadas.php?mensaje=" . urlencode("Faltan datos para eliminar el ticket") . "&tipo=error");
        exit;
    }

    if ($clase === 'Incidencia') {
        $incidencia = new Incidencia($conexion, $id, "", "", "", "", null, null);
        $ok = $incidencia->borrar($id);
    } elseif ($clase === 'Solicitud') {
        $solicitud = new Solicitud($conexion, $id, "", "", null);
        $ok = $solicitud->borrar($id);
    } else {
        $ok = false;
    }

    if ($ok) {
        header("Location: ../Presentacion/html/incidenciascreadas.php?mensaje=" . urlencode("Ticket eliminado correctamente") . "&tipo=exito");
    } else {
        header("Location: ../Presentacion/html/incidenciascreadas.php?mensaje=" . urlencode("No se pudo eliminar el ticket") . "&tipo=error");
    }
    exit;
}