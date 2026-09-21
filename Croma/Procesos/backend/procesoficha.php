<?php

$moduloRequerido = "ficha";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";

require_once __DIR__ . '/../../Datos/Clases/ClassFicha.php';
require_once __DIR__ . '/../../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fecha = limpiarFecha($_POST['fecha'] ?? '');
    $horaEntrada = limpiarHora($_POST['hora_entrada'] ?? '');
    $horaSalida = limpiarHora($_POST['hora_salida'] ?? '');
    $id_salon = limpiarEntero($_POST['id_salon'] ?? '');
    $documentoProfesor = limpiarDocumento($_POST['documento_profesor'] ?? '');
    $turno = limpiarOpcion($_POST['turno'] ?? '', ["Matutino", "Vespertino", "Nocturno"]);
    $incidencias = $_POST['incidencias'] ?? [];

    if (!is_array($incidencias)) {
        $incidencias = [];
    }

    if ($fecha === '') {
        $fecha = date('Y-m-d');
    }

    $mensajeError = "";

    if ($documentoProfesor === '') {
        $mensajeError = "Seleccione un profesor.";
    }

    if ($mensajeError === "" && $id_salon === '') {
        $mensajeError = "Seleccione un salón.";
    }

    if ($mensajeError === "" && $turno === '') {
        $mensajeError = "Seleccione un turno.";
    }

    if ($mensajeError === "" && $horaEntrada === '') {
        $mensajeError = "Indicá la hora de entrada.";
    }

    if ($mensajeError === "" && $horaSalida === '') {
        $mensajeError = "Indicá la hora de salida.";
    }

    if ($mensajeError === "" && $horaSalida <= $horaEntrada) {
        $mensajeError = "La hora de salida tiene que ser posterior a la de entrada.";
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode($mensajeError) . "&tipo=error");
        exit;
    }

    $turnoGuardado = strtolower($turno);

    $ficha = new Ficha($conexion, null, $fecha, $horaEntrada, $horaSalida, $documentoProfesor, $id_salon);
    $ok = $ficha->guardar();

    if ($ok) {
        foreach ($incidencias as $serie => $datos) {

            if (!is_array($datos)) {
                continue;
            }

            $serieLimpia = limpiarSerie($serie);
            $tipoLimpio = limpiarOpcion($datos['tipo'] ?? '', ["Computadora", "Televisor", "Periferico", "Otro"]);
            $descripcionLimpia = limpiarTexto($datos['descripcion'] ?? '');

            if ($serieLimpia === '' || $tipoLimpio === '') {
                continue;
            }

            $escalada = Incidencia::escalarPorRepeticion($conexion, $serieLimpia, $descripcionLimpia);

            $incidencia = new Incidencia($conexion, null, $fecha, $descripcionLimpia, $escalada['gravedad'], $turnoGuardado, null, null, "Pendiente", $serieLimpia);
            $incidencia->guardar($tipoLimpio, $documentoProfesor);
        }

        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("Ficha registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/usuario/ficha.php?mensaje=" . urlencode("No se pudo registrar la ficha") . "&tipo=error");
    }
    exit;
}
