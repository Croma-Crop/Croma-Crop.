<?php

$moduloRequerido = "tickets";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";

require_once '../../Datos/Clases/ClassSolicitud.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipo = limpiarOpcion($_POST['tipo'] ?? '', ["Instalacion de Software", "Reserva de Salon"]);
    $id_salon = limpiarEntero($_POST['id_salon'] ?? '');
    $descripcion = limpiarTexto($_POST['descripcion'] ?? '');
    $nombreSoftware = limpiarTextoCorto($_POST['nombre_software'] ?? '', 100);
    $documentoIngresado = limpiarDocumento($_POST['documento_identidad'] ?? '');
    $fecha = limpiarFecha($_POST['fecha'] ?? '');
    $horaInicio = limpiarHora($_POST['hora_inicio'] ?? '');
    $horaFin = limpiarHora($_POST['hora_fin'] ?? '');

    $cedulaSolicitante = $_SESSION['usuarioActivo']['documento'] ?? '';

    $mensajeError = "";

    if ($tipo === '') {
        $mensajeError = "Seleccione el tipo de solicitud.";
    }

    if ($mensajeError === "" && $id_salon === '') {
        $mensajeError = "Seleccione un salón.";
    }

    if ($mensajeError === "" && $descripcion === '') {
        $mensajeError = "Escribí el motivo de la solicitud.";
    }

    if ($mensajeError === "" && $tipo === "Instalacion de Software") {

        if ($nombreSoftware === '') {
            $mensajeError = "Indicá el nombre del software.";
        } elseif ($documentoIngresado === '') {
            $mensajeError = "Indicá tu documento de identidad.";
        } elseif ($documentoIngresado !== $cedulaSolicitante) {
            $mensajeError = "El documento no coincide con el de tu usuario.";
        }
    }

    if ($mensajeError === "" && $tipo === "Reserva de Salon") {

        if ($fecha === '') {
            $mensajeError = "Indicá la fecha de uso del salón.";
        } elseif ($horaInicio === '') {
            $mensajeError = "Indicá la hora de inicio.";
        } elseif ($horaFin === '') {
            $mensajeError = "Indicá la hora de finalización.";
        } elseif ($horaFin <= $horaInicio) {
            $mensajeError = "La hora de finalización tiene que ser posterior a la de inicio.";
        }
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode($mensajeError) . "&tipo=error");
        exit;
    }

    if ($tipo === "Instalacion de Software") {
        $fecha = null;
        $horaInicio = null;
        $horaFin = null;
    } else {
        $nombreSoftware = null;
    }

    $solicitud = new Solicitud(
        $conexion,
        null,
        $tipo,
        $descripcion,
        $id_salon,
        null,
        "Pendiente",
        $nombreSoftware,
        $fecha,
        $horaInicio,
        $horaFin
    );

    $ok = $solicitud->guardar($cedulaSolicitante);

    if ($ok) {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Solicitud registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("No se pudo registrar la solicitud") . "&tipo=error");
    }
    exit;
}

?>
