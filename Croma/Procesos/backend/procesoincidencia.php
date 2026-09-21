<?php

$moduloRequerido = "tickets";
require_once __DIR__ . "/guardia.php";
require_once __DIR__ . "/sanitizar.php";

require_once '../../Datos/Clases/ClassIncidencia.php';
require_once '../../Datos/Clases/ClassInventario.php';
require_once '../../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fecha = limpiarFecha($_POST['fecha'] ?? '');
    $salon = limpiarEntero($_POST['salon'] ?? '');
    $serie = limpiarSerie($_POST['serie'] ?? '');
    $turno = limpiarOpcion($_POST['turno'] ?? '', ["matutino", "vespertino", "nocturno"]);
    $tipo = limpiarOpcion($_POST['tipo'] ?? '', ["Computadora", "Televisor", "Periferico", "Otro"]);
    $descripcion = limpiarTexto($_POST['descripcion'] ?? '');

    if ($fecha === '') {
        $fecha = date('Y-m-d');
    }

    $mensajeError = "";

    if ($salon === '') {
        $mensajeError = "Seleccione un salón.";
    }

    if ($mensajeError === "" && $serie === '') {
        $mensajeError = "Seleccione un equipo del salón.";
    }

    if ($mensajeError === "" && $tipo === '') {
        $mensajeError = "Seleccione el tipo de incidencia.";
    }

    if ($mensajeError === "" && $turno === '') {
        $mensajeError = "Seleccione un turno.";
    }

    if ($mensajeError === "" && $descripcion === '') {
        $mensajeError = "Escribí cuál es la incidencia.";
    }

    if ($mensajeError === "") {
        $consultaEquipo = new Inventario($conexion, $serie, "", "", "", "", null, null);
        $estadoEquipo = $consultaEquipo->buscarEstado($serie);

        if ($estadoEquipo === "") {
            $mensajeError = "El equipo seleccionado no existe en el inventario.";
        } elseif ($estadoEquipo === "de_baja") {
            $mensajeError = "El equipo seleccionado está dado de baja, no se le pueden registrar incidencias.";
        }
    }

    if ($mensajeError !== "") {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode($mensajeError) . "&tipo=error");
        exit;
    }

    $cedulaSolicitante = $_SESSION['usuarioActivo']['documento'] ?? null;

    $escalada = Incidencia::escalarPorRepeticion($conexion, $serie, $descripcion);
    $gravedad = $escalada['gravedad'];
    $repetidas = $escalada['repetidas'];

    $incidencia = new Incidencia(
        $conexion, null, $fecha, $descripcion, $gravedad, $turno, null, null, "Pendiente", $serie);

    $ok = $incidencia->guardar($tipo, $cedulaSolicitante);

    if ($ok && $repetidas > 0) {
        $aviso = "Este equipo ya tenía " . $repetidas . " incidencia(s) igual(es) sin resolver, la gravedad subió a " . $gravedad;
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode($aviso) . "&tipo=exito");
    } elseif ($ok) {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("Incidencia registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../../Presentacion/html/tickets.php?mensaje=" . urlencode("No se pudo registrar la incidencia") . "&tipo=error");
    }
    exit;
}
