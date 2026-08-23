<?php

$moduloRequerido = "ficha";
require_once __DIR__ . "/guardia.php";

require_once __DIR__ . '/../../Datos/Clases/ClassFicha.php';
require_once __DIR__ . '/../../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'] ?: date('Y-m-d');
    $horaEntrada = $_POST['hora_entrada'] ?? '';
    $horaSalida = $_POST['hora_salida'] ?? '';
    $id_salon = $_POST['id_salon'] ?? '';
    $documentoProfesor = $_POST['documento_profesor'] ?? '';
    $turno = $_POST['turno'] ?? '';
    $incidencias = $_POST['incidencias'] ?? [];

    if ($documentoProfesor === '') {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("Seleccione un profesor.") . "&tipo=error");
        exit;
    }
    if ($id_salon === '') {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("Seleccione un salón.") . "&tipo=error");
        exit;
    }
    if ($turno === '') {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("Seleccione un turno.") . "&tipo=error");
        exit;
    }

    $ficha = new Ficha($conexion, null, $fecha, $horaEntrada, $horaSalida, $documentoProfesor, $id_salon);
    $ok = $ficha->guardar();

    if ($ok) {
        foreach ($incidencias as $serie => $datos) {
            $incidencia = new Incidencia($conexion, null, $fecha, $datos['descripcion'] ?? '', "Sin asignar", $turno, null, null, "Pendiente", $serie);
            $incidencia->guardar($datos['tipo'] ?? '', $documentoProfesor);
        }

        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("Ficha registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("No se pudo registrar la ficha") . "&tipo=error");
    }
    exit;
}