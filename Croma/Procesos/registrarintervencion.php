<?php
require_once __DIR__ . '/../Datos/Clases/ClassIntervencion.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_serie = $_POST['numero_serie'];
    $fecha = $_POST['fecha'] ?: date('Y-m-d');
    $descripcion = $_POST['descripcion'];
    $tecnico = $_SESSION['usuarioActivo']['nombre'] ?? null;
    $solucion = $_POST['solucion'] ?? null;

    $intervencion = new Intervencion($conexion, $numero_serie, $fecha, $descripcion, $tecnico, $solucion);
    $ok = $intervencion->registrar();

    if ($ok) {
        header("Location: ../Presentacion/html/inventario.php?mensaje=" . urlencode("Intervención registrada correctamente") . "&tipo=exito");
    } else {
        header("Location: ../Presentacion/html/inventario.php?mensaje=" . urlencode("No se pudo registrar la intervención") . "&tipo=error");
    }
    exit;
}