<?php

$moduloRequerido = "inventario";
require_once __DIR__ . "/backend/guardia.php";
require_once __DIR__ . "/backend/sanitizar.php";

require_once __DIR__ . '/../Datos/Clases/ClassIntervencion.php';
require_once __DIR__ . '/../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero_serie = limpiarSerie($_POST['numero_serie'] ?? '');
    $fecha = limpiarFecha($_POST['fecha'] ?? '');
    $descripcion = limpiarTexto($_POST['descripcion'] ?? '');
    $solucion = limpiarTexto($_POST['solucion'] ?? '');
    $tecnico = $_SESSION['usuarioActivo']['documento'] ?? null;

    if ($fecha === '') {
        $fecha = date('Y-m-d');
    }

    if ($solucion === '') {
        $solucion = null;
    }

    $mensajeError = "";

    if ($numero_serie === '') {
        $mensajeError = "Falta el numero de serie del equipo";
    }

    if ($mensajeError === "" && $descripcion === '') {
        $mensajeError = "Escribí el error encontrado";
    }

    if ($mensajeError === "") {
        $consultaEquipo = new Inventario($conexion, $numero_serie, "", "", "", "", null, null);

        if ($consultaEquipo->buscarEstado($numero_serie) === "") {
            $mensajeError = "El equipo no existe en el inventario";
        }
    }

    if ($mensajeError !== "") {
        header("Location: ../Presentacion/html/inventario.php?mensaje=" . urlencode($mensajeError) . "&tipo=error");
        exit;
    }

    $intervencion = new Intervencion($conexion, $numero_serie, $fecha, $descripcion, $tecnico, $solucion);
    $ok = $intervencion->registrar();

    if ($ok) {
        header("Location: ../Presentacion/html/inventario.php?mensaje=" . urlencode("Intervención registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../Presentacion/html/inventario.php?mensaje=" . urlencode("No se pudo registrar la intervención") . "&tipo=error");
    }
    exit;
}
